<?php

namespace App\Http\Controllers;

use App\Model\Address;
use App\Model\Delivery;
use App\Model\MapColorSize;
use App\Model\Paytm;
use App\Model\Shop;
use App\Model\Transaction;
use App\Model\TxnMasterGst;
use App\Model\TxnOrder;
use App\Model\TxnOrderDetail;
use App\Model\TxnUser;
use App\Services\LogisticService;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        if (Cart::getContent()->count() <= 0) {

            connectify('error', 'Add Item', 'Please Add few Product in your cart first !');

            return redirect(route('search'));
        }
        $addresses = [];
        if (auth('user')->check()) {

            $addresses = Address::where('user_id', auth('user')->user()->id)->get();
        }

        $promocodes = DB::table('txn_users')->select('*')->where('elite', true)->inRandomOrder()->limit(5)->get();
        $coupons = \App\Model\Coupon::where('status', true)->get();
        return view('frontend.order.checkout', compact('promocodes', 'addresses', 'coupons'));
    }

    public function checkout(Request $request, LogisticService $logistic)
    {
        Log::info('Checkout request data: ' . json_encode($request->all()));

        $validator = Validator::make(
            $request->all(),
            [
                'payment_mode' => 'required',
                'pincode' => 'required|digits:6',
                'choose_address' => 'required|numeric|min:1|exists:addresses,id',
            ],
            [
                'payment_mode.required' => 'Please Select Any of the Payment Mode !',
                'pincode.required' => 'Please Enter Pincode',
                'pincode.digits' => 'Pincode should be of 6 digits',
                'choose_address.required' => 'Please Choose Any Address',
                'choose_address.numeric' => 'Invalid Address provided',
                'choose_address.min' => 'Invalid Address provided',
                'choose_address.exists' => 'Address does not exists',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Checkout Error', $validator->errors()->first());
            return redirect(route('checkout'))->withInput();
        }

        $res = $logistic->verify($request->pincode);
        $res1 = json_decode($res, true);

        if (isset($res1['status']) && $res1['status'] == 200) {

            $cartTotalQuantity = Cart::getTotalQuantity();

            $total = 0;
            $user = auth('user')->user();
            $cod = false;
            $totalGst = 0;
            $promocode = null;
            $is_valid_promocode = false;
            $is_discount = false;
            $gst_value = 0;
            if ($request->session()->has('promocode_new')) {
                $coupon = $request->session()->pull('promocode_new');
                if ($coupon) {
                    $promocode = $coupon->code;
                    $is_valid_promocode = true;
                    $is_discount = true;
                    // We'll calculate the actual discount amount after calculating $total
                }
            } elseif ($request->session()->has('promocode')) {
                // $a = $request->session()->get('promocode');
                $a = $request->session()->pull('promocode', 'default');
                if (isset($a['promocode']) && $a['promocode']) {
                    $promo = TxnUser::select('promocode')->where('promocode', $a['promocode'])->first();
                    $promocode = $promo['promocode'];
                } elseif (isset($a['shop_code']) && $a['shop_code']) {
                    $promo = Shop::select('shop_code')->where('shop_code', $a['shop_code'])->where('status', true)->first();
                    $promocode = $promo['shop_code'];
                    $is_valid_promocode = true;
                    $is_discount = true;
                }
            }

            foreach (Cart::getContent() as $item) {

                $size = MapColorSize::select(['*'])->where('id', $item->attributes->map_id)->first();

                $total += $size->mrp * $item->quantity;

                $gst = TxnMasterGst::where('id', $size->product->gst_id)->first();

                $gst_value = $gst ? 1 + ($gst->gst_value / 100) : 1;

                // $before_gst_price = round($size->mrp / $gst_value);

                // $totalGst += round(($size->mrp - $before_gst_price) * $item->quantity);

            }
            if ($request->payment_mode === 'cod') {
                $cod = true;
            }

            $request['status'] = 'nc';

            $request['payment_mode'] = $cod ? 'cod' : $request->payment_mode;

            $request['shipingcharge'] = 0;

            if (isset($coupon) && $coupon) {
                if ($coupon->type == 'percentage') {
                    $request['discount'] = round($total * ($coupon->value / 100), 2);
                } else {
                    $request['discount'] = $coupon->value;
                }
            } else {
                $request['discount'] = $is_valid_promocode ? round($total * 0.10, 2) : 0;
            }

            $balance = $total - $request->discount;

            if ($total < 1000) {
                $request['shipingcharge'] = 60;
                $balance = $balance + $request->shipingcharge;
            }

            $request['tbt'] = round($balance / $gst_value, 2);

            $request['tax'] = round($balance - $request->tbt, 2);

            $add = Address::where('id', $request->choose_address)->first();

            $order = TxnOrder::create([
                'total' => $balance,
                'status' => $request->status,
                'user_id' => $user->id,
                'user_name' => $add->name,
                'promocode' => $promocode,
                'discount' => $request->discount,
                'address' => $add->address,
                'pincode' => $add->pincode,
                'city' => $add->city,
                'territory' => $add->territory,
                'landmark' => $add->landmark,
                'country' => $add->country,
                'type_of_address' => $add->type_of_address,
                'tbt' => $request->tbt,
                'tax' => $request->tax,
                'payment_mode' => $request->payment_mode,
                'payment_status' => "Pending",
                'is_discount' => $is_discount,
            ]);

            $user->update([
                'address' => $add->address,
                'city' => $add->city,
                'territory' => $add->territory,
                'landmark' => $add->landmark,
                'pincode' => $add->pincode,
                'country' => $add->country,
                'address_id' => $add->id,
                'mobile' => $add->mobile,
            ]);

            foreach (Cart::getContent() as $item) {

                TxnOrderDetail::create([
                    'title' => $item->name,
                    'map_id' => $item->attributes->map_id,
                    'mrp' => $item->price,
                    'quantity' => $item->quantity,
                    'product_id' => $item->attributes->product_id,
                    'order_id' => $order->id,
                    'size_id' => $item->attributes->size_id,
                    'color_id' => $item->attributes->color_id,
                    'offers' => $item->attributes->offers,
                ]);
            }

            if ($request->payment_mode == 'cod') {

                $OrderCreation = $logistic->OrderCreation($order, $user, "COD");

                if ($OrderCreation != false) {

                    $order->update([
                        'status' => 'Booked',
                        'shipment_id' => $OrderCreation['shipment_id'],
                        'shipment_order_id' => $OrderCreation['order_id'],
                    ]);

                    // SMS::send($order->user->mobile, 'Ranayas  - Your Order has been placed successfully, Your Order No : ' . $order->id . ' Login for more detail on ' . url('/'));

                    Mail::send(['html' => 'backend.mails.received'], ['order' => $order], function ($message) use ($order) {
                        $message->to($order->user->email)->subject('Your order has been placed successfully ! [order no : ' . $order->id . ']');
                        $message->from(config('mail.from.address'), config('app.name'));
                    });

                    Mail::send(['html' => 'backend.mails.admin'], ['order' => $order], function ($message) use ($order) {
                        $message->to(config('mail.from.address'))->subject('You have a new order ! [order id : ' . $order->id . ']');
                        $message->from(config('mail.from.address'), config('app.name'));
                    });
                }

                Cart::clear();

                connectify('success', 'Order Placed', 'Your Order has been placed Successfully !');

                return redirect()->route('order.success', encrypt($order->id));
            } elseif ($request->payment_mode == 'paytm') {
                return redirect()->route('razorpay.index', encrypt($order->id));
            }
        }

        connectify('error', 'Delivery Not Available', 'Delivery Not Available at ' . $request->pincode);

        return redirect(route('checkout'));
    }

    public function handleCallbackofCOD($orderid)
    {
        $order = TxnOrder::where('id', decrypt($orderid))->with('details', 'user', 'transaction')->firstOrFail();
        return view('frontend.order.transaction-success', compact('order'));
    }

    public function handleCallbackFromPaytm(Request $request, LogisticService $logistic)
    {
        // dd($request->all());
        $paramList = $request->all();

        if ($request->code == 'PAYMENT_SUCCESS') {
            $txnres = $request->all();
            Log::info(['Payment Success' => $txnres]);
            // unset($txnres['MID']);
            // unset($txnres['ORDERID']);
            // unset($txnres['CURRENCY']);
            // unset($txnres['CHECKSUMHASH']);

            $order = TxnOrder::where('id', $request->transactionId)->with('details', 'user', 'transaction')->firstOrFail();

            if ($order->status == 'nc') {

                if ($order->payment_mode == 'paytm') {
                    $OrderCreation = $logistic->OrderCreation($order, $order->user, "Prepaid");
                }

                $order->update([
                    'status' => 'Booked',
                    'payment_status' => 'Paid',
                    // 'shipment_id' => $order->payment_mode == 'paytm' ? $OrderCreation['shipment_id'] : null,
                    // 'shipment_order_id' => $order->payment_mode == 'paytm' ? $OrderCreation['order_id'] : null,
                ]);

                // $transaction = Transaction::create([
                //     'order_id' => $request->transactionId,
                //     'MID' => $request->providerReferenceId,
                //     'TXNID' => $request->transactionId,
                //     'TXNAMOUNT' => $request->amount,
                //     'PAYMENTMODE' => 'Online',
                //     'CURRENCY' => 'INR',
                //     'TXNDATE' => '',
                //     'STATUS' => 'Payment Success',
                //     'RESPCODE' => 'Payment Success',
                //     'RESPMSG' => 'Payment Success',
                //     'GATEWAYNAME' => 'Online',
                //     'BANKTXNID' => '',
                //     'CHECKSUMHASH' => $request->checksum,
                // ]);

                // if (array_key_exists('BANKNAME', $paramList)) {
                //     $transaction->update([
                //         'BANKNAME' => $paramList['BANKNAME'],
                //     ]);
                // }

                Delivery::orderCreation($order, $order->user);

                // SMS::send($order->user->mobile, 'Ranayas - Your Order has been placed successfully, Your Order No : ' . $order->id . ' Login for more detail on ' . url('/'));

                // SMS::send('9223324655', 'Ranayas - New Order Placed with Order No : ' . $order->id);

                Mail::send(['html' => 'backend.mails.received'], ['order' => $order], function ($message) use ($order) {
                    $message->to($order->user->email)->subject('Your order has been placed successfully ! [order no : ' . $order->id . ']');
                    $message->from(config('mail.from.address'), config('app.name'));
                });

                Mail::send(['html' => 'backend.mails.admin'], ['order' => $order], function ($message) use ($order) {
                    $message->to(config('mail.from.address'))->subject('You have a new order ! [order id : ' . $order->id . ']');
                    $message->from(config('mail.from.address'), config('app.name'));
                });

                Cart::clear();
            }
            return view('frontend.order.transaction-success')->with('order', $order)->with('TXNID', $request->transactionId);
        } else {
            return view('frontend.order.transaction-failed')->with('data', $request->except(['MID', 'CHECKSUMHASH']));

        }

        // $paramList = $request->all();
        // $isValidChecksum = "FALSE";
        // $paytmChecksum = $request->checksum;
        // $paytm = new Paytm();
        // $isValidChecksum = $paytm->verifychecksum_e($paramList, env('PAYTM_MERCHANT_KEY'), $paytmChecksum);
        // if ($isValidChecksum == "TRUE") {
        //     if ($paramList["STATUS"] == "TXN_SUCCESS") {
        //         $txnres = $request->all();
        //         Log::info(['Payment Success' => $txnres]);
        //         unset($txnres['MID']);
        //         unset($txnres['ORDERID']);
        //         unset($txnres['CURRENCY']);
        //         unset($txnres['CHECKSUMHASH']);

        //         $order = TxnOrder::where('id', $request->ORDERID)->with('details', 'user', 'transaction')->firstOrFail();

        //         if ($order->status == 'nc') {

        //             if ($order->payment_mode == 'paytm') {
        //                 $OrderCreation = $logistic->OrderCreation($order, $order->user, "Prepaid");
        //             }

        //             $order->update([
        //                 'status' => 'Booked',
        //                 'payment_status' => 'Paid',
        //                 'shipment_id' => $order->payment_mode == 'paytm' ? $OrderCreation['shipment_id'] : null,
        //                 'shipment_order_id' => $order->payment_mode == 'paytm' ? $OrderCreation['order_id'] : null,
        //             ]);

        //             $transaction = Transaction::create([
        //                 'order_id' => $paramList['ORDERID'],
        //                 'MID' => $paramList['MID'],
        //                 'TXNID' => $paramList['TXNID'],
        //                 'TXNAMOUNT' => $paramList['TXNAMOUNT'],
        //                 'PAYMENTMODE' => $paramList['PAYMENTMODE'],
        //                 'CURRENCY' => $paramList['CURRENCY'],
        //                 'TXNDATE' => $paramList['TXNDATE'],
        //                 'STATUS' => $paramList['STATUS'],
        //                 'RESPCODE' => $paramList['RESPCODE'],
        //                 'RESPMSG' => $paramList['RESPMSG'],
        //                 'GATEWAYNAME' => $paramList['GATEWAYNAME'],
        //                 'BANKTXNID' => $paramList['BANKTXNID'],
        //                 'CHECKSUMHASH' => $paramList['CHECKSUMHASH'],
        //             ]);

        //             if (array_key_exists('BANKNAME', $paramList)) {
        //                 $transaction->update([
        //                     'BANKNAME' => $paramList['BANKNAME'],
        //                 ]);
        //             }

        //             Delivery::orderCreation($order, $order->user);

        //             // SMS::send($order->user->mobile, 'Ranayas - Your Order has been placed successfully, Your Order No : ' . $order->id . ' Login for more detail on ' . url('/'));

        //             // SMS::send('9223324655', 'Ranayas - New Order Placed with Order No : ' . $order->id);

        //             Mail::send(['html' => 'backend.mails.received'], ['order' => $order], function ($message) use ($order) {
        //                 $message->to($order->user->email)->subject('Your order has been placed successfully ! [order no : ' . $order->id . ']');
        //                 $message->from('order-confirmation@ranayas.com', 'Ranayas');
        //             });

        //             Mail::send(['html' => 'backend.mails.admin'], ['order' => $order], function ($message) use ($order) {
        //                 $message->to('order-confirmation@ranayas.com')->subject('You have a new order ! [order id : ' . $order->id . ']');
        //                 $message->from('order-confirmation@ranayas.com', 'Ranayas');
        //             });

        //             Cart::clear();
        //         }
        //         return view('frontend.order.transaction-success')->with('order', $order)->with('TXNID', $txnres['TXNID']);
        //     } else {
        //         return view('frontend.order.transaction-failed')->with('data', $request->except(['MID', 'CHECKSUMHASH']));
        //     }
        // } else {
        //     return view('frontend.order.transaction-failed')->with('data', $request->except(['MID', 'CHECKSUMHASH']));
        // }
    }

    public function razorpayIndex($orderId)
    {
        $order = TxnOrder::where('id', decrypt($orderId))->with('user')->firstOrFail();

        // Create a Razorpay Order via cURL
        $keyId = env('RAZORPAY_KEY_ID');
        $keySecret = env('RAZORPAY_KEY_SECRET');

        $url = 'https://api.razorpay.com/v1/orders';
        $postData = [
            'amount' => $order->total * 100, // Razorpay amount is in paise
            'currency' => 'INR',
            'receipt' => 'rcpt_' . $order->id,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $keyId . ':' . $keySecret);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            connectify('error', 'Payment Gateway Error', 'Could not initiate payment. Please try again!');
            return redirect()->route('checkout');
        }

        $res = json_decode($response);

        if (isset($res->id)) {
            $razorpay_order_id = $res->id;
            return view('frontend.order.razorpay-checkout', compact('order', 'razorpay_order_id'));
        } else {
            Log::error('Razorpay Order Creation Failed: ' . $response);
            connectify('error', 'Payment Gateway Error', 'Order initiation failed. Check API credentials.');
            return redirect()->route('checkout');
        }
    }

    public function handleCallbackFromRazorpay(Request $request, LogisticService $logistic)
    {
        $razorpay_payment_id = $request->razorpay_payment_id;
        $razorpay_order_id = $request->razorpay_order_id;
        $razorpay_signature = $request->razorpay_signature;
        $order_db_id = $request->order_db_id;

        $order = TxnOrder::where('id', $order_db_id)->with('details', 'user')->firstOrFail();

        // Signature Verification using SHA256 HMAC
        $keySecret = env('RAZORPAY_KEY_SECRET');
        $expectedSignature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, $keySecret);

        if (hash_equals($expectedSignature, $razorpay_signature)) {

            // Payment verified successfully!
            if ($order->status == 'nc') {

                // Create shipment order via logistics
                $OrderCreation = $logistic->OrderCreation($order, $order->user, "Prepaid");

                $order->update([
                    'status' => 'Booked',
                    'payment_status' => 'Paid',
                    'shipment_id' => isset($OrderCreation['shipment_id']) ? $OrderCreation['shipment_id'] : null,
                    'shipment_order_id' => isset($OrderCreation['order_id']) ? $OrderCreation['order_id'] : null,
                ]);

                // Create database record in Transactions table
                Transaction::create([
                    'order_id' => $order->id,
                    'MID' => $razorpay_order_id,
                    'TXNID' => $razorpay_payment_id,
                    'TXNAMOUNT' => $order->total,
                    'PAYMENTMODE' => 'Razorpay',
                    'CURRENCY' => 'INR',
                    'TXNDATE' => now(),
                    'STATUS' => 'Payment Success',
                    'RESPCODE' => 'Success',
                    'RESPMSG' => 'Signature Verified successfully',
                    'GATEWAYNAME' => 'Razorpay',
                    'BANKTXNID' => $razorpay_payment_id,
                    'CHECKSUMHASH' => $razorpay_signature,
                ]);

                Delivery::orderCreation($order, $order->user);

                // Send success notifications
                try {
                    Mail::send(['html' => 'backend.mails.received'], ['order' => $order], function ($message) use ($order) {
                        $message->to($order->user->email)->subject('Your order has been placed successfully! [order no: ' . $order->id . ']');
                        $message->from(config('mail.from.address'), config('app.name'));
                    });

                    Mail::send(['html' => 'backend.mails.admin'], ['order' => $order], function ($message) use ($order) {
                        $message->to(config('mail.from.address'))->subject('You have a new Razorpay order! [order id: ' . $order->id . ']');
                        $message->from(config('mail.from.address'), config('app.name'));
                    });
                } catch (\Exception $e) {
                    Log::error('Mail sending failed during checkout: ' . $e->getMessage());
                }

                Cart::clear();
            }

            return view('frontend.order.transaction-success')->with('order', $order)->with('TXNID', $razorpay_payment_id);
        } else {
            // Verification failed
            Log::warning('Razorpay Signature Verification Failed for Order: ' . $order->id);
            return view('frontend.order.transaction-failed')->with('data', [
                'message' => 'Razorpay Payment Signature verification failed.',
                'order_id' => $order->id
            ]);
        }
    }
}

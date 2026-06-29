<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Model\SMS;
use App\Model\TxnOrder;
use App\Services\LogisticService;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $orders = TxnOrder::whereNotIn('status', ['nc'])->orderBy('id', 'DESC');

        if ($request->filled('order_id')) {
            $orders = $orders->where('id', $request->order_id);
        }

        if ($request->filled('city')) {
            $orders = $orders->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('pincode')) {
            $orders = $orders->where('pincode', 'like', '%' . $request->pincode . '%');
        }

        if ($request->filled('order_date')) {
            $orders = $orders->where('created_at', 'like', '%' . date('Y-m-d', strtotime($request->order_date)) . '%');
        }

        $orders = $orders->paginate(50);
        return view('backend.admin.orders.index', compact('orders'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        //
    }

    public function show($id, LogisticService $logistic)
    {
        try {

            $order = TxnOrder::where('id', $id)->with('details', 'user', 'transaction')->firstOrFail();
            $res = $logistic->trackOrder($id);
            $result = json_decode($res, true);
            if (array_key_exists('error', $result['tracking_data'])) {
                $track_response = [];
            } else {
                $track_response = $result['tracking_data'];
            }

            return view('backend.admin.orders.show', compact('order', 'track_response'));

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Order Not Found !');

                return redirect(route('admin.orders.all'));
            }
            Log::info(['Show Order' => $ex->getMessage()]);

            connectify('error', 'Error', 'Whoops, Something went wrong from our end !');

            return redirect(route('admin.orders.all'));
        }
    }

    public function generateLabel(Request $request, $id, LogisticService $logistic)
    {
        try {

            $order = TxnOrder::where('id', $id)->firstOrFail();

            $label = $request->all();

            $res = $logistic->generateLabel($order->shipment_id);
            $result = json_decode($res, true);
            $pdf = PDF::loadView('backend.admin.orders.generate-label', ['label' => $label]);

            return $pdf->download('order_no_' . $id . '.pdf');

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Order Not Found !');

                return redirect(route('admin.orders.all'));
            }

            connectify('error', 'Error', 'Whoops, Something went wrong from our end !');

            return redirect(route('admin.orders.all'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'status' => 'required|string',
            ],
            [
                'status' => 'Please Select Status',
            ]
        );
        try {

            $order = TxnOrder::where('id', $id)->with('user', 'details')->firstOrFail();

            $order->update([

                'status' => $request->status,
            ]);

            // SMS::send($order->user->mobile, 'Ranayas - Your Order ID : ' . $order->id . ', has been ' . $order->status . ',  Login for more detail on ' . route('user.login'));

            // Using the OTP template for now as requested
            // $rand_otp = rand(100000, 999999);
            // if ($order->user) {
            //     SMS::send(
            //         $order->user->mobile,
            //         'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . $rand_otp . '.',
            //         config('services.sms.dlt_otp_template_id')
            //     );
            // }

            // Order Shipped SMS
            if ($request->filled('status') && $request->status == 'Shipped') {
                // dd($order->user->mobile);
                // $mobile = $request->query('mobile');
                // $mobile = "7045882487";
                $courier = "Delhivery";
                $awbNo = "123456789";
                // $templateid = $request->query('templateid', '');
                // $templateid = "";
                $result =
                    SMS::send(
                        $order->user->mobile,
                        'Hi, Thanks for your purchase from Ranayas. Your order has been dispatched through ' . $courier . ' courier. Your AWB No. is ' . $awbNo . '.',
                        config('services.sms.dlt_shipped_template_id')
                    );

                // return response()->json($result);
            }
            if ($request->filled('status') && $request->status == 'delivered') {

                $total = floor($order->total / 50);

                $total_rewards = $order->user->total_rewards + $total;

                $order->update([
                    'reward_points' => $total,
                    'delivery_date' => \Carbon\Carbon::now(),
                ]);

                $order->user->update([
                    'total_rewards' => $total_rewards,
                ]);

                if (count($order->details)) {
                    foreach ($order->details as $detail) {
                        $detail->product->update([
                            'stock' => $detail->product->stock - $detail->quantity,
                        ]);
                    }
                }

                $pdf = PDF::loadView('backend.admin.invoices.download', ['invoice' => $order]);

                Mail::send(['html' => 'backend.admin.invoices.empty'], ['invoice' => $order], function ($message) use ($order, $pdf) {
                    $message->from('order-confirmation@ranayas.com', 'Ranayas');
                    $message->to($order->user->email, $order->user->name);
                    $message->subject('Invoice copy of Order No ' . $order->id . ' From Ranayas');
                    $message->attachData($pdf->output(), 'invoice_no_' . $order->id . '.pdf');
                });

            }

            connectify('success', 'Order Updated', 'Status has been updated to ' . $order->status);

            return redirect(route('admin.orders.show', $id));

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', "No Such Order Found !");

                return redirect(route('admin.orders.all'));
            }

            connectify('error', 'Error', "Whoops, Something went wrong from our end !");

            return redirect(route('admin.orders.all'));
        }
    }

    public function returnUpdate(Request $request, $id)
    {

        $request->validate(
            [
                'return_status' => 'required|string',
            ],
            [
                'return_status' => 'Please Select Status',
            ]
        );
        try {

            $order = TxnOrder::where('id', $id)->with('user')->firstOrFail();

            $order->update([

                'return_status' => $request->return_status,
            ]);

            SMS::send(
                $order->user->mobile,
                'Dear Customer, Thank You for login with RANAYAS. Your OTP for login is ' . substr($order->id, 0, 6) . '.',
                config('services.sms.dlt_return_template_id')
            );

            connectify('success', 'Status Updated', 'Status has been updated for return & refund to ' . $order->return_status . ' successfully !');

            return redirect(route('admin.orders.show', $id));

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', "No Such Order Found !");

                return redirect(route('admin.orders.all'));
            }

            connectify('error', 'Error', "Whoops, Something Went Wrong from our end !");

            return redirect(route('admin.orders.all'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function export()
    {
        return Excel::download(new OrderExport, 'orders.xlsx');
    }

}

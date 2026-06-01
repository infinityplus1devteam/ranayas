<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CouponExport;
use App\Http\Controllers\Controller;
use App\Model\Coupon;
use App\Model\Shop;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::orderBy('id', 'DESC')->paginate(50);
        return view('backend.admin.shops.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:191',
                'city' => 'required|string|max:191',
                'address' => 'required|string|max:191',
                'mobile' => 'required|digits_between:8,12',
                'email' => 'required|email|max:191|unique:shops,email',
                'password' => 'required|string|max:191',
                'account_no' => 'nullable|string|max:191',
                'ifsc_code' => 'nullable|string|max:191',
            ],
            [
                'name.required' => 'Please Enter Shop Name',
                'shop.required' => 'Please Enter City',
                'address.required' => 'Please Enter Shop Address',
                'mobile.required' => 'Please Enter Mobile Number',
                'mobile.digits_between' => 'Please Enter Mobile Number in 8 to 12 digits',
                'email.required' => 'Please Enter Email ID',
                'email.email' => 'Please Enter Proper Email ID',
                'email.unique' => $request->email . ' is already registered with us !',
                'password.required' => 'Please Enter Password',
            ]
        );

        if ($validator->fails()) {
            connectify('error', 'Add Shop', $validator->errors()->first());
            return redirect(route('admin.shops.all'))->withInput();
        }

        // $subname     = strtoupper(substr(str_replace(' ', '', $request->name), 0, 2));
        // $rand_number = str_pad(rand(0, 9), 4, '0', STR_PAD_LEFT);
        // $dis_code    = $subname . $rand_number . date('d') . date('m');

        $shop = Shop::create([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'account_no' => $request->account_no,
            'ifsc_code' => $request->ifsc_code,
            'status' => true,
        ]);

        $subname = strtoupper(substr(str_replace(' ', '', $shop->name), 0, 2));

        $dis_code = $subname . $shop->id . rand(000, 999);

        $shop->update([
            'shop_code' => $dis_code,
        ]);

        Mail::send(['html' => 'backend.mails.shop'], ['shop' => $shop, 'password' => $request->password], function ($message) use ($shop) {
            $message->from('info@ranayas.com', 'Ranayas');
            $message->to($shop->email, $shop->name);
            $message->subject('Ranayas - Dealer Credentials');
        });

        connectify('success', 'Dealer Added', 'Dealer has been added successfully !');

        return redirect(route('admin.shops.all'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $shop = Shop::where('id', $id)->firstOrFail();
            return view('backend.admin.shops.edit', compact('shop'));

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Shop Not Found with id : ' . $id);

                return redirect(route('admin.shops.all'));

            }

            connectify('error', 'Error', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.shops.all'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:191',
                'city' => 'required|string|max:191',
                'address' => 'required|string|max:191',
                'mobile' => 'required|digits_between:8,12',
                'password' => 'required_with:con_password|max:191',
                'con_password' => 'required_with:password|same:password|max:191',
                'account_no' => 'nullable|string|max:191',
                'ifsc_code' => 'nullable|string|max:191',
            ],
            [
                'name.required' => 'Please Enter Shop Name',
                'shop.required' => 'Please Enter City',
                'address.required' => 'Please Enter Shop Address',
                'mobile.required' => 'Please Enter Mobile Number',
                'mobile.digits_between' => 'Please Enter Mobile Number in 8 to 12 digits',
                'password.required_with' => 'Please Enter New Password to change password',
                'con_password.required_with' => 'Please Enter Confirm Password to change password',
                'con_password.same' => 'Please Enter Confirm Password same as New Password',
            ]
        );

        try {

            $shop = Shop::where('id', $id)->firstOrFail();

            $subname = strtoupper(substr(str_replace(' ', '', $request->name), 0, 2));

            $dis_code = $subname . $shop->id . rand(000, 999);

            $shop->update([
                'name' => $request->name,
                'city' => $request->city,
                'address' => $request->address,
                'mobile' => $request->mobile,
                'status' => $request->status,
                'account_no' => $request->account_no,
                'ifsc_code' => $request->ifsc_code,
                'shop_code' => $dis_code,
            ]);

            if ($request->filled('password')) {
                $shop->update([
                    'password' => bcrypt($request->password),
                ]);
            }

            connectify('success', 'Shop Updated', 'Shop has been Updated successfully !');

            return redirect(route('admin.shops.edit', $id));

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Shop Not Found with id : ' . $id);

                return redirect(route('admin.shops.all'));

            }

            connectify('error', 'Error', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.shops.all'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $shop = Shop::where('id', $request->shop_id)->firstOrFail();

            $shop->delete();

            connectify('success', 'Shop Updated', 'Shop has been Deleted successfully !');

            return redirect(route('admin.shops.all'));

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Error', 'Whoops, Shop Not Found with id : ' . $id);

                return redirect(route('admin.shops.all'));

            }

            connectify('error', 'Error', 'Whoops, Something Went Wrong from our end !');

            return redirect(route('admin.shops.all'));
        }
    }

    public function coupons($id)
    {
        try {

            $shop = Shop::where('id', $id)->with('coupons')->firstOrFail();
            return view('backend.admin.shops.coupons', compact('shop'));

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return redirect(route('admin.shops.all'))->with('messageDanger', 'Whoops, Shop Not Found with id : ' . $id);
            }
            return redirect(route('admin.shops.all'))->with('messageDanger', 'Error, ' . $ex->getMessage());
        }
    }

    public function generateCoupon(Request $request, $id)
    {
        $request->validate(
            [
                'no_of_coupon' => 'required|numeric|min:1|max:1000',
            ],
            [
                'no_of_coupon.required' => 'Please Enter No of coupon to be Generated',
                'no_of_coupon.numeric' => 'Please Enter Coupon code in Number Only',
                'no_of_coupon.min' => 'Coupon code should be Minimum 1',
                'no_of_coupon.max' => 'Coupon code should be Maximum 1000',
            ]
        );
        try {

            $shop = Shop::where('id', $id)->firstOrFail();

            $gen_code = [];
            $code = [];
            $gen_code['shop_id'] = $shop->id;
            for ($i = 0; $i < $request->no_of_coupon; $i++) {
                $gen_code['dis_code'] = strtoupper(substr($shop->name, 0, 3)) . rand(1000, 9999);
                array_push($code, $gen_code);
            }

            Coupon::insert($code);

            // $pdf = PDF::loadView('backend.admin.shops.download', ['coupons' => $code]);

            // return $pdf->download('coupons_' . $id . '.pdf');

            return redirect(route('admin.shops.coupons', $id))->with('messageSuccess', 'Discount has been Generated Successfully !');

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return redirect(route('admin.shops.all'))->with('messageDanger', 'Whoops, Shop Not Found with id : ' . $id);
            }
            return redirect(route('admin.shops.coupons', $id))->with('messageDanger', 'Error, ' . $ex->getMessage());
        }
    }

    public function downloadPdf($id)
    {
        try {

            Shop::where('id', $id)->firstOrFail();

            $coupons = Coupon::where('shop_id', $id)->get();

            if (count($coupons)) {
                $pdf = PDF::loadView('backend.admin.shops.download', ['coupons' => $coupons]);

                return $pdf->download('coupon_' . date('d_m_Y') . '.pdf');
            }

            return redirect(route('admin.shops.coupons', $id))->with('messageDanger', 'No Coupon to export, generate coupons to export !');

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return redirect(route('admin.shops.all'))->with('messageDanger', 'Whoops, Shop Not Found with id : ' . $id);
            }
            return redirect(route('admin.shops.coupons', $id))->with('messageDanger', 'Error, ' . $ex->getMessage());
        }

    }
    public function downloadExcel($id)
    {
        try {

            Shop::where('id', $id)->firstOrFail();

            return Excel::download(new CouponExport($id), 'coupon_' . date('d_m_Y') . '.xlsx');

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                return redirect(route('admin.shops.all'))->with('messageDanger', 'Whoops, Shop Not Found with id : ' . $id);
            }
            return redirect(route('admin.shops.coupons', $id))->with('messageDanger', 'Error, ' . $ex->getMessage());
        }

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('backend.admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|in:flat,percentage',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        Coupon::create($request->all());

        connectify('success', 'Success', 'Coupon created successfully.');
        return redirect()->route('admin.coupons.all');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:flat,percentage',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'required|numeric|min:0',
            'status' => 'required|boolean',
        ]);

        $coupon->update($request->all());

        connectify('success', 'Success', 'Coupon updated successfully.');
        return redirect()->route('admin.coupons.all');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        connectify('success', 'Success', 'Coupon deleted successfully.');
        return redirect()->route('admin.coupons.all');
    }
}

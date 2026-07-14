<?php

namespace App\Http\Controllers;

use App\Model\TxnProduct;
use App\Model\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = Validator::make($request->all(), [
            'p_id' => 'required|exists:txn_products,id',
            'c_id' => 'required|exists:mst_colors,id',
            's_id' => 'required|exists:mst_sizes,id',
        ],
            [
                'p_id.required' => 'Product Not Available',
                'p_id.exists' => 'Product Not Exists',
                'c_id.required' => 'Color Not Available',
                'c_id.exists' => 'Color Not Exists',
                's_id.required' => 'size Not Available',
                's_id.exists' => 'size Not Exists',
            ]);

        if ($validator->fails()) {
            connectify('error', 'Wishlist Error', $validator->errors()->first());
            return back()->withInput();
        }

        if (!auth('user')->check()) {
            connectify('error', 'Error', 'Please Login First !');
            return back();
        }

        $product = TxnProduct::where('id', $request->p_id)->first();

        Wishlist::create([
            'product_id' => $product->id,
            'color_id' => $request->c_id,
            'size_id' => $request->s_id,
            'user_id' => auth('user')->user()->id,
        ]);

        connectify('success', 'Added to Wishlist', 'Item has been Added to your wishlist');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $wishlist = Wishlist::where('id', $request->w_id)->firstOrFail();

            $product = TxnProduct::where('id', $wishlist->product_id)->first();

            $wishlist->delete();

            connectify('success', 'Removed Wishlist', 'Item has been Removed from your wishlist');

            return back();

        } catch (\Exception $ex) {

            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                connectify('error', 'Error', 'Whoops, Product Not Found !');
                return back();
            }
            return $ex->getMessage();
            connectify('error', 'Error', 'Whoops, something Went Wrong !');
            return back();
        }
    }
}

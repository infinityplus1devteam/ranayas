<?php

namespace App\Http\Controllers;

use App\Model\MapColorSize;
use App\Model\TxnImage;
use App\Model\TxnProduct;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        return view('frontend.order.cart');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qty' => 'required|min:1',
        ],
            [
                'qty.required' => 'Please Select Atleast One Quantity',
                'qty.min' => 'Please Select Atleast One Quantity',
                'qty.max' => 'Only 4 Quantity of product is allowed at a time',
            ]);

        if ($validator->fails()) {
            connectify('error', 'Checkout Error', $validator->errors()->first());
            return redirect(route('checkout'))->withInput();
        }

        try {
            $product = TxnProduct::where('id', $request->prod_id)->with('unit')->firstOrFail();

            $prodsizeColor = MapColorSize::where('color_id', $request->color_id)->where('product_id', $request->prod_id)->where('size_id', $request->size_id)->where('status', true)->with('color', 'size')->first();
            $image = TxnImage::where('size_id', $request->size_id)->where('color_id', $request->color_id)->where('product_id', $request->prod_id)->first();
            if ($prodsizeColor) {

                if ($prodsizeColor->stock <= 0) {

                    connectify('error', 'Product Out Of Stock', 'Product is Out Of Stock, stay tuned !');

                    return back();

                } elseif ($request->qty > $prodsizeColor->stock) {

                    connectify('error', 'Product Out Of Stock', $prodsizeColor->stock . ' Product Left in stock, stay tuned !');

                    return back();
                }

                Cart::add(array(
                    'id' => $prodsizeColor->size->title . '_' . $prodsizeColor->id,
                    'name' => $product->title,
                    'price' => $prodsizeColor->mrp,
                    'quantity' => $request->qty,
                    'attributes' => array(
                        'size_id' => $prodsizeColor->size->id,
                        'color_id' => $request->color_id,
                        'color_name' => $prodsizeColor->color->title,
                        'size_name' => $prodsizeColor->size->title,
                        'image_url' => $product->image_url,
                        'slug_url' => $product->slug_url,
                        'product_id' => $product->id,
                        'category_id' => $product->category_id,
                        'stock' => $prodsizeColor->stock,
                        'map_id' => $prodsizeColor->id,
                        'isCodAvailable' => $product->isCodAvailable,
                        'color_image' => !empty($image) ? $image->image_url : null,
                        'unit' => $product->unit ? $product->unit->unit : null,
                    ),
                ));

                Cart::update($prodsizeColor->size->title . '_' . $prodsizeColor->id, array(
                    'quantity' => array(
                        'relative' => false,
                        'value' => $request->qty,
                    ),
                ));

                connectify('success', 'Cart', '"' . $product->title . '"' . ' has been added to your cart !');

                return redirect(route('cart'));
            }

            connectify('error', 'Cart', ' Size "' . $prodsizeColor->size->title . '"' . ' is out of stock currently, stay tuned !');

            return back();

        } catch (\Exception $ex) {
            if ($ex instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {

                connectify('error', 'Cart', "It seems that the Product you're searching for doesn't exists !");

                return back();
            } else {
                \Log::error($ex->getMessage());

                return $ex->getMessage();

                connectify('error', 'Cart', "Oops, Something went wrong at our end !");

                return back();
            }
        }
    }

    public function update(Request $request)
    {
        $cart = Cart::get($request->itemid);

        $product = TxnProduct::where('id', $cart->attributes->product_id)->with('unit')->first();

        $size = MapColorSize::where('product_id', $product->id)->where('size_id', $cart->attributes->size_id)->where('color_id', $cart->attributes->color_id)->first();

        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1|max:' . $size->stock,
        ],
            [
                'quantity.required' => 'Please enter quantity',
                'quantity.min' => 'Quantity must be greater than 1',
                'quantity.max' => 'Only ' . $size->stock . ' Quantity left in stock',
            ]);

        if ($validator->fails()) {
            connectify('error', 'Cart Error', $validator->errors()->first());
            return back()->withInput();
        }

        Cart::update($request->itemid, array(

            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity,
            ),

            'attributes' => array_merge($cart->attributes->toArray(), array(
                'color_id' => $size->color_id,
                'stock' => $size->stock,
                'image_url' => $product->image_url,
                'slug_url' => $product->slug_url,
                'unit' => $product->unit ? $product->unit->unit : null,
                'isCodAvailable' => $product->isCodAvailable,
            )),
        ));

        connectify('success', 'Cart Updated', 'Cart has been updated successfully !');

        return response()->json(['success' => 'Cart has been updated successfully !', 'size' => $size]);
    }

    public function destroy(Request $request)
    {
        $cart = Cart::get($request->item_id);
        Cart::remove($request->item_id);

        connectify('success', 'Item Removed', $cart->name . ' has been removed from your cart !');

        return back();
    }
}

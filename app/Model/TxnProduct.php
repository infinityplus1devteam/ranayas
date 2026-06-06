<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TxnProduct extends Model
{

    protected $table = 'txn_products';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(TxnCategory::class, 'category_id');
    }

    public function warranty()
    {
        return $this->belongsTo(MasterWarranty::class);
    }

    public function custom_fields()
    {
        return $this->hasMany(TxnCustomField::class, 'product_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(MstColor::class, 'id', 'product_id');
    }

    public function colors()
    {
        return $this->hasMany(MapColorSize::class, 'product_id', 'id');
    }

    public function sizes()
    {
        return $this->hasMany(MapProductMstSize::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(TxnImage::class, 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(TxnReview::class, 'product_id', 'id')->where('status', true);
    }

    public function qnas()
    {
        return $this->hasMany(ProductFaq::class, 'product_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(TxnWeight::class, 'weight_unit', 'id');
    }

    public function dim_unit()
    {
        return $this->belongsTo(TxnLengthUnit::class, 'dimension_unit', 'id');
    }

    public function condition()
    {
        return $this->belongsTo(TxnCondition::class);
    }

    public function master_gst()
    {
        return $this->belongsTo(TxnMasterGst::class, 'gst', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(TxnBrand::class);
    }

    public function material()
    {
        return $this->belongsTo(TxnMaterial::class);
    }

    public function keywords()
    {
        return $this->hasMany(TxnKeyword::class, 'product_id', 'id');
    }



    public function offers()
    {
        return $this->hasMany(MapMstOfferProduct::class, 'offer_product_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(MapOfferProduct::class, 'id', 'product_id');
    }

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class, 'id', 'product_id')->where('user_id', auth('user')->id());
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MapShopByBudgetProduct extends Model
{
    protected $table = 'map_shop_by_budget_products';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(TxnProduct::class, 'product_id', 'id');
    }

    public function shopByBudget()
    {
        return $this->belongsTo(ShopByBudget::class, 'shop_by_budget_id', 'id');
    }
}

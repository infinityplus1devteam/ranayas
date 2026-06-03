<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopByBudget extends Model
{
    protected $table = 'shop_by_budgets';
    protected $guarded = ['id'];

    public function products()
    {
        return $this->hasMany(MapShopByBudgetProduct::class, 'shop_by_budget_id', 'id')->orderBy('sort_index');
    }
}

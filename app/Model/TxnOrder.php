<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TxnOrder extends Model
{

    protected $table = 'txn_orders';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(TxnUser::class, 'user_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(TxnOrderDetail::class, 'order_id', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id', 'order_id');
    }

    public function getOrderNumberAttribute()
    {
        return 1000000000 + $this->id;
    }

}

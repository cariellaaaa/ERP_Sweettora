<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiveItem extends Model
{
    protected $table = 'receive_items';

    protected $fillable = [
        'purchase_order_id',
        'user_id',
        'code',
        'trx_date',
        'description',
        'total',
        'status',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receiveItemDetails()
    {
        return $this->hasMany(ReceiveItemDetail::class);
    }
}

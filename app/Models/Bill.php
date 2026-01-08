<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DeliveryOrder;

class Bill extends Model
{
    protected $fillable = [
        'bill_number',
        'delivery_order_id',
        'bill_date',
        'due_date',
        'subtotal',
        'tax',
        'total',
        'status',
    ];

    public function deliveryOrder()
    {
        return $this->belongsTo(DeliveryOrder::class);
    }
}
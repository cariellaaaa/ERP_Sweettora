<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SalesOrder;
use App\Models\DeliveryOrderItem;
use App\Models\Bill;

class DeliveryOrder extends Model
{
    protected $fillable = [
        'sales_order_id', 'do_number', 'delivery_date', 'status'
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function items()
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}

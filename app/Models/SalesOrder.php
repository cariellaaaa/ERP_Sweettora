<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SalesOrderItem;
use App\Models\DeliveryOrder;

class SalesOrder extends Model
{
    protected $fillable = [
        'so_number', 'order_date', 'customer_name', 'status'
    ];

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function deliveryOrder()
    {
        return $this->hasOne(DeliveryOrder::class);
    }
}

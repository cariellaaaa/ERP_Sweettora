<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiveItemDetail extends Model
{
    protected $table = 'receive_item_details';

    protected $fillable = [
        'receive_item_id',
        'product_id',
        'unit_id',
        'quantity',
        'received',
        'price',
        'paid',
        'subtotal',
        'tax',
        'tax_value',
        'total',
    ];

    public function receiveItem()
    {
        return $this->belongsTo(ReceiveItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

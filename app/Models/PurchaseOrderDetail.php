<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = 'purchase_order_details';
    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'unit_id',
        'quantity',
        'price',
        'subtotal',
        'tax',
        'tax_value',
        'total',
    ]; 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

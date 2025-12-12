<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Product;
use App\Models\ManufacturingOrder;

class ManufacturingOrderDetail extends Model
{
    protected $fillable = [
        'manufacturing_order_id',
        'product_id',
        'unit_id',
        'requirements',
        'consumed',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     public function manufacturingOrder()
    {
        return $this->belongsTo(ManufacturingOrder::class);
    }
}

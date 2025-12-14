<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustmentDetail extends Model
{
    protected $table = 'stock_adjustment_details';

    protected $fillable = [
        'stock_adjustment_id',
        'product_id',
        'quantity_before',
        'quantity_adjusted',
        'quantity_after',
        'unit_cost',
        'total_cost',
        'batch_number',
        'notes',
    ];

    public function stockAdjustment()
    {
        return $this->belongsTo(StockAdjustment::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

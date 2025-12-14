<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'product_id',
        'warehouse_id',
        'batch_number',
        'quantity',
        'reserved',
        'available',
        'unit_cost',
        'total_value',
        'expiry_date',
        'location',
        'reorder_level',
        'max_stock',
        'status',
        'notes',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}

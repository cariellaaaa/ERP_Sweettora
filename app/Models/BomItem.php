<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomItem extends Model
{
    protected $fillable = [
        'bill_of_material_id',
        'product_id',
        'quantity',
        'cost',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class);
    }
}

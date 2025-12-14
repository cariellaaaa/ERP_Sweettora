<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\BillOfMaterial;
use App\Models\ManufacturingOrderDetail;
use App\Models\User;

class ManufacturingOrder extends Model
{
    protected $fillable = [
        'product_id',
        'bill_of_material_id',
        'user_id',
        'company_id',
        'schedule',
        'quantity',
        'total',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function billOfMaterial()
    {
        return $this->belongsTo(BillOfMaterial::class);
    }

    public function details()
    {
        return $this->hasMany(ManufacturingOrderDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfMaterial extends Model
{
     use HasFactory;

    protected $fillable = [
        'product_id',
        'company_id',
        'user_id',
        'reference',
        'name',
        'quantity',
        'total',
        'cost'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(BomItem::class);
    }

}
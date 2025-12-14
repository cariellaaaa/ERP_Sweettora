<?php

namespace App\Models;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $fillable = [
        'vendor_id',
        'user_id',
        'code',
        'trx_date',
        'description',
        'total',
        'status',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }
    
}

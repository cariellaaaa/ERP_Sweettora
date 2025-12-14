<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table = 'warehouses';

    protected $fillable = [
        'code',
        'name',
        'type',
        'address',
        'city',
        'province',
        'postal_code',
        'phone',
        'email',
        'manager_name',
        'capacity',
        'status',
        'description',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function stockAdjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }
}

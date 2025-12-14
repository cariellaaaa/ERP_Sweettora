<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $table = 'stock_adjustments';

    protected $fillable = [
        'user_id',
        'warehouse_id',
        'code',
        'adjustment_date',
        'adjustment_type',
        'status',
        'reason',
        'notes',
        'approved_by',
        'approved_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function stockAdjustmentDetails()
    {
        return $this->hasMany(StockAdjustmentDetail::class);
    }
}

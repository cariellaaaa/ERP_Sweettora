<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'postal_code',
        'address',
        'npwp',
        'image',
        'province_id',
        'city_id',
    ];
}

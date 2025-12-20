<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\Province;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'id_number',
        'birth_date',
        'gender',
        'address',
        'province_id',
        'city_id',
        'postal_code',
        'position',
        'department',
        'hire_date',
        'salary',
        'employment_status',
        'status',
        'image',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    // Relationships
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}

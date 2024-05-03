<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    protected $fillable = [
        'name',
        'qualification',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'desc',
        'experience_years',
        'specialization',
        'availability',
        'img',
        'hourly_rate',
    ];
    public function nurseHires()
    {
        return $this->hasMany(NurseHire::class);
    }
    // Your other model code here...
}

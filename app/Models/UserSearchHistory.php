<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSearchHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'query',
        'user_id',
        'ip_address',
    ];
}

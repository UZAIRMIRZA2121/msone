<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'desc',
        'pres',
        'img',
        'qty',
        'price',
        'discount',
        'formula',
        'category_id',
        'related_product_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
   protected $fillable = [
    'product_id',
    'size',
    'width',
    'length',
    'unit',
    'color',
    'price',
    'currency',
    'images',
    'stock',
    'weight',
    'is_custom_size',
    'notes'
];
    protected $casts = [
        'images' => 'array',
        'is_custom_size' => 'boolean'
    ];

}

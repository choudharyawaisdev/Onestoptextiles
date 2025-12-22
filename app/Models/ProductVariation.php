<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
   protected $fillable = [
    'product_id',
    'size',
    'width',
    'length',
    'color',
    'price',
    'stock',
    'images',
    'weight',
    'description',
    'notes'
    ];

    protected $casts = [
        'images' => 'array',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

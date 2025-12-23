<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id', 'price', 'description', 'images', 'size', 'width', 'length', 'color', 'weight', 'finish'
    ];

    protected $casts = [
        'images' => 'array',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = [
        'product_id', 'price', 'notes', 'image', 'size', 'color', 'weight', 'finish',
    ];

    protected $casts = [
        'image' => 'array',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

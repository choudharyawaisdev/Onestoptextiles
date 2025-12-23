<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'name',
    'category',
    'slug',
    'price',
    'description',
    'material',
    'main_image',
    ];

    protected $casts = [
        'main_image' => 'array',
    ];
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    
}

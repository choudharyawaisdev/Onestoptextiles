<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'name',
    'slug',
    'category',
    'material',
    'price',
    'moq',
    'unit',
    'main_image',
    'description',
    ];

    protected $casts = [
        'main_image' => 'array',
    ];
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    
    // Product.php
    public function addons()
    {
        return $this->belongsToMany(AddOn::class, 'addon_product', 'product_id', 'addon_id');
    }


}

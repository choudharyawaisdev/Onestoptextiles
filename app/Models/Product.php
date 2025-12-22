<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
    'name',
    'slug',
    'main_image',
    'description',
    'material',
    ];

    protected $casts = [
        'main_image' => 'array',
    ];
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    
}

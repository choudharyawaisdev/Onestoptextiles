<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    protected $fillable = [
    'title',
    'price',
    ];

// AddOn.php
    public function products()
    {
        return $this->belongsToMany(Product::class, 'addon_product', 'addon_id', 'product_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddonProduct extends Model
{
    protected $table = 'addon_product'; // specify the pivot table name

    protected $fillable = [
        'product_id',
        'addon_id',
    ];

    // Optional: define relationships to Product and AddOn
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function addon()
    {
        return $this->belongsTo(AddOn::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationAttribute extends Model
{
    //
    protected $fillable = [
    'product_variation_id',
    'attribute_name',
    'attribute_value'
];
}

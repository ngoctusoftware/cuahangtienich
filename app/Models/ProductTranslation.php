<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'language_id', 'name', 'slug',
        'short_description', 'description', 'meta_title', 'meta_description',
    ];
}

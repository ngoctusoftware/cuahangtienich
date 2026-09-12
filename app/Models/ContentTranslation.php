<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['content_id', 'language_id', 'title', 'slug', 'body'];
}

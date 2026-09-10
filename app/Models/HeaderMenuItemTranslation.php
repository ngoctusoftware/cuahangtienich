<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeaderMenuItemTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['header_menu_item_id', 'language_id', 'label'];

    public function menuItem(): BelongsTo
    {
        return $this->belongsTo(HeaderMenuItem::class, 'header_menu_item_id');
    }
}

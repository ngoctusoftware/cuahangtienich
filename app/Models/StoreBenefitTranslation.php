<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreBenefitTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['store_benefit_id', 'language_id', 'title', 'description'];

    public function benefit(): BelongsTo
    {
        return $this->belongsTo(StoreBenefit::class, 'store_benefit_id');
    }
}

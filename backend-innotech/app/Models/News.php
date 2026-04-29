<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'category',
        'event_date',
        'is_published',
        'image_url',
    ];

    // All translations
    public function translations()
    {
        return $this->hasMany(NewsTranslation::class);
    }

    // Only current language translation
    public function translation()
    {
        return $this->hasOne(NewsTranslation::class)->where('codeLang', app()->getLocale());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'news_id',
        'codeLang',
        'title',
        'description',
        'location',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}

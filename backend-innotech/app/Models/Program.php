<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = ['degree_id', 'attached_file'];

    protected $appends = ['attached_file_url'];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function getAttachedFileUrlAttribute()
    {
        return $this->attached_file
            ? asset('storage/' . $this->attached_file)
            : null;
    }

    public function translations()
    {
        return $this->hasMany(ProgramTranslation::class);
    }

    public function translation($lang = null)
    {
        $lang = $lang ?? app()->getLocale();
        return $this->translations->where('codeLang', $lang)->first();
    }
}

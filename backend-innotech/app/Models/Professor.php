<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $fillable = [
        'email',
        'profile_slug',
        'photo_url',
        'department_id',
        'cv_attached_file'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function translations()
    {
        return $this->hasMany(ProfessorTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ProfessorTranslation::class)
            ->where('codeLang', app()->getLocale());
    }
}

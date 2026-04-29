<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'professor_id', 'codeLang', 'first_name', 'last_name', 'speciality', 'grade'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}

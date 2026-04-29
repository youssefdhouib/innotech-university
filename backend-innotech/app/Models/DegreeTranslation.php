<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DegreeTranslation extends Model
{
    protected $fillable = ['degree_id', 'codeLang', 'name'];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }
}

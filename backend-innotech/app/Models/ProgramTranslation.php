<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramTranslation extends Model
{
    protected $fillable = ['program_id', 'codeLang','description'];
    protected $casts = [
        'description' => 'array',
    ];
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}

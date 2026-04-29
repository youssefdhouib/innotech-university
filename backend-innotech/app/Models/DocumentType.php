<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['name', 'level', 'is_required'];

    public function documents()
    {
        return $this->hasMany(Document::class, 'type_id');
    }
}


<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'application_id', 'type_id', 'file_path', 'status'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function type()
    {
        return $this->belongsTo(DocumentType::class, 'type_id');
    }
}

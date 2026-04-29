<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletionLog extends Model
{
    protected $fillable = [
        'user_id', 'deleted_by', 'reason', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

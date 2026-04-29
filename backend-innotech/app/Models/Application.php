<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'first_name_ar', 'last_name_ar',
        'desired_degree_id',
        'cin', 'passport', 'birth_date', 'country', 'gender',
        'address', 'phone', 'previous_degree',
        'graduation_year', 'how_did_you_hear',
        'status', 'rejection_reason'
    ];

    public function degree()
    {
        return $this->belongsTo(Degree::class, 'desired_degree_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['cover_image'];

    public function translations()
    {
        return $this->hasMany(DepartmentTranslation::class);
    }
}


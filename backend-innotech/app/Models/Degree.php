<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = ['level','cover_image'];

    // ✅ One-to-many: Applications that selected this degree
    public function applications()
    {
        return $this->hasMany(Application::class, 'desired_degree_id');
    }

    // ✅ One-to-one: Related program
    public function program()
    {
        return $this->hasOne(Program::class);
    }

    // ✅ Translation relation (multilingual setup)
    public function translations()
    {
        return $this->hasMany(DegreeTranslation::class);
    }

    // ✅ Return translation for current or provided language
    public function translation($lang = null)
    {
        $lang = $lang ?? app()->getLocale();
        return $this->translations->where('codeLang', $lang)->first();
    }

    // ✅ Scopes for filtering by level
    public function scopeLicence($query)
    {
        return $query->where('level', 'Licence');
    }

    public function scopeMastere($query)
    {
        return $query->where('level', 'Mastere');
    }
}

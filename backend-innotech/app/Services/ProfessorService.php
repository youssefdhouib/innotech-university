<?php

namespace App\Services;

use App\Models\Professor;
use App\Models\ProfessorTranslation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProfessorService
{
    public function list()
    {
        $codeLang = app()->getLocale();

        return Professor::with(['translations', 'department'])->get()->map(function ($prof) use ($codeLang) {
            $t = $prof->translations->firstWhere('codeLang', $codeLang);

            return [
                'id' => $prof->id,
                'profile_slug' => $prof->profile_slug,
                'email' => $prof->email,
                'photo_url' => $prof->photo_url,
                'cv_attached_file' => $prof->cv_attached_file,
                'department_id' => $prof->department_id,
                'first_name' => $t?->first_name,
                'last_name' => $t?->last_name,
                'speciality' => $t?->speciality,
                'grade' => $t?->grade,
                'translations' => $prof->translations->mapWithKeys(fn($tr) => [
                    $tr->codeLang => [
                        'first_name' => $tr->first_name,
                        'last_name' => $tr->last_name,
                        'speciality' => $tr->speciality,
                        'grade' => $tr->grade
                    ]
                ])
            ];
        });
    }

    public function create(array $data): Professor
    {
        DB::beginTransaction();

        $fr = $data['translations']['fr'];
        $data['profile_slug'] = $this->generateUniqueSlug($fr['first_name'], $fr['last_name']);

        $prof = Professor::create([
            'email' => $data['email'] ?? null,
            'photo_url' => $data['photo_url'] ?? null,
            'cv_attached_file' => $data['cv_attached_file'] ?? null,
            'profile_slug' => $data['profile_slug'],
            'department_id' => $data['department_id']
        ]);

        foreach ($data['translations'] as $lang => $tr) {
            ProfessorTranslation::create([
                'professor_id' => $prof->id,
                'codeLang' => $lang,
                ...$tr
            ]);
        }

        DB::commit();
        return $prof;
    }

    public function update(Professor $professor, array $data): Professor
    {
        DB::beginTransaction();

        if (isset($data['translations']['fr']['first_name'], $data['translations']['fr']['last_name'])) {
            $data['profile_slug'] = $this->generateUniqueSlug(
                $data['translations']['fr']['first_name'],
                $data['translations']['fr']['last_name'],
                $professor->id
            );
        }

        $professor->update([
            'email' => $data['email'] ?? $professor->email,
            'photo_url' => $data['photo_url'] ?? $professor->photo_url,
            'cv_attached_file' => $data['cv_attached_file'] ?? $professor->cv_attached_file,
            'profile_slug' => $data['profile_slug'] ?? $professor->profile_slug,
            'department_id' => $data['department_id'] ?? $professor->department_id,
        ]);

        foreach ($data['translations'] as $lang => $tr) {
            ProfessorTranslation::updateOrCreate(
                ['professor_id' => $professor->id, 'codeLang' => $lang],
                $tr
            );
        }

        DB::commit();
        return $professor;
    }

    public function get(Professor $professor): array
    {
        $codeLang = app()->getLocale();
        $t = $professor->translations->firstWhere('codeLang', $codeLang);

        return [
            'id' => $professor->id,
            'profile_slug' => $professor->profile_slug,
            'email' => $professor->email,
            'photo_url' => $professor->photo_url,
            'cv_attached_file' => $professor->cv_attached_file,
            'department_id' => $professor->department_id,
            'first_name' => $t?->first_name,
            'last_name' => $t?->last_name,
            'speciality' => $t?->speciality,
            'grade' => $t?->grade,
            'translations' => $professor->translations->mapWithKeys(fn($tr) => [
                $tr->codeLang => [
                    'first_name' => $tr->first_name,
                    'last_name' => $tr->last_name,
                    'speciality' => $tr->speciality,
                    'grade' => $tr->grade
                ]
            ])
        ];
    }

    public function getByDepartment($departmentId)
    {
        $codeLang = app()->getLocale();

        return Professor::where('department_id', $departmentId)->with('translations')->get()->map(function ($p) use ($codeLang) {
            $t = $p->translations->firstWhere('codeLang', $codeLang);
            return [
                'id' => $p->id,
                'email' => $p->email,
                'profile_slug' => $p->profile_slug,
                'first_name' => $t?->first_name,
                'last_name' => $t?->last_name,
                'speciality' => $t?->speciality,
                'grade' => $t?->grade,
                'photo_url' => $p->photo_url
            ];
        });
    }

    public function getBySlug(string $slug): array
    {
        $professor = Professor::where('profile_slug', $slug)
            ->with(['translations', 'department'])
            ->firstOrFail();

        return $this->get($professor);
    }

    public function delete(Professor $professor): void
    {
        $professor->delete();
    }

    protected function generateUniqueSlug(string $firstName, string $lastName, int $ignoreId = null): string
    {
        $baseSlug = Str::slug($firstName . '-' . $lastName);
        $slug = $baseSlug;

        $query = Professor::where('profile_slug', $slug);
        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();
        if ($count > 0) {
            $slug = $baseSlug . '-' . ($count + 1);
        }

        return $slug;
    }
}

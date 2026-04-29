<?php

namespace App\Services;

use App\Models\Department;
use App\Models\DepartmentTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentService
{
    /**
     * List all departments with translations and current locale.
     */
    public function list()
    {
        $locale = app()->getLocale();

        return Department::with('translations')->get()->map(function ($d) use ($locale) {
            $t = $d->translations->firstWhere('codeLang', $locale);
            return [
                'id' => $d->id,
                'cover_image' => $d->cover_image,
                'name' => $t?->name,
                'description' => $t?->description,
                'translations' => $d->translations->mapWithKeys(fn($tr) => [
                    $tr->codeLang => [
                        'name' => $tr->name,
                        'description' => $tr->description,
                    ]
                ]),
            ];
        });
    }

    /**
     * Create a new department with translations.
     */
    public function create(array $data): Department
    {
        DB::beginTransaction();

        try {
            $cover = $data['cover_image'] ?? null;

            if ($cover) {
                $this->ensureImageExists($cover);
            }

            $dept = Department::create([
                'cover_image' => $cover,
            ]);

            foreach ($data['translations'] as $lang => $values) {
                DepartmentTranslation::create([
                    'department_id' => $dept->id,
                    'codeLang' => $lang,
                    ...$values
                ]);
            }

            DB::commit();
            return $dept;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing department and its translations.
     */
    public function update(Department $department, array $data): Department
    {
        DB::beginTransaction();

        try {
            if (isset($data['cover_image'])) {
                $this->ensureImageExists($data['cover_image']);
                $department->update([
                    'cover_image' => $data['cover_image'],
                ]);
            }

            foreach ($data['translations'] as $lang => $values) {
                DepartmentTranslation::updateOrCreate(
                    ['department_id' => $department->id, 'codeLang' => $lang],
                    $values
                );
            }

            DB::commit();
            return $department;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Show one department by model instance.
     */
    public function get(Department $department): array
    {
        $locale = app()->getLocale();
        $t = $department->translations->firstWhere('codeLang', $locale);

        return [
            'id' => $department->id,
            'cover_image' => $department->cover_image,
            'name' => $t?->name,
            'description' => $t?->description,
            'translations' => $department->translations->mapWithKeys(fn($tr) => [
                $tr->codeLang => [
                    'name' => $tr->name,
                    'description' => $tr->description,
                ]
            ])
        ];
    }

    /**
     * Delete a department and its translations.
     */
    public function delete(Department $department): void
    {
        $department->delete();
    }

    /**
     * Ensure the given image path exists in public storage, or fake it.
     */
    protected function ensureImageExists(string $relativePath): void
    {
        $disk = Storage::disk('public');

        if (!$disk->exists($relativePath)) {
            $disk->put($relativePath, 'Fake department cover image');
        }
    }
}

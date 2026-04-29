<?php

namespace App\Services;

use App\Models\Degree;
use App\Models\DegreeTranslation;
use Illuminate\Support\Facades\DB;

class DegreeService
{
    public function list()
    {
        $codeLang = app()->getLocale();

        return Degree::with('translations')->get()->map(function ($degree) use ($codeLang) {
            $t = $degree->translations->firstWhere('codeLang', $codeLang);

            return [
                'id' => $degree->id,
                'level' => $degree->level,
                'name' => $t?->name,
                'cover_image' => $degree->cover_image,
                'translations' => $degree->translations->mapWithKeys(fn($tr) => [
                    $tr->codeLang => [
                        'name' => $tr->name
                    ]
                ])
            ];
        });
    }

    public function create(array $data): Degree
    {
        DB::beginTransaction();

        $degree = Degree::create([
            'level' => $data['level'],
            'cover_image' => $data['cover_image'] ?? null,
        ]);

        foreach ($data['translations'] as $lang => $tr) {
            DegreeTranslation::create([
                'degree_id' => $degree->id,
                'codeLang' => $lang,
                'name' => $tr['name']
            ]);
        }

        DB::commit();
        return $degree;
    }

    public function update(Degree $degree, array $data): Degree
    {
        DB::beginTransaction();

        $degree->update([
            'level' => $data['level'] ?? $degree->level,
            'cover_image' => $data['cover_image'] ?? $degree->cover_image
        ]);

        foreach ($data['translations'] as $lang => $tr) {
            DegreeTranslation::updateOrCreate(
                ['degree_id' => $degree->id, 'codeLang' => $lang],
                ['name' => $tr['name']]
            );
        }

        DB::commit();
        return $degree;
    }

    public function get(Degree $degree): array
    {
        $codeLang = app()->getLocale();
        $t = $degree->translations->firstWhere('codeLang', $codeLang);

        return [
            'id' => $degree->id,
            'level' => $degree->level,
            'name' => $t?->name,
            'cover_image' => $degree->cover_image,
            'translations' => $degree->translations->mapWithKeys(fn($tr) => [
                $tr->codeLang => [
                    'name' => $tr->name
                ]
            ])
        ];
    }

    public function delete(Degree $degree): void
    {
        $degree->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Program;
use App\Models\ProgramTranslation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ProgramService
{
    public function list()
    {
        $codeLang = app()->getLocale();

        return Program::with(['translations', 'degree.translations'])->get()->map(function ($program) use ($codeLang) {
            $t = $program->translations->firstWhere('codeLang', $codeLang);

            return [
                'id' => $program->id,
                'degree_id' => $program->degree_id,
                'attached_file' => $program->attached_file,
                'attached_file_url' => $program->attached_file_url,
                'description' => $t?->description,
                'translations' => $program->translations->mapWithKeys(fn($tr) => [
                    $tr->codeLang => [
                        'description' => $tr->description
                    ]
                ])
            ];
        });
    }

    public function create(array $data): Program
    {
        DB::beginTransaction();

        $program = Program::create([
            'degree_id' => $data['degree_id'],
            'attached_file' => $data['attached_file'] ?? null,
        ]);

        foreach ($data['translations'] as $lang => $tr) {
            ProgramTranslation::create([
                'program_id' => $program->id,
                'codeLang' => $lang,
                ...$tr
            ]);
        }

        DB::commit();
        return $program;
    }

    public function update(Program $program, array $data): Program
    {
        DB::beginTransaction();

        $program->update([
            'degree_id' => $data['degree_id'] ?? $program->degree_id,
            'attached_file' => $data['attached_file'] ?? $program->attached_file,
        ]);

        foreach ($data['translations'] as $lang => $tr) {
            ProgramTranslation::updateOrCreate(
                ['program_id' => $program->id, 'codeLang' => $lang],
                $tr
            );
        }

        DB::commit();
        return $program;
    }

    public function get(Program $program): array
    {
        $codeLang = app()->getLocale();
        $t = $program->translations->firstWhere('codeLang', $codeLang);

        return [
            'id' => $program->id,
            'degree_id' => $program->degree_id,
            'attached_file' => $program->attached_file,
            'attached_file_url' => $program->attached_file_url,
            'description' => $t?->description,
            'translations' => $program->translations->mapWithKeys(fn($tr) => [
                $tr->codeLang => [
                    'description' => $tr->description
                ]
            ])
        ];
    }

    public function delete(Program $program): void
    {
        $program->delete();
    }
    public function getByDegreeIdWithTranslations($degreeId)
    {
        $locale = app()->getLocale();

        return Program::with(['translations' => function ($query) {
            $query->select('program_id', 'codeLang', 'description');
        }])
            ->where('degree_id', $degreeId)
            ->get()
            ->map(function ($program) use ($locale) {
                $translation = $program->translations->firstWhere('codeLang', $locale);

                return [
                    'id' => $program->id,
                    'degree_id' => $program->degree_id,
                    'name' => $program->name,
                    'attached_file' => $program->attached_file,
                    'attached_file_url' => $program->attached_file_url,
                    'description' => $translation ? $translation->description : null,
                ];
            });
    }
    public function getProgramsByDegreeId($degreeId)
    {
        $locale = App::getLocale();

        return Program::with(['translations' => function ($query) use ($locale) {
            $query->where('codeLang', $locale);
        }])
            ->where('degree_id', $degreeId)
            ->get()
            ->map(function ($program) use ($locale) {
                $translation = $program->translations->first();

                return [
                    'id' => $program->id,
                    'degree_id' => $program->degree_id,
                    'description' => $translation?->description ?? '',
                    'attached_file' => $program->attached_file,
                ];
            });
    }
}

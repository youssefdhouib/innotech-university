<?php

namespace App\Services;

use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsService
{
    public function getAll(Request $request)
    {
        $codeLang = app()->getLocale();

        return News::with('translations')->get()->map(function ($news) use ($codeLang) {
            $translation = $news->translations->firstWhere('codeLang', $codeLang);

            return [
                'id'           => $news->id,
                'category'     => $news->category,
                'event_date'   => $news->event_date,
                'is_published' => $news->is_published,
                'image_url'    => $news->image_url,
                'title'        => $translation?->title,
                'description'  => $translation?->description,
                'location'     => $translation?->location,
                'translations' => $news->translations->mapWithKeys(function ($t) {
                    return [
                        $t->codeLang => [
                            'title'       => $t->title,
                            'description' => $t->description,
                            'location'    => $t->location,
                        ]
                    ];
                }),
            ];
        });
    }


    public function getOne($id, Request $request)
    {
        $codeLang = app()->getLocale();
        $news = News::with('translations')->findOrFail($id);

        $translation = $news->translations->firstWhere('codeLang', $codeLang);

        $response = [
            'id'           => $news->id,
            'category'     => $news->category,
            'event_date'   => $news->event_date,
            'is_published' => $news->is_published,
            'image_url'    => $news->image_url,
            'title'        => $translation?->title,
            'description'  => $translation?->description,
            'location'     => $translation?->location,
        ];

        if ($request->boolean('include_translations')) {
            $response['translations'] = $news->translations->mapWithKeys(function ($t) {
                return [
                    $t->codeLang => [
                        'title'       => $t->title,
                        'description' => $t->description,
                        'location'    => $t->location,
                    ]
                ];
            });
        }

        return $response;
    }

    public function store(Request $request)
    {
        $data = $request->only(['category', 'event_date', 'is_published', 'image_url']);
        $translations = $request->get('translations');

        return DB::transaction(function () use ($data, $translations) {
            $news = News::create($data);

            foreach ($translations as $t) {
                NewsTranslation::create([
                    'news_id'     => $news->id,
                    'codeLang'    => $t['codeLang'],
                    'title'       => $t['title'],
                    'description' => $t['description'] ?? null,
                    'location'    => $t['location'] ?? null,
                ]);
            }

            return $news->load('translations');
        });
    }

    public function update($id, Request $request)
    {
        $news = News::findOrFail($id);
        $news->update($request->only(['category', 'event_date', 'is_published', 'image_url']));

        $translations = $request->get('translations', []);

        foreach ($translations as $t) {
            NewsTranslation::updateOrCreate(
                ['news_id' => $news->id, 'codeLang' => $t['codeLang']],
                [
                    'title'       => $t['title'],
                    'description' => $t['description'] ?? null,
                    'location'    => $t['location'] ?? null,
                ]
            );
        }

        return $news->load('translations');
    }

    public function delete($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
    }
}

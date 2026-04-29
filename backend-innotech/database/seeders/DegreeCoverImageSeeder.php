<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Degree;

class DegreeCoverImageSeeder extends Seeder
{
    public function run(): void
    {
        $coverImages = [
            'gl-ai.jpg',
            'bigdata.jpg',
            'iot.jpg',
            'mecatronique.jpg',
            'affaires.jpg',
            'data-industrie.jpg',
            'devops.jpg',
            'auto-test.jpg',
            'ai-master.jpg',
        ];

        foreach ($coverImages as $index => $image) {
            $degree = Degree::find($index + 1); // id de 1 à 9
            if ($degree) {
                $degree->update([
                    'cover_image' => '/degrees/' . $image,
                ]);
            }
        }
    }
}

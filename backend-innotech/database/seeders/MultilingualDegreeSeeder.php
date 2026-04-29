<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Degree;
use App\Models\DegreeTranslation;
use Illuminate\Support\Facades\DB;

class MultilingualDegreeSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('degree_translations')->truncate();
        DB::table('degrees')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $langData = [
            'fr' => [
                ['name' => 'Génie Logiciel et Intelligence Artificielle', 'level' => 'Licence'],
                ['name' => 'Big Data et Analyse de Données', 'level' => 'Licence'],
                ['name' => 'Systèmes Embarqués et Internet des Objets', 'level' => 'Licence'],
                ['name' => 'Mécatronique', 'level' => 'Licence'],
                ['name' => 'Ingénierie et Administration des Affaires', 'level' => 'Licence'],
                ['name' => 'Sciences des Données Industrielles', 'level' => 'Licence'],
                ['name' => 'Génie Logiciel et DevOps', 'level' => 'Mastere'],
                ['name' => 'Ingénierie Automobile et Test Logiciel', 'level' => 'Mastere'],
                ['name' => 'Data et Intelligence Artificielle', 'level' => 'Mastere'],
            ],
            'en' => [
                ['name' => 'Software Engineering and Artificial Intelligence'],
                ['name' => 'Big Data and Data Analysis'],
                ['name' => 'Embedded Systems and IoT'],
                ['name' => 'Mechatronics'],
                ['name' => 'Engineering and Business Administration'],
                ['name' => 'Industrial Data Science'],
                ['name' => 'Software Engineering and DevOps'],
                ['name' => 'Automotive Engineering and Software Testing'],
                ['name' => 'Data and Artificial Intelligence'],
            ],
            'ar' => [
                ['name' => 'هندسة البرمجيات والذكاء الاصطناعي'],
                ['name' => 'البيانات الضخمة وتحليل البيانات'],
                ['name' => 'الأنظمة المدمجة وإنترنت الأشياء'],
                ['name' => 'الميكاترونيك'],
                ['name' => 'الهندسة وإدارة الأعمال'],
                ['name' => 'علوم البيانات الصناعية'],
                ['name' => 'هندسة البرمجيات وديفوبس'],
                ['name' => 'الهندسة الميكانيكية واختبار البرمجيات'],
                ['name' => 'البيانات والذكاء الاصطناعي'],
            ],
        ];

        $frData = $langData['fr'];
        $enData = $langData['en'];
        $arData = $langData['ar'];

        for ($i = 0; $i < count($frData); $i++) {
            $fr = $frData[$i];
            $en = $enData[$i];
            $ar = $arData[$i];

            // Create base degree (level only)
            $degree = Degree::create([
                'level' => $fr['level'],
            ]);

            // French translation (default)
            DegreeTranslation::create([
                'degree_id' => $degree->id,
                'codeLang' => 'fr',
                'name' => $fr['name'],
            ]);

            // English translation
            DegreeTranslation::create([
                'degree_id' => $degree->id,
                'codeLang' => 'en',
                'name' => $en['name'],
            ]);

            // Arabic translation
            DegreeTranslation::create([
                'degree_id' => $degree->id,
                'codeLang' => 'ar',
                'name' => $ar['name'],
            ]);
        }
    }
}

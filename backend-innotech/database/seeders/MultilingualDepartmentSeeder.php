<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Department;
use App\Models\DepartmentTranslation;

class MultilingualDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('department_translations')->truncate();
        DB::table('departments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Cover image filenames (match department index)
        $coverImages = [
            'departments/Département de Génie Logiciel et Développement.jpg',
            'departments/Département de Data Science et Intelligence Artificielle.jpg',
            'departments/Département de Cybersécurité et Réseaux.jpg',
            'departments/Département des Systèmes Embarqués et IoT.jpg',
            'departments/Département de Transformation Digitale et Management.jpg',
        ];

        $langData = [
            'fr' => [
                ['name' => 'Département de Génie Logiciel et Développement', 'description' => 'Spécialisé en développement logiciel, génie logiciel, et méthodologies agiles.'],
                ['name' => 'Département de Data Science et Intelligence Artificielle', 'description' => 'Spécialisé en analyse de données, machine learning et intelligence artificielle appliquée.'],
                ['name' => 'Département de Cybersécurité et Réseaux', 'description' => 'Focalisé sur la sécurité informatique, les réseaux et la cybersécurité avancée.'],
                ['name' => 'Département des Systèmes Embarqués et IoT', 'description' => 'Spécialisé en conception de systèmes embarqués et solutions IoT.'],
                ['name' => 'Département de Transformation Digitale et Management', 'description' => 'Formations en gestion de projet IT, transformation digitale et management des systèmes.'],
            ],
            'en' => [
                ['name' => 'Software Engineering and Development Department', 'description' => 'Specialized in software development, engineering, and agile methodologies.'],
                ['name' => 'Data Science and Artificial Intelligence Department', 'description' => 'Specialized in data analysis, machine learning, and applied AI.'],
                ['name' => 'Cybersecurity and Networks Department', 'description' => 'Focused on IT security, networks, and advanced cybersecurity.'],
                ['name' => 'Embedded Systems and IoT Department', 'description' => 'Specialized in embedded systems design and IoT solutions.'],
                ['name' => 'Digital Transformation and Management Department', 'description' => 'Training in IT project management, digital transformation, and systems management.'],
            ],
            'ar' => [
                ['name' => 'قسم هندسة البرمجيات والتطوير', 'description' => 'متخصص في تطوير البرمجيات وهندسة البرمجيات والمنهجيات الرشيقة.'],
                ['name' => 'قسم علوم البيانات والذكاء الاصطناعي', 'description' => 'متخصص في تحليل البيانات، التعلم الآلي، والذكاء الاصطناعي التطبيقي.'],
                ['name' => 'قسم الأمن السيبراني والشبكات', 'description' => 'يركز على أمن المعلومات، الشبكات، والأمن السيبراني المتقدم.'],
                ['name' => 'قسم الأنظمة المدمجة وإنترنت الأشياء', 'description' => 'متخصص في تصميم الأنظمة المدمجة وحلول إنترنت الأشياء.'],
                ['name' => 'قسم التحول الرقمي والإدارة', 'description' => 'تكوين في إدارة المشاريع الرقمية والتحول الرقمي وإدارة الأنظمة.'],
            ],
        ];

        $frData = $langData['fr'];
        $enData = $langData['en'];
        $arData = $langData['ar'];

        for ($i = 0; $i < count($frData); $i++) {
            $coverImage = $coverImages[$i];

            // Fake image if missing
            if (!Storage::disk('public')->exists($coverImage)) {
                Storage::disk('public')->put($coverImage, "Fake cover image for {$frData[$i]['name']}");
            }

            // Create department with cover_image
            $department = Department::create([
                'cover_image' => $coverImage
            ]);

            // Translations
            DepartmentTranslation::insert([
                [
                    'department_id' => $department->id,
                    'codeLang' => 'fr',
                    'name' => $frData[$i]['name'],
                    'description' => $frData[$i]['description'],
                ],
                [
                    'department_id' => $department->id,
                    'codeLang' => 'en',
                    'name' => $enData[$i]['name'],
                    'description' => $enData[$i]['description'],
                ],
                [
                    'department_id' => $department->id,
                    'codeLang' => 'ar',
                    'name' => $arData[$i]['name'],
                    'description' => $arData[$i]['description'],
                ],
            ]);
        }
    }
}

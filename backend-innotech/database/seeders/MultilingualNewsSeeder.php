<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MultilingualNewsSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('news_translations')->truncate();
        DB::table('news')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $langData = [
            'fr' => [
                [
                    'title' => 'Hackathon IA & Apprentissage Automatique',
                    'description' => 'Participez à un défi de 48 heures pour créer des solutions innovantes en IA.',
                    'category' => 'event',
                    'is_published' => true,
                    'image_url' => 'news/images/ai-hackathon.jpg',
                    'event_date' => '2024-10-12',
                    'location' => 'Amphi A, Campus InnoTech',
                ],
                [
                    'title' => 'Salon des Carrières IT & Tech',
                    'description' => 'Rencontrez les meilleures entreprises tech et explorez les opportunités.',
                    'category' => 'event',
                    'is_published' => true,
                    'image_url' => 'news/images/career-fair.jpg',
                    'event_date' => '2024-11-05',
                    'location' => 'Salle Centrale, Campus InnoTech',
                ],
                [
                    'title' => 'Journée Sportive Annuelle',
                    'description' => 'Une journée de compétitions et d’activités de cohésion pour étudiants et professeurs.',
                    'category' => 'event',
                    'is_published' => true,
                    'image_url' => 'news/images/sports-day.jpg',
                    'event_date' => '2024-12-01',
                    'location' => 'Stade Principal, Campus InnoTech',
                ],
                [
                    'title' => 'Séminaire sur la Blockchain',
                    'description' => 'Découvrez les tendances et cas d’usage de la blockchain.',
                    'category' => 'announcement',
                    'is_published' => true,
                    'image_url' => 'news/images/blockchain-seminar.jpg',
                    'event_date' => null,
                    'location' => 'Salle de conférence 1',
                ],
                [
                    'title' => 'Nouvelles Ressources à la Bibliothèque',
                    'description' => 'Découvrez les nouvelles ressources numériques ajoutées à notre bibliothèque universitaire.',
                    'category' => 'announcement',
                    'is_published' => true,
                    'image_url' => 'news/images/library-resources.jpg',
                    'event_date' => null,
                    'location' => 'Bibliothèque',
                ],
                [
                    'title' => 'Nouveaux Horaires de la Cafétéria',
                    'description' => 'Horaires mis à jour de la cafétéria pour le semestre à venir.',
                    'category' => 'announcement',
                    'is_published' => true,
                    'image_url' => 'news/images/cafeteria-hours.jpg',
                    'event_date' => null,
                    'location' => 'Cafétéria',
                ],
                [
                    'title' => 'Avis sur le Calendrier Académique',
                    'description' => 'Calendrier académique mis à jour pour le prochain semestre.',
                    'category' => 'notice',
                    'is_published' => true,
                    'image_url' => 'news/images/academic-calendar.jpg',
                    'event_date' => null,
                    'location' => 'Bureau Administratif',
                ],
                [
                    'title' => 'Avis de Maintenance',
                    'description' => 'Maintenance du réseau du campus prévue ce week-end.',
                    'category' => 'notice',
                    'is_published' => true,
                    'image_url' => 'news/images/maintenance-notice.jpg',
                    'event_date' => null,
                    'location' => 'Service Informatique',
                ],
                [
                    'title' => 'Planning des Examens Publié',
                    'description' => 'Consultez le portail étudiant pour voir votre planning mis à jour.',
                    'category' => 'notice',
                    'is_published' => true,
                    'image_url' => 'news/images/exam-schedule.jpg',
                    'event_date' => null,
                    'location' => 'Portail Étudiant',
                ],
            ],
            'en' => [
                [
                    'title' => 'AI & Machine Learning Hackathon',
                    'description' => 'Join us for a 48-hour challenge building innovative AI solutions.',
                    'location' => 'Amphi A, InnoTech Campus',
                ],
                [
                    'title' => 'IT & Tech Career Fair',
                    'description' => 'Meet top tech companies and explore opportunities.',
                    'location' => 'Central Hall, InnoTech Campus',
                ],
                [
                    'title' => 'Annual Sports Day',
                    'description' => 'A day of competitions and team-building activities for students and faculty.',
                    'location' => 'Main Stadium, InnoTech Campus',
                ],
                [
                    'title' => 'Blockchain Seminar',
                    'description' => 'Discover blockchain trends and use cases.',
                    'location' => 'Conference Room 1',
                ],
                [
                    'title' => 'New Library Resources Available',
                    'description' => 'Explore the new e-resources added to our university library.',
                    'location' => 'Library',
                ],
                [
                    'title' => 'New Cafeteria Hours',
                    'description' => 'Updated cafeteria hours for the upcoming semester.',
                    'location' => 'Cafeteria',
                ],
                [
                    'title' => 'Academic Calendar Notice',
                    'description' => 'Updated academic calendar for the next semester.',
                    'location' => 'Admin Office',
                ],
                [
                    'title' => 'Maintenance Notice',
                    'description' => 'Campus network maintenance scheduled for this weekend.',
                    'location' => 'IT Department',
                ],
                [
                    'title' => 'Exam Schedule Posted',
                    'description' => 'Check the student portal for your updated exam schedule.',
                    'location' => 'Online Portal',
                ],
            ],
            'ar' => [
                [
                    'title' => 'هاكاثون الذكاء الاصطناعي وتعلم الآلة',
                    'description' => 'انضم إلينا في تحدٍ مدته 48 ساعة لإنشاء حلول مبتكرة باستخدام الذكاء الاصطناعي.',
                    'location' => 'المدرج A، حرم InnoTech',
                ],
                [
                    'title' => 'معرض الوظائف في مجال التكنولوجيا',
                    'description' => 'قابل أفضل شركات التكنولوجيا واستكشف فرص العمل.',
                    'location' => 'القاعة المركزية، حرم InnoTech',
                ],
                [
                    'title' => 'اليوم الرياضي السنوي',
                    'description' => 'يوم من المسابقات والأنشطة لبناء الفريق بين الطلاب والأساتذة.',
                    'location' => 'الملعب الرئيسي، حرم InnoTech',
                ],
                [
                    'title' => 'ندوة حول البلوكشين',
                    'description' => 'تعرف على أحدث اتجاهات وتطبيقات تكنولوجيا البلوكشين.',
                    'location' => 'قاعة المؤتمرات',
                ],
                [
                    'title' => 'موارد جديدة في المكتبة',
                    'description' => 'استكشف الموارد الإلكترونية الجديدة المضافة إلى مكتبتنا الجامعية.',
                    'location' => 'المكتبة',
                ],
                [
                    'title' => 'مواعيد جديدة للمقصف',
                    'description' => 'تحديث مواعيد المقصف للفصل الدراسي القادم.',
                    'location' => 'المقصف',
                ],
                [
                    'title' => 'إشعار التقويم الأكاديمي',
                    'description' => 'تم تحديث التقويم الأكاديمي للفصل الدراسي القادم.',
                    'location' => 'الإدارة',
                ],
                [
                    'title' => 'إشعار صيانة',
                    'description' => 'سيتم إجراء صيانة لشبكة الحرم الجامعي نهاية هذا الأسبوع.',
                    'location' => 'قسم تكنولوجيا المعلومات',
                ],
                [
                    'title' => 'جدول الامتحانات منشور',
                    'description' => 'تحقق من بوابة الطالب للاطلاع على جدول امتحاناتك المحدث.',
                    'location' => 'بوابة الطالب',
                ],
            ]
        ];
        $frData = $langData['fr'];
        $enData = $langData['en'];
        $arData = $langData['ar'];
        for ($i = 0; $i < count($frData); $i++) {
            $fr = $frData[$i];
            $en = $enData[$i];
            $ar = $arData[$i];

            // Create base news row without translatable fields
            $news = News::create([
                'category'     => $fr['category'],
                'event_date'   => $fr['event_date'] ?? null,
                'is_published' => $fr['is_published'],
                'image_url'    => $fr['image_url'],
            ]);

            // Add FR translation
            NewsTranslation::create([
                'news_id'     => $news->id,
                'codeLang'    => 'fr',
                'title'       => $fr['title'],
                'description' => $fr['description'],
                'location'    => $fr['location'],
            ]);

            // Add EN translation
            NewsTranslation::create([
                'news_id'     => $news->id,
                'codeLang'    => 'en',
                'title'       => $en['title'],
                'description' => $en['description'],
                'location'    => $en['location'],
            ]);

            // Add AR translation
            NewsTranslation::create([
                'news_id'     => $news->id,
                'codeLang'    => 'ar',
                'title'       => $ar['title'],
                'description' => $ar['description'],
                'location'    => $ar['location'],
            ]);
        }
    }
}

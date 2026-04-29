<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Professor;
use App\Models\ProfessorTranslation;

class MultilingualProfessorSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('professor_translations')->truncate();
        DB::table('professors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $langData = [
            'fr' => [
                [
                    'first_name' => 'Amine', 'last_name' => 'Ben Ali', 'email' => 'amine.benali@test.com',
                    'speciality' => 'Développement Web', 'grade' => 'Maître Assistant', 'profile_slug' => 'amine-ben-ali',
                    'photo_url' => 'professors/images/amine-ben-ali.jpg', 'department_id' => 1, 'cv_attached_file' => 'professors/cv/amine-ben-ali.pdf',
                ],
                [
                    'first_name' => 'Yasmine', 'last_name' => 'Ferjani', 'email' => 'yasmine.ferjani@test.com',
                    'speciality' => 'Architecture Logicielle', 'grade' => 'Professeur', 'profile_slug' => 'yasmine-ferjani',
                    'photo_url' => 'professors/images/yasmine-ferjani.jpg', 'department_id' => 1, 'cv_attached_file' => 'professors/cv/yasmine-ferjani.pdf',
                ],
                [
                    'first_name' => 'Mohamed', 'last_name' => 'Guesmi', 'email' => 'mohamed.guesmi@test.com',
                    'speciality' => 'DevOps', 'grade' => 'Assistant', 'profile_slug' => 'mohamed-guesmi',
                    'photo_url' => 'professors/images/mohamed-guesmi.jpg', 'department_id' => 1, 'cv_attached_file' => 'professors/cv/mohamed-guesmi.pdf',
                ],
                [
                    'first_name' => 'Sarra', 'last_name' => 'Haddad', 'email' => 'sarra.haddad@test.com',
                    'speciality' => 'Mobile Development', 'grade' => 'Maître de Conférences', 'profile_slug' => 'sarra-haddad',
                    'photo_url' => 'professors/images/sarra-haddad.jpg', 'department_id' => 1, 'cv_attached_file' => 'professors/cv/sarra-haddad.pdf',
                ],

                // Département 2: Data Science et IA
                [
                    'first_name' => 'Rami', 'last_name' => 'Trabelsi', 'email' => 'rami.trabelsi@test.com',
                    'speciality' => 'Machine Learning', 'grade' => 'Maître Assistant', 'profile_slug' => 'rami-trabelsi',
                    'photo_url' => 'professors/images/rami-trabelsi.jpg', 'department_id' => 2, 'cv_attached_file' => 'professors/cv/rami-trabelsi.pdf',
                ],
                [
                    'first_name' => 'Nour', 'last_name' => 'Ayari', 'email' => 'nour.ayari@test.com',
                    'speciality' => 'Data Mining', 'grade' => 'Professeur', 'profile_slug' => 'nour-ayari',
                    'photo_url' => 'professors/images/nour-ayari.jpg', 'department_id' => 2, 'cv_attached_file' => 'professors/cv/nour-ayari.pdf',
                ],
                [
                    'first_name' => 'Karim', 'last_name' => 'Jaziri', 'email' => 'karim.jaziri@test.com',
                    'speciality' => 'Big Data Analytics', 'grade' => 'Assistant', 'profile_slug' => 'karim-jaziri',
                    'photo_url' => 'professors/images/karim-jaziri.jpg', 'department_id' => 2, 'cv_attached_file' => 'professors/cv/karim-jaziri.pdf',
                ],
                [
                    'first_name' => 'Leila', 'last_name' => 'Khemiri', 'email' => 'leila.khemiri@test.com',
                    'speciality' => 'IA Appliquée', 'grade' => 'Maître de Conférences', 'profile_slug' => 'leila-khemiri',
                    'photo_url' => 'professors/images/leila-khemiri.jpg', 'department_id' => 2, 'cv_attached_file' => 'professors/cv/leila-khemiri.pdf',
                ],

                // Département 3: Cybersécurité et Réseaux
                [
                    'first_name' => 'Omar', 'last_name' => 'Sassi', 'email' => 'omar.sassi@test.com',
                    'speciality' => 'Cryptographie', 'grade' => 'Maître Assistant', 'profile_slug' => 'omar-sassi',
                    'photo_url' => 'professors/images/omar-sassi.jpg', 'department_id' => 3, 'cv_attached_file' => 'professors/cv/omar-sassi.pdf',
                ],
                [
                    'first_name' => 'Mouna', 'last_name' => 'Harzallah', 'email' => 'mouna.harzallah@test.com',
                    'speciality' => 'Sécurité Réseaux', 'grade' => 'Professeur', 'profile_slug' => 'mouna-harzallah',
                    'photo_url' => 'professors/images/mouna-harzallah.jpg', 'department_id' => 3, 'cv_attached_file' => 'professors/cv/mouna-harzallah.pdf',
                ],
                [
                    'first_name' => 'Hichem', 'last_name' => 'Saadaoui', 'email' => 'hichem.saadaoui@test.com',
                    'speciality' => 'Ethical Hacking', 'grade' => 'Assistant', 'profile_slug' => 'hichem-saadaoui',
                    'photo_url' => 'professors/images/hichem-saadaoui.jpg', 'department_id' => 3, 'cv_attached_file' => 'professors/cv/hichem-saadaoui.pdf',
                ],
                [
                    'first_name' => 'Ines', 'last_name' => 'Mejri', 'email' => 'ines.mejri@test.com',
                    'speciality' => 'Sécurité Cloud', 'grade' => 'Maître de Conférences', 'profile_slug' => 'ines-mejri',
                    'photo_url' => 'professors/images/ines-mejri.jpg', 'department_id' => 3, 'cv_attached_file' => 'professors/cv/ines-mejri.pdf',
                ],

                // Département 4: Systèmes Embarqués et IoT
                [
                    'first_name' => 'Anis', 'last_name' => 'Gharbi', 'email' => 'anis.gharbi@test.com',
                    'speciality' => 'IoT', 'grade' => 'Maître Assistant', 'profile_slug' => 'anis-gharbi',
                    'photo_url' => 'professors/images/anis-gharbi.jpg', 'department_id' => 4, 'cv_attached_file' => 'professors/cv/anis-gharbi.pdf',
                ],
                [
                    'first_name' => 'Fatma', 'last_name' => 'Maatoug', 'email' => 'fatma.maatoug@test.com',
                    'speciality' => 'Systèmes Embarqués', 'grade' => 'Professeur', 'profile_slug' => 'fatma-maatoug',
                    'photo_url' => 'professors/images/fatma-maatoug.jpg', 'department_id' => 4, 'cv_attached_file' => 'professors/cv/fatma-maatoug.pdf',
                ],
                [
                    'first_name' => 'Mehdi', 'last_name' => 'Dhaoui', 'email' => 'mehdi.dhaoui@test.com',
                    'speciality' => 'Communication sans fil', 'grade' => 'Assistant', 'profile_slug' => 'mehdi-dhaoui',
                    'photo_url' => 'professors/images/mehdi-dhaoui.jpg', 'department_id' => 4, 'cv_attached_file' => 'professors/cv/mehdi-dhaoui.pdf',
                ],
                [
                    'first_name' => 'Nesrine', 'last_name' => 'Kallel', 'email' => 'nesrine.kallel@test.com',
                    'speciality' => 'Microcontrôleurs', 'grade' => 'Maître de Conférences', 'profile_slug' => 'nesrine-kallel',
                    'photo_url' => 'professors/images/nesrine-kallel.jpg', 'department_id' => 4, 'cv_attached_file' => 'professors/cv/nesrine-kallel.pdf',
                ],

                // Département 5: Transformation Digitale et Management
                [
                    'first_name' => 'Sami', 'last_name' => 'Jouini', 'email' => 'sami.jouini@test.com',
                    'speciality' => 'Gestion de projet IT', 'grade' => 'Maître Assistant', 'profile_slug' => 'sami-jouini',
                    'photo_url' => 'professors/images/sami-jouini.jpg', 'department_id' => 5, 'cv_attached_file' => 'professors/cv/sami-jouini.pdf',
                ],
                [
                    'first_name' => 'Ameni', 'last_name' => 'Feki', 'email' => 'ameni.feki@test.com',
                    'speciality' => 'Management Digital', 'grade' => 'Professeur', 'profile_slug' => 'ameni-feki',
                    'photo_url' => 'professors/images/ameni-feki.jpg', 'department_id' => 5, 'cv_attached_file' => 'professors/cv/ameni-feki.pdf',
                ],
                [
                    'first_name' => 'Yassine', 'last_name' => 'Bouazizi', 'email' => 'yassine.bouazizi@test.com',
                    'speciality' => 'Transformation Digitale', 'grade' => 'Assistant', 'profile_slug' => 'yassine-bouazizi',
                    'photo_url' => 'professors/images/yassine-bouazizi.jpg', 'department_id' => 5, 'cv_attached_file' => 'professors/cv/yassine-bouazizi.pdf',
                ],
                [
                    'first_name' => 'Khadija', 'last_name' => 'Chebbi', 'email' => 'khadija.chebbi@test.com',
                    'speciality' => 'E-Business', 'grade' => 'Maître de Conférences', 'profile_slug' => 'khadija-chebbi',
                    'photo_url' => 'professors/images/khadija-chebbi.jpg', 'department_id' => 5, 'cv_attached_file' => 'professors/cv/khadija-chebbi.pdf',
                ],
                ],
            'en' => [
                [ 'first_name' => 'Amine', 'last_name' => 'Ben Ali', 'grade' => 'Assistant Professor', 'speciality' => 'Web Development' ],
                [ 'first_name' => 'Yasmine', 'last_name' => 'Ferjani', 'grade' => 'Professor', 'speciality' => 'Software Architecture' ],
                [ 'first_name' => 'Mohamed', 'last_name' => 'Guesmi', 'grade' => 'Assistant', 'speciality' => 'DevOps' ],
                [ 'first_name' => 'Sarra', 'last_name' => 'Haddad', 'grade' => 'Associate Professor', 'speciality' => 'Mobile Development' ],
                [ 'first_name' => 'Rami', 'last_name' => 'Trabelsi', 'grade' => 'Assistant Professor', 'speciality' => 'Machine Learning' ],
                [ 'first_name' => 'Nour', 'last_name' => 'Ayari', 'grade' => 'Professor', 'speciality' => 'Data Mining' ],
                [ 'first_name' => 'Karim', 'last_name' => 'Jaziri', 'grade' => 'Assistant', 'speciality' => 'Big Data Analytics' ],
                [ 'first_name' => 'Leila', 'last_name' => 'Khemiri', 'grade' => 'Associate Professor', 'speciality' => 'Applied AI' ],
                [ 'first_name' => 'Omar', 'last_name' => 'Sassi', 'grade' => 'Assistant Professor', 'speciality' => 'Cryptography' ],
                [ 'first_name' => 'Mouna', 'last_name' => 'Harzallah', 'grade' => 'Professor', 'speciality' => 'Network Security' ],
                [ 'first_name' => 'Hichem', 'last_name' => 'Saadaoui', 'grade' => 'Assistant', 'speciality' => 'Ethical Hacking' ],
                [ 'first_name' => 'Ines', 'last_name' => 'Mejri', 'grade' => 'Associate Professor', 'speciality' => 'Cloud Security' ],
                [ 'first_name' => 'Anis', 'last_name' => 'Gharbi', 'grade' => 'Assistant Professor', 'speciality' => 'IoT' ],
                [ 'first_name' => 'Fatma', 'last_name' => 'Maatoug', 'grade' => 'Professor', 'speciality' => 'Embedded Systems' ],
                [ 'first_name' => 'Mehdi', 'last_name' => 'Dhaoui', 'grade' => 'Assistant', 'speciality' => 'Wireless Communication' ],
                [ 'first_name' => 'Nesrine', 'last_name' => 'Kallel', 'grade' => 'Associate Professor', 'speciality' => 'Microcontrollers' ],
                [ 'first_name' => 'Sami', 'last_name' => 'Jouini', 'grade' => 'Assistant Professor', 'speciality' => 'IT Project Management' ],
                [ 'first_name' => 'Ameni', 'last_name' => 'Feki', 'grade' => 'Professor', 'speciality' => 'Digital Management' ],
                [ 'first_name' => 'Yassine', 'last_name' => 'Bouazizi', 'grade' => 'Assistant', 'speciality' => 'Digital Transformation' ],
                [ 'first_name' => 'Khadija', 'last_name' => 'Chebbi', 'grade' => 'Associate Professor', 'speciality' => 'E-Business' ],
            ],
            'ar' => [
                [ 'first_name' => 'أمين', 'last_name' => 'بن علي', 'grade' => 'أستاذ مساعد', 'speciality' => 'تطوير الويب' ],
                [ 'first_name' => 'ياسمين', 'last_name' => 'فرجاني', 'grade' => 'أستاذ', 'speciality' => 'هندسة البرمجيات' ],
                [ 'first_name' => 'محمد', 'last_name' => 'قاسمي', 'grade' => 'مساعد', 'speciality' => 'ديف أوبس' ],
                [ 'first_name' => 'سارة', 'last_name' => 'حداد', 'grade' => 'أستاذ محاضر', 'speciality' => 'تطوير المحمول' ],
                [ 'first_name' => 'رامي', 'last_name' => 'طرابلسي', 'grade' => 'أستاذ مساعد', 'speciality' => 'تعلم الآلة' ],
                [ 'first_name' => 'نور', 'last_name' => 'عياري', 'grade' => 'أستاذ', 'speciality' => 'تنقيب البيانات' ],
                [ 'first_name' => 'كريم', 'last_name' => 'جعيزري', 'grade' => 'مساعد', 'speciality' => 'تحليلات البيانات الضخمة' ],
                [ 'first_name' => 'ليلى', 'last_name' => 'خميري', 'grade' => 'أستاذ محاضر', 'speciality' => 'الذكاء الاصطناعي التطبيقي' ],
                [ 'first_name' => 'عمر', 'last_name' => 'ساسي', 'grade' => 'أستاذ مساعد', 'speciality' => 'التشفير' ],
                [ 'first_name' => 'منى', 'last_name' => 'حرز الله', 'grade' => 'أستاذ', 'speciality' => 'أمن الشبكات' ],
                [ 'first_name' => 'هشام', 'last_name' => 'السعداوي', 'grade' => 'مساعد', 'speciality' => 'القرصنة الأخلاقية' ],
                [ 'first_name' => 'إيناس', 'last_name' => 'مجري', 'grade' => 'أستاذ محاضر', 'speciality' => 'أمن السحابة' ],
                [ 'first_name' => 'أنيس', 'last_name' => 'الغربي', 'grade' => 'أستاذ مساعد', 'speciality' => 'إنترنت الأشياء' ],
                [ 'first_name' => 'فاطمة', 'last_name' => 'معتوق', 'grade' => 'أستاذ', 'speciality' => 'الأنظمة المدمجة' ],
                [ 'first_name' => 'مهدي', 'last_name' => 'ضاوي', 'grade' => 'مساعد', 'speciality' => 'الاتصالات اللاسلكية' ],
                [ 'first_name' => 'نسرين', 'last_name' => 'كلاّل', 'grade' => 'أستاذ محاضر', 'speciality' => 'المتحكمات الدقيقة' ],
                [ 'first_name' => 'سامي', 'last_name' => 'جويني', 'grade' => 'أستاذ مساعد', 'speciality' => 'إدارة مشاريع تكنولوجيا المعلومات' ],
                [ 'first_name' => 'آمنة', 'last_name' => 'فكي', 'grade' => 'أستاذ', 'speciality' => 'الإدارة الرقمية' ],
                [ 'first_name' => 'ياسين', 'last_name' => 'بوعزيزي', 'grade' => 'مساعد', 'speciality' => 'التحول الرقمي' ],
                [ 'first_name' => 'خديجة', 'last_name' => 'شبيبي', 'grade' => 'أستاذ محاضر', 'speciality' => 'الأعمال الإلكترونية' ],
            ],
        ];

        $frData = $langData['fr'];  // You already have this list ready
        $enData = $langData['en'];
        $arData = $langData['ar'];

        for ($i = 0; $i < count($frData); $i++) {
            $fr = $frData[$i];
            $en = $enData[$i];
            $ar = $arData[$i];

            // Save files if needed
            if (!Storage::disk('public')->exists($fr['photo_url'])) {
                Storage::disk('public')->put($fr['photo_url'], 'fake image');
            }
            if (!Storage::disk('public')->exists($fr['cv_attached_file'])) {
                Storage::disk('public')->put($fr['cv_attached_file'], 'fake cv');
            }

            // Insert base professor
            $professor = Professor::create([
                'email'             => $fr['email'],
                'profile_slug'      => $fr['profile_slug'],
                'photo_url'         => $fr['photo_url'],
                'cv_attached_file'  => $fr['cv_attached_file'],
                'department_id'     => $fr['department_id'],
            ]);

            // French
            ProfessorTranslation::create([
                'professor_id' => $professor->id,
                'codeLang'     => 'fr',
                'first_name'   => $fr['first_name'],
                'last_name'    => $fr['last_name'],
                'grade'        => $fr['grade'],
                'speciality'   => $fr['speciality'],
            ]);

            // English
            ProfessorTranslation::create([
                'professor_id' => $professor->id,
                'codeLang'     => 'en',
                'first_name'   => $en['first_name'],
                'last_name'    => $en['last_name'],
                'grade'        => $en['grade'],
                'speciality'   => $en['speciality'],
            ]);

            // Arabic
            ProfessorTranslation::create([
                'professor_id' => $professor->id,
                'codeLang'     => 'ar',
                'first_name'   => $ar['first_name'],
                'last_name'    => $ar['last_name'],
                'grade'        => $ar['grade'],
                'speciality'   => $ar['speciality'],
            ]);
        }
    }
}

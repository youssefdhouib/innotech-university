<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;

class ProfessorArabicNameSeeder extends Seeder
{
    public function run(): void
    {
        $arabicNames = [
            'amine.benali@test.com' => ['first_name_ar' => 'أمين', 'last_name_ar' => 'بن علي'],
            'yasmine.ferjani@test.com' => ['first_name_ar' => 'ياسمين', 'last_name_ar' => 'فرجاني'],
            'mohamed.guesmi@test.com' => ['first_name_ar' => 'محمد', 'last_name_ar' => 'قاسمي'],
            'sarra.haddad@test.com' => ['first_name_ar' => 'سارة', 'last_name_ar' => 'حداد'],

            'rami.trabelsi@test.com' => ['first_name_ar' => 'رامي', 'last_name_ar' => 'طرابلسي'],
            'nour.ayari@test.com' => ['first_name_ar' => 'نور', 'last_name_ar' => 'عياري'],
            'karim.jaziri@test.com' => ['first_name_ar' => 'كريم', 'last_name_ar' => 'جزيري'],
            'leila.khemiri@test.com' => ['first_name_ar' => 'ليلى', 'last_name_ar' => 'خميري'],

            'omar.sassi@test.com' => ['first_name_ar' => 'عمر', 'last_name_ar' => 'ساسي'],
            'mouna.harzallah@test.com' => ['first_name_ar' => 'منى', 'last_name_ar' => 'حرز الله'],
            'hichem.saadaoui@test.com' => ['first_name_ar' => 'هيثم', 'last_name_ar' => 'سعداوي'],
            'ines.mejri@test.com' => ['first_name_ar' => 'إيناس', 'last_name_ar' => 'مجري'],

            'anis.gharbi@test.com' => ['first_name_ar' => 'أنيس', 'last_name_ar' => 'غربي'],
            'fatma.maatoug@test.com' => ['first_name_ar' => 'فاطمة', 'last_name_ar' => 'ماتوق'],
            'mehdi.dhaoui@test.com' => ['first_name_ar' => 'مهدي', 'last_name_ar' => 'ضاوي'],
            'nesrine.kallel@test.com' => ['first_name_ar' => 'نسرين', 'last_name_ar' => 'كلال'],

            'sami.jouini@test.com' => ['first_name_ar' => 'سامي', 'last_name_ar' => 'جويني'],
            'ameni.feki@test.com' => ['first_name_ar' => 'آمنة', 'last_name_ar' => 'فقي'],
            'yassine.bouazizi@test.com' => ['first_name_ar' => 'ياسين', 'last_name_ar' => 'بوعزيزي'],
            'khadija.chebbi@test.com' => ['first_name_ar' => 'خديجة', 'last_name_ar' => 'الشابي'],
        ];

        foreach ($arabicNames as $email => $names) {
            Professor::where('email', $email)->update($names);
        }

        $this->command->info('Arabic names updated for professors.');
    }
}

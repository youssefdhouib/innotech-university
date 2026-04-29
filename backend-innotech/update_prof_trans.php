<?php
use Illuminate\Support\Facades\DB;

$professors = [
    1 => [
        'email' => 'elias.vance@innotech.tn',
        'en' => ['first' => 'Elias', 'last' => 'Vance', 'grade' => 'Dr.', 'speciality' => 'Computer Science'],
        'fr' => ['first' => 'Elias', 'last' => 'Vance', 'grade' => 'Dr.', 'speciality' => 'Informatique'],
        'ar' => ['first' => 'إلياس', 'last' => 'فانس', 'grade' => 'د.', 'speciality' => 'علوم الحاسوب']
    ],
    2 => [
        'email' => 'sarah.jenkins@innotech.tn',
        'en' => ['first' => 'Sarah', 'last' => 'Jenkins', 'grade' => 'Dr.', 'speciality' => 'Mathematics'],
        'fr' => ['first' => 'Sarah', 'last' => 'Jenkins', 'grade' => 'Dr.', 'speciality' => 'Mathématiques'],
        'ar' => ['first' => 'سارة', 'last' => 'جينكينز', 'grade' => 'د.', 'speciality' => 'الرياضيات']
    ],
    3 => [
        'email' => 'robert.chen@innotech.tn',
        'en' => ['first' => 'Robert', 'last' => 'Chen', 'grade' => 'Dr.', 'speciality' => 'Engineering'],
        'fr' => ['first' => 'Robert', 'last' => 'Chen', 'grade' => 'Dr.', 'speciality' => 'Ingénierie'],
        'ar' => ['first' => 'روبرت', 'last' => 'تشن', 'grade' => 'د.', 'speciality' => 'الهندسة']
    ],
    4 => [
        'email' => 'emily.carter@innotech.tn',
        'en' => ['first' => 'Emily', 'last' => 'Carter', 'grade' => 'Dr.', 'speciality' => 'Mathematics'],
        'fr' => ['first' => 'Emily', 'last' => 'Carter', 'grade' => 'Dr.', 'speciality' => 'Mathématiques'],
        'ar' => ['first' => 'إميلي', 'last' => 'كارتر', 'grade' => 'د.', 'speciality' => 'الرياضيات']
    ],
    5 => [
        'email' => 'david.oconnor@innotech.tn',
        'en' => ['first' => 'David', 'last' => "O'Connor", 'grade' => 'Mr.', 'speciality' => 'Mathematics'],
        'fr' => ['first' => 'David', 'last' => "O'Connor", 'grade' => 'M.', 'speciality' => 'Mathématiques'],
        'ar' => ['first' => 'ديفيد', 'last' => 'أوكونور', 'grade' => 'السيد', 'speciality' => 'الرياضيات']
    ],
    6 => [
        'email' => 'michael.chang@innotech.tn',
        'en' => ['first' => 'Michael', 'last' => 'Chang', 'grade' => 'Pr.', 'speciality' => 'Mathematics'],
        'fr' => ['first' => 'Michael', 'last' => 'Chang', 'grade' => 'Pr.', 'speciality' => 'Mathématiques'],
        'ar' => ['first' => 'مايكل', 'last' => 'تشانغ', 'grade' => 'أ.د.', 'speciality' => 'الرياضيات']
    ],
];

foreach ($professors as $id => $data) {
    DB::table('professors')->where('id', $id)->update(['email' => $data['email']]);
    
    foreach (['en', 'fr', 'ar'] as $lang) {
        DB::table('professor_translations')->updateOrInsert(
            ['professor_id' => $id, 'codeLang' => $lang],
            [
                'first_name' => $data[$lang]['first'],
                'last_name' => $data[$lang]['last'],
                'grade' => $data[$lang]['grade'],
                'speciality' => $data[$lang]['speciality']
            ]
        );
    }
}
echo "Translations and emails updated successfully!\n";

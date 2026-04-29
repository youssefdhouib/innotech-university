<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $applications = [
            [
                'first_name' => 'zied',
                'last_name' => 'dammak',
                'first_name_ar' => 'زياد',
                'last_name_ar' => 'دمق',
                'email' => 'test@example.com',
                'cin' => '1885511122',
                'passport' => 'AB987654',
                'birth_date' => '2003-05-01',
                'country' => 'Tunisia',
                'gender' => 'male',
                'address' => 'Sfax, Tunisia',
                'phone' => '+21698765432',
                'previous_degree' => 'Baccalauréat Scientifique',
                'graduation_year' => 2022,
                'how_did_you_hear' => 'Facebook',
                'desired_degree_id' => 11,
                'status' => 'pending',
            ],
            [
                'first_name' => 'Salma',
                'last_name' => 'Ben Salah',
                'first_name_ar' => 'سلمى',
                'last_name_ar' => 'بن صالح',
                'email' => 'salma@example.com',
                'cin' => '87654321',
                'passport' => 'AB123456',
                'birth_date' => '2000-03-15',
                'country' => 'Tunisia',
                'gender' => 'female',
                'address' => 'Tunis',
                'phone' => '+21691234567',
                'previous_degree' => 'Licence en Informatique',
                'graduation_year' => 2021,
                'how_did_you_hear' => 'LinkedIn',
                'desired_degree_id' => 17, // Mastere
                'status' => 'preconfirmed',
            ],
        ];

        foreach ($applications as $app) {
            Application::create($app);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Département de Génie Logiciel et Développement',
                'description' => 'Spécialisé en développement logiciel, génie logiciel, et méthodologies agiles.',
            ],
            [
                'name' => 'Département de Data Science et Intelligence Artificielle',
                'description' => 'Spécialisé en analyse de données, machine learning et intelligence artificielle appliquée.',
            ],
            [
                'name' => 'Département de Cybersécurité et Réseaux',
                'description' => 'Focalisé sur la sécurité informatique, les réseaux et la cybersécurité avancée.',
            ],
            [
                'name' => 'Département des Systèmes Embarqués et IoT',
                'description' => 'Spécialisé en conception de systèmes embarqués et solutions IoT.',
            ],
            [
                'name' => 'Département de Transformation Digitale et Management',
                'description' => 'Formations en gestion de projet IT, transformation digitale et management des systèmes.',
            ],
        ];

        Department::insert($departments);
    }
}

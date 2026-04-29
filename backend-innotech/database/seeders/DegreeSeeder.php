<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Degree;

class DegreeSeeder extends Seeder
{
    public function run(): void
    {
        $degrees = [
            ['name' => 'Génie Logiciel et Intelligence Artificielle', 'level' => 'Licence'],
            ['name' => 'Big Data et Analyse de Données', 'level' => 'Licence'],
            ['name' => 'Systèmes Embarqués et Internet des Objets', 'level' => 'Licence'],
            ['name' => 'Mécatronique', 'level' => 'Licence'],
            ['name' => 'Ingénierie et Administration des Affaires', 'level' => 'Licence'],
            ['name' => 'Sciences des Données Industrielles (Industrial Data Science)', 'level' => 'Licence'],
            ['name' => 'Génie Logiciel et DevOps', 'level' => 'Mastere'],
            ['name' => 'Ingénierie Automobile et Test Logiciel', 'level' => 'Mastere'],
            ['name' => 'Data et Intelligence Artificielle', 'level' => 'Mastere'],
        ];

        foreach ($degrees as $degree) {
            Degree::create($degree);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ProgramSeeder extends Seeder
{
    public function run(): void
    {    DB::table('programs')->truncate(); //  This will clear old data
        $programs = [
            "Génie Logiciel et Intelligence Artificielle" => [
                "file" => "genie-logiciel.pdf",
                "intro" => "Formation complète en développement logiciel, architecture et gestion de projets.",
                "modules" => [
                    "Programmation avancée",
                    "Architecture logicielle",
                    "DevOps et Cloud Computing",
                    "Intelligence Artificielle"
                ]
            ],
            "Big Data et Analyse de Données" => [
                "file" => "big-data.pdf",
                "intro" => "Cette spécialisation forme des experts capables de collecter, traiter, analyser et interpréter de grands volumes de données pour accompagner la prise de décision.",
                "modules" => [
                    "Architecture Big Data et traitement de données massives",
                    "Langages et outils de la Data Science : Python, R, SQL",
                    "Modélisation statistique et algorithmes de Machine Learning",
                    "Sécurité, éthique et gouvernance des données"
                ]
            ],
            "Systèmes Embarqués et Internet des Objets" => [
                "file" => "iot.pdf",
                "intro" => "Spécialisation axée sur la conception de systèmes intelligents et connectés, combinant électronique, informatique embarquée et Internet des Objets.",
                "modules" => [
                    "Conception de systèmes embarqués temps réel",
                    "Programmation bas niveau (C/C++, assembleur) et microcontrôleurs",
                    "Communication machine à machine (M2M) et protocoles IoT (MQTT, CoAP…)",
                    "Intégration de capteurs, actionneurs et modules sans fil (Wi-Fi, Bluetooth, LoRa…)"
                ]
            ],
            "Mécatronique" => [
                "file" => "mecatronique.pdf",
                "intro" => "Spécialisation en mécatronique, intégrant mécanique, électronique et informatique pour concevoir des systèmes automatisés et intelligents.",
                "modules" => [
                    "Conception et modélisation de systèmes mécatroniques",
                    "Automatique et contrôle des systèmes",
                    "Électronique embarquée et capteurs",
                    "Robotique industrielle et programmation des automates"
                ]
            ],
            "Ingénierie et Administration des Affaires" => [
                "file" => "business-engineering.pdf",
                "intro" => "Spécialisation combinant les compétences en ingénierie et en gestion pour piloter des projets technologiques et stratégiques dans les entreprises.",
                "modules" => [
                    "Gestion de projet et management stratégique",
                    "Analyse financière et contrôle de gestion",
                    "Marketing, commerce et développement des affaires",
                    "Leadership, communication et gestion des ressources humaines"
                ]
            ],
            "Sciences des Données Industrielles (Industrial Data Science)" => [
                "file" => "industrial-data.pdf",
                "intro" => "Spécialisation dédiée à l’analyse et à l’exploitation des données issues des systèmes industriels pour optimiser la production et la maintenance.",
                "modules" => [
                    "Collecte et traitement des données industrielles en temps réel",
                    "Techniques avancées de machine learning appliquées à l’industrie",
                    "Maintenance prédictive et optimisation des processus",
                    "Big Data industriel et systèmes cyber-physiques"
                ]
            ],
            "Génie Logiciel et DevOps" => [
                "file" => "devops.pdf",
                "intro" => "Spécialisation en génie logiciel et pratiques DevOps pour la conception, le déploiement et la maintenance continue.",
                "modules" => [
                    "Conception et architecture logicielle",
                    "Développement full-stack",
                    "Conteneurisation et orchestration",
                    "Intégration continue et déploiement continu"
                ]
            ],
            "Ingénierie Automobile et Test Logiciel" => [
                "file" => "automobile.pdf",
                "intro" => "Spécialisation en ingénierie automobile et validation des systèmes embarqués par des tests logiciels rigoureux.",
                "modules" => [
                    "Architecture des systèmes automobiles",
                    "Systèmes embarqués et capteurs",
                    "Automatisation des tests logiciels",
                    "Diagnostic électronique et maintenance"
                ]
            ],
            "Data et Intelligence Artificielle" => [
                "file" => "data-ai.pdf",
                "intro" => "Spécialisation en Big Data et analyse de données pour la prise de décision et la valorisation des données.",
                "modules" => [
                    "Introduction au Big Data",
                    "Technologies Hadoop et Spark",
                    "Modélisation et entrepôts de données",
                    "Analyse statistique avancée"
                ]
            ]
        ];


        foreach ($programs as $degreeName => $data) {
            $degree = Degree::where('name', $degreeName)->first();

            if ($degree) {
                $filePath = 'curriculums/' . $data['file'];

                if (!Storage::disk('public')->exists($filePath)) {
                    // Optional: log a warning, but don't break the seeding
                    logger()->warning("Le fichier curriculum est manquant : $filePath");
                    continue; // Skip this program if the file isn't there
                }

                Program::updateOrCreate(
                    ['degree_id' => $degree->id],
                    [
                        'description' => [
                            'intro' => $data['intro'],
                            'modules' => $data['modules']
                        ],
                        'attached_file' => $filePath,
                    ]
                );
            }
        }
    }
}

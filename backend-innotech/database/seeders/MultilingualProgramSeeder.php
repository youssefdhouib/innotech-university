<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Program;
use App\Models\ProgramTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MultilingualProgramSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('program_translations')->delete();
        DB::table('programs')->delete();

        $programs = [
            "Génie Logiciel et Intelligence Artificielle" => [
                "file" => "genie-logiciel.pdf",
                "fr" => [
                    "intro" => "Formation complète en développement logiciel, architecture et gestion de projets.",
                    "modules" => [
                        "Programmation avancée",
                        "Architecture logicielle",
                        "DevOps et Cloud Computing",
                        "Intelligence Artificielle"
                    ]
                ],
                "en" => [
                    "intro" => "Comprehensive training in software development, architecture and project management.",
                    "modules" => [
                        "Advanced Programming",
                        "Software Architecture",
                        "DevOps and Cloud Computing",
                        "Artificial Intelligence"
                    ]
                ],
                "ar" => [
                    "intro" => "تكوين شامل في تطوير البرمجيات، وهندسة البرمجيات، وإدارة المشاريع.",
                    "modules" => [
                        "البرمجة المتقدمة",
                        "هندسة البرمجيات",
                        "DevOps والحوسبة السحابية",
                        "الذكاء الاصطناعي"
                    ]
                ]
            ],

            "Big Data et Analyse de Données" => [
                "file" => "big-data.pdf",
                "fr" => [
                    "intro" => "Cette spécialisation forme des experts capables de collecter, traiter, analyser et interpréter de grands volumes de données pour accompagner la prise de décision.",
                    "modules" => [
                        "Architecture Big Data et traitement de données massives",
                        "Langages et outils de la Data Science : Python, R, SQL",
                        "Modélisation statistique et algorithmes de Machine Learning",
                        "Sécurité, éthique et gouvernance des données"
                    ]
                ],
                "en" => [
                    "intro" => "This specialization trains experts to collect, process, analyze, and interpret large datasets to support decision-making.",
                    "modules" => [
                        "Big Data architecture and massive data processing",
                        "Languages and tools for Data Science: Python, R, SQL",
                        "Statistical modeling and Machine Learning algorithms",
                        "Security, ethics, and data governance"
                    ]
                ],
                "ar" => [
                    "intro" => "تكوين خبراء في جمع ومعالجة وتحليل البيانات الضخمة لدعم اتخاذ القرار.",
                    "modules" => [
                        "هندسة البيانات الضخمة ومعالجة البيانات الكبيرة",
                        "لغات وأدوات علوم البيانات: بايثون، R، SQL",
                        "النمذجة الإحصائية وخوارزميات تعلم الآلة",
                        "الأمن والأخلاقيات وحوكمة البيانات"
                    ]
                ]
            ],

            "Systèmes Embarqués et Internet des Objets" => [
                "file" => "iot.pdf",
                "fr" => [
                    "intro" => "Spécialisation axée sur la conception de systèmes intelligents et connectés, combinant électronique, informatique embarquée et Internet des Objets.",
                    "modules" => [
                        "Conception de systèmes embarqués temps réel",
                        "Programmation bas niveau (C/C++, assembleur) et microcontrôleurs",
                        "Communication machine à machine (M2M) et protocoles IoT (MQTT, CoAP…)",
                        "Intégration de capteurs, actionneurs et modules sans fil (Wi-Fi, Bluetooth, LoRa…)"
                    ]
                ],
                "en" => [
                    "intro" => "Specialization focused on designing smart and connected systems combining electronics, embedded computing, and IoT.",
                    "modules" => [
                        "Real-time embedded system design",
                        "Low-level programming (C/C++, assembler) and microcontrollers",
                        "Machine-to-machine communication and IoT protocols (MQTT, CoAP...)",
                        "Integration of sensors, actuators and wireless modules (Wi-Fi, Bluetooth, LoRa...)"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص في تصميم الأنظمة الذكية والمتصلة، يجمع بين الإلكترونيات والحوسبة المدمجة وإنترنت الأشياء.",
                    "modules" => [
                        "تصميم أنظمة مدمجة في الزمن الحقيقي",
                        "البرمجة منخفضة المستوى والمتحكمات الدقيقة",
                        "الاتصال بين الآلات وبروتوكولات إنترنت الأشياء",
                        "دمج المستشعرات والمحركات والوحدات اللاسلكية"
                    ]
                ]
            ],

            "Mécatronique" => [
                "file" => "mecatronique.pdf",
                "fr" => [
                    "intro" => "Spécialisation en mécatronique, intégrant mécanique, électronique et informatique pour concevoir des systèmes automatisés et intelligents.",
                    "modules" => [
                        "Conception et modélisation de systèmes mécatroniques",
                        "Automatique et contrôle des systèmes",
                        "Électronique embarquée et capteurs",
                        "Robotique industrielle et programmation des automates"
                    ]
                ],
                "en" => [
                    "intro" => "Specialization in mechatronics, integrating mechanics, electronics, and computing for automated systems.",
                    "modules" => [
                        "Design and modeling of mechatronic systems",
                        "Automation and system control",
                        "Embedded electronics and sensors",
                        "Industrial robotics and PLC programming"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص في الميكاترونيك يجمع بين الميكانيكا والإلكترونيات والمعلوماتية لتصميم أنظمة ذكية وآلية.",
                    "modules" => [
                        "تصميم ونمذجة الأنظمة الميكاترونيكية",
                        "الأتمتة والتحكم في الأنظمة",
                        "الإلكترونيات المدمجة والمستشعرات",
                        "الروبوتات الصناعية وبرمجة المتحكمات"
                    ]
                ]
            ],

            "Ingénierie et Administration des Affaires" => [
                "file" => "business-engineering.pdf",
                "fr" => [
                    "intro" => "Spécialisation combinant les compétences en ingénierie et en gestion pour piloter des projets technologiques et stratégiques dans les entreprises.",
                    "modules" => [
                        "Gestion de projet et management stratégique",
                        "Analyse financière et contrôle de gestion",
                        "Marketing, commerce et développement des affaires",
                        "Leadership, communication et gestion des ressources humaines"
                    ]
                ],
                "en" => [
                    "intro" => "Combines engineering and management skills to lead strategic tech projects.",
                    "modules" => [
                        "Project management and strategic planning",
                        "Financial analysis and management control",
                        "Marketing, business development",
                        "Leadership, communication and HR management"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص يجمع بين الهندسة والإدارة لقيادة مشاريع تكنولوجية واستراتيجية.",
                    "modules" => [
                        "إدارة المشاريع والتخطيط الاستراتيجي",
                        "التحليل المالي والمراقبة الإدارية",
                        "التسويق وتطوير الأعمال",
                        "القيادة والتواصل وإدارة الموارد البشرية"
                    ]
                ]
            ],

            "Sciences des Données Industrielles (Industrial Data Science)" => [
                "file" => "industrial-data.pdf",
                "fr" => [
                    "intro" => "Spécialisation dédiée à l’analyse et à l’exploitation des données issues des systèmes industriels pour optimiser la production et la maintenance.",
                    "modules" => [
                        "Collecte et traitement des données industrielles en temps réel",
                        "Techniques avancées de machine learning appliquées à l’industrie",
                        "Maintenance prédictive et optimisation des processus",
                        "Big Data industriel et systèmes cyber-physiques"
                    ]
                ],
                "en" => [
                    "intro" => "Specialization in analyzing and exploiting industrial data for production and maintenance optimization.",
                    "modules" => [
                        "Real-time industrial data processing",
                        "Advanced machine learning for industry",
                        "Predictive maintenance and process optimization",
                        "Industrial Big Data and cyber-physical systems"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص في تحليل واستغلال بيانات الأنظمة الصناعية لتحسين الإنتاج والصيانة.",
                    "modules" => [
                        "معالجة البيانات الصناعية في الوقت الحقيقي",
                        "تعلم الآلة المتقدم في الصناعة",
                        "الصيانة التنبؤية وتحسين العمليات",
                        "البيانات الضخمة الصناعية والأنظمة السيبرية الفيزيائية"
                    ]
                ]
            ],

            "Génie Logiciel et DevOps" => [
                "file" => "devops.pdf",
                "fr" => [
                    "intro" => "Spécialisation en génie logiciel et pratiques DevOps pour la conception, le déploiement et la maintenance continue.",
                    "modules" => [
                        "Conception et architecture logicielle",
                        "Développement full-stack",
                        "Conteneurisation et orchestration",
                        "Intégration continue et déploiement continu"
                    ]
                ],
                "en" => [
                    "intro" => "Software engineering and DevOps practices for design and continuous delivery.",
                    "modules" => [
                        "Software design and architecture",
                        "Full-stack development",
                        "Containerization and orchestration",
                        "CI/CD (continuous integration & deployment)"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص في هندسة البرمجيات وممارسات DevOps لتصميم ونشر البرمجيات بشكل مستمر.",
                    "modules" => [
                        "تصميم وهندسة البرمجيات",
                        "تطوير Full-stack",
                        "الحاويات والتنظيم",
                        "الدمج والتسليم المستمر"
                    ]
                ]
            ],

            "Ingénierie Automobile et Test Logiciel" => [
                "file" => "automobile.pdf",
                "fr" => [
                    "intro" => "Spécialisation en ingénierie automobile et validation des systèmes embarqués par des tests logiciels rigoureux.",
                    "modules" => [
                        "Architecture des systèmes automobiles",
                        "Systèmes embarqués et capteurs",
                        "Automatisation des tests logiciels",
                        "Diagnostic électronique et maintenance"
                    ]
                ],
                "en" => [
                    "intro" => "Automotive engineering and embedded systems testing specialization.",
                    "modules" => [
                        "Automotive systems architecture",
                        "Embedded systems and sensors",
                        "Software test automation",
                        "Electronic diagnostics and maintenance"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص في الهندسة الميكانيكية واختبار البرمجيات لأنظمة السيارات.",
                    "modules" => [
                        "هندسة أنظمة السيارات",
                        "الأنظمة المدمجة والمستشعرات",
                        "أتمتة اختبارات البرمجيات",
                        "تشخيص إلكتروني وصيانة"
                    ]
                ]
            ],

            "Data et Intelligence Artificielle" => [
                "file" => "data-ai.pdf",
                "fr" => [
                    "intro" => "Spécialisation en Big Data et analyse de données pour la prise de décision et la valorisation des données.",
                    "modules" => [
                        "Introduction au Big Data",
                        "Technologies Hadoop et Spark",
                        "Modélisation et entrepôts de données",
                        "Analyse statistique avancée"
                    ]
                ],
                "en" => [
                    "intro" => "Big Data and data analysis for decision-making and data valorization.",
                    "modules" => [
                        "Introduction to Big Data",
                        "Hadoop and Spark technologies",
                        "Data modeling and warehousing",
                        "Advanced statistical analysis"
                    ]
                ],
                "ar" => [
                    "intro" => "تخصص في البيانات الضخمة وتحليل البيانات لاتخاذ القرار وتحقيق القيمة من البيانات.",
                    "modules" => [
                        "مقدمة في البيانات الضخمة",
                        "تقنيات Hadoop و Spark",
                        "نمذجة البيانات ومستودعات البيانات",
                        "التحليل الإحصائي المتقدم"
                    ]
                ]
            ]
        ];

        foreach ($programs as $degreeName => $data) {
            $degree = \App\Models\Degree::whereHas('translations', function ($q) use ($degreeName) {
                $q->where('name', $degreeName)->where('codeLang', 'fr');
            })->first();

            if (!$degree) continue;

            $filePath = 'curriculums/' . $data['file'];

            if (!Storage::disk('public')->exists($filePath)) {
                logger()->warning("Fichier introuvable: $filePath");
                continue;
            }

            $program = Program::create([
                'degree_id' => $degree->id,
                'attached_file' => $filePath,
            ]);

            foreach (['fr', 'en', 'ar'] as $locale) {
                ProgramTranslation::create([
                    'program_id' => $program->id,
                    'codeLang' => $locale,
                    'description' => [
                        'intro' => $data[$locale]['intro'],
                        'modules' => $data[$locale]['modules']
                    ]
                ]);
            }
        }
    }
}

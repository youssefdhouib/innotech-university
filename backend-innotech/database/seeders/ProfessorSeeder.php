<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professor;
use Illuminate\Support\Facades\Storage;

class ProfessorSeeder extends Seeder
{
    public function run(): void
    {
        $professors = [
            // Département 1: Génie Logiciel et Développement
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
        ];

        // Create fake CV and image files automatically if missing
        foreach ($professors as $professor) {
            $cvPath = $professor['cv_attached_file'];
            if (!Storage::disk('public')->exists($cvPath)) {
                Storage::disk('public')->put($cvPath, "Fake CV content for {$professor['first_name']} {$professor['last_name']}");
            }

            $imagePath = $professor['photo_url'];
            if (!Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->put($imagePath, "Fake image content for {$professor['first_name']} {$professor['last_name']}");
            }
        }

        Professor::insert($professors);
    }
}

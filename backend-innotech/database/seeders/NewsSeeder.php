<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NewsSeeder extends Seeder
{
    public function run(): void
    {// Clear the table first
        DB::table('news')->truncate();
        $newsItems = [
            // Events
            [
                'title' => 'AI & Machine Learning Hackathon',
                'description' => 'Join us for a 48-hour challenge building innovative AI solutions.',
                'category' => 'event',
                'is_published' => true,
                'image_url' => 'news/images/ai-hackathon.jpg',
                'event_date' => '2024-10-12',
                'location' => 'Amphi A, InnoTech Campus',
            ],
            [
                'title' => 'IT & Tech Career Fair',
                'description' => 'Meet top tech companies and explore opportunities.',
                'category' => 'event',
                'is_published' => true,
                'image_url' => 'news/images/career-fair.jpg',
                'event_date' => '2024-11-05',
                'location' => 'Central Hall, InnoTech Campus',
            ],
            [
                'title' => 'Annual Sports Day',
                'description' => 'A day of competitions and team-building activities for students and faculty.',
                'category' => 'event',
                'is_published' => true,
                'image_url' => 'news/images/sports-day.jpg',
                'event_date' => '2024-12-01',
                'location' => 'Main Stadium, InnoTech Campus',
            ],

            // Announcements
            [
                'title' => 'Blockchain Seminar',
                'description' => 'Discover blockchain trends and use cases.',
                'category' => 'announcement',
                'is_published' => true,
                'image_url' => 'news/images/blockchain-seminar.jpg',
            ],
            [
                'title' => 'New Library Resources Available',
                'description' => 'Explore the new e-resources added to our university library.',
                'category' => 'announcement',
                'is_published' => true,
                'image_url' => 'news/images/library-resources.jpg',
            ],
            [
                'title' => 'New Cafeteria Hours',
                'description' => 'Updated cafeteria hours for the upcoming semester.',
                'category' => 'announcement',
                'is_published' => true,
                'image_url' => 'news/images/cafeteria-hours.jpg',
            ],

            // Notices
            [
                'title' => 'Academic Calendar Notice',
                'description' => 'Updated academic calendar for the next semester.',
                'category' => 'notice',
                'is_published' => true,
                'image_url' => 'news/images/academic-calendar.jpg',
            ],
            [
                'title' => 'Maintenance Notice',
                'description' => 'Campus network maintenance scheduled for this weekend.',
                'category' => 'notice',
                'is_published' => true,
                'image_url' => 'news/images/maintenance-notice.jpg',
            ],
            [
                'title' => 'Exam Schedule Posted',
                'description' => 'Check the student portal for your updated exam schedule.',
                'category' => 'notice',
                'is_published' => true,
                'image_url' => 'news/images/exam-schedule.jpg',
            ],
        ];


        foreach ($newsItems as $item) {
            // Create fake images if they don't exist
            if (!Storage::disk('public')->exists($item['image_url'])) {
                Storage::disk('public')->put($item['image_url'], "Fake image content for {$item['title']}");
            }

            News::create($item);
        }
    }
}

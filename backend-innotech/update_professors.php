<?php
use Illuminate\Support\Facades\DB;

$updates = [
    1 => ['first' => 'Elias', 'last' => 'Vance', 'img' => 'professors/images/new_prof_m.png', 'slug' => 'elias-vance'],
    2 => ['first' => 'Sarah', 'last' => 'Jenkins', 'img' => 'professors/images/new_prof_f.png', 'slug' => 'sarah-jenkins'],
    3 => ['first' => 'Robert', 'last' => 'Chen', 'img' => 'professors/images/new_prof_m.png', 'slug' => 'robert-chen'],
    4 => ['first' => 'Emily', 'last' => 'Carter', 'img' => 'professors/images/new_prof_f.png', 'slug' => 'emily-carter'],
    5 => ['first' => 'David', 'last' => "O'Connor", 'img' => 'professors/images/new_prof_m.png', 'slug' => 'david-oconnor'],
    6 => ['first' => 'Michael', 'last' => 'Chang', 'img' => 'professors/images/new_prof_m.png', 'slug' => 'michael-chang']
];
foreach($updates as $id => $data) {
    DB::table('professors')->where('id', $id)->update(['profile_slug' => $data['slug'], 'photo_url' => $data['img']]);
    DB::table('professor_translations')->where('professor_id', $id)->update(['first_name' => $data['first'], 'last_name' => $data['last']]);
}
echo "Database updated successfully!\n";

<?php
use Illuminate\Support\Facades\DB;

$photos = [
    1 => 'professors/images/prof1.jpg',
    2 => 'professors/images/prof2.jpg',
    3 => 'professors/images/prof3.jpg',
    4 => 'professors/images/prof4.jpg',
    5 => 'professors/images/prof5.jpg',
    6 => 'professors/images/prof6.jpg',
];

foreach ($photos as $id => $path) {
    DB::table('professors')->where('id', $id)->update(['photo_url' => $path]);
}
echo "Photos updated!\n";

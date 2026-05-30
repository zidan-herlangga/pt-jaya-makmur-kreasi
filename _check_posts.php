<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$posts = App\Models\Post::select('id','title','status','published_at')->get();
foreach ($posts as $p) {
    echo $p->id . ' | ' . $p->status . ' | ' . ($p->published_at ?? 'NULL') . ' | ' . substr($p->title, 0, 50) . PHP_EOL;
}
echo '---' . PHP_EOL;
echo 'Published count: ' . App\Models\Post::published()->count() . PHP_EOL;
echo 'Total count: ' . App\Models\Post::count() . PHP_EOL;

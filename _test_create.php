<?php
$user = App\Models\User::first();
if (!$user) { echo "No user found\n"; exit; }

echo "Creating post as: " . $user->email . "\n";

$post = App\Models\Post::create([
    'author_id' => $user->id,
    'title' => 'Test Post ' . time(),
    'content_body' => '<p>Test content body for testing purposes</p>',
    'status' => 'published',
    'category_id' => null,
]);

echo "Created post ID: " . $post->id . "\n";
echo "Status: " . $post->status . "\n";
echo "Published at: " . ($post->published_at ?? 'NULL') . "\n";

$fresh = $post->fresh();
echo "Fresh Published at: " . ($fresh->published_at ?? 'NULL') . "\n";

$found = App\Models\Post::published()->where('id', $post->id)->exists();
echo "Found in published scope: " . ($found ? 'YES' : 'NO') . "\n";

if (!$found) {
    $check = App\Models\Post::where('id', $post->id)->first();
    echo "DB Status: " . $check->status . "\n";
    echo "DB Published at: " . ($check->published_at ?? 'NULL') . "\n";
    echo "DB Deleted at: " . ($check->deleted_at ?? 'NULL') . "\n";
    echo "Published at <= now(): " . ($check->published_at && $check->published_at->lte(now()) ? 'YES' : 'NO') . "\n";
}

$post->forceDelete();
echo "Cleaned up.\n";

<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$request = Illuminate\Http\Request::create('/berita', 'GET');
try {
    $response = $kernel->handle($request);
    echo 'STATUS: ' . $response->getStatusCode() . PHP_EOL;
    $content = $response->getContent();
    echo 'LENGTH: ' . strlen($content) . PHP_EOL;
    if (str_contains($content, 'Belum Ada Artikel')) {
        echo 'RESULT: EMPTY (Belum Ada Artikel)' . PHP_EOL;
    } elseif (str_contains($content, 'Berita & Artikel')) {
        echo 'RESULT: PAGE RENDERED' . PHP_EOL;
        preg_match_all('/<article\b/', $content, $m);
        echo 'ARTICLE TAGS FOUND: ' . count($m[0]) . PHP_EOL;
        if (preg_match('/Belum Ada Artikel/', $content)) {
            echo 'ALSO SHOWS EMPTY STATE' . PHP_EOL;
        }
    } else {
        echo 'RESULT: UNKNOWN' . PHP_EOL;
        echo 'FIRST 500: ' . substr($content, 0, 500) . PHP_EOL;
    }
} catch(Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
    echo 'TRACE: ' . $e->getTraceAsString() . PHP_EOL;
}

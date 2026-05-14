<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingPoint;
use App\Models\Portfolio;
use App\Models\Post;

class SitemapController extends Controller
{
    public function index()
    {
        $points = AdvertisingPoint::published()->get();
        $posts = Post::published()->get();
        $portfolios = Portfolio::published()->get();

        return response()->view('public.sitemap', compact('points', 'posts', 'portfolios'))
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        return response()->view('public.robots')
            ->header('Content-Type', 'text/plain');
    }
}

<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingPoint;
use App\Models\Portfolio;
use App\Models\Post;
use App\Services\SeoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private SeoService $seoService) {}

    public function index(): View
    {
        $featuredPoints = AdvertisingPoint::featured(6)->get();
        $latestPosts = Post::published()->latest('published_at')->limit(3)->get();
        $latestPortfolios = Portfolio::published()->latest('published_at')->limit(3)->get();
        $cities = AdvertisingPoint::distinct()->pluck('city')->sort()->values();

        $seo = $this->seoService->forPage(
            'PT. Jaya Makmur - Solusi Reklame Profesional & Billboard Terbaik',
            'PT. Jaya Makmur - Jasa reklame profesional untuk branding bisnis Anda. Tersedia billboard, neon box, dan media luar ruang di berbagai kota besar Indonesia.',
            'reklame, billboard, jasa reklame, iklan luar ruang, neon box, PT Jaya Makmur'
        )->render();

        return view('public.home', compact('featuredPoints', 'latestPosts', 'latestPortfolios', 'cities', 'seo'));
    }
}

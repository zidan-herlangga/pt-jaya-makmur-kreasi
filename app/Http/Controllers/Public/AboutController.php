<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\AdvertisingPoint;
use App\Models\Post;
use App\Services\SeoService;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(private SeoService $seoService) {}

    public function index(): View
    {
        $portfolioCount = Portfolio::published()->count();
        $pointCount = AdvertisingPoint::count();
        $postCount = Post::published()->count();
        $cities = AdvertisingPoint::distinct()->pluck('city')->sort()->values();
        $latestPortfolios = Portfolio::published()->latest('published_at')->limit(3)->get();

        $seo = $this->seoService->forPage(
            'Tentang Kami - PT. Jaya Makmur | Solusi Reklame Profesional',
            'PT. Jaya Makmur adalah perusahaan jasa reklame dan billboard profesional. Berpengalaman dalam menyediakan media promosi luar ruang di berbagai kota besar Indonesia.',
            'tentang kami, PT Jaya Makmur, perusahaan reklame, jasa billboard, media luar ruang'
        )->render();

        return view('public.about', compact(
            'portfolioCount', 'pointCount', 'postCount', 'cities', 'latestPortfolios', 'seo'
        ));
    }
}

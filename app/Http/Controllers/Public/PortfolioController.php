<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __construct(private SeoService $seoService) {}

    public function index(Request $request): View
    {
        $query = Portfolio::published()->with('category');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $portfolios = $query->latest('published_at')->paginate(12);

        $categories = Category::byType('product')->active()->get();

        $seo = $this->seoService->forPage(
            'Portfolio',
            'Lihat portofolio proyek reklame dan billboard terbaik kami.',
            'portofolio reklame, billboard, proyek iklan'
        )->render();

        return view('public.portfolios', compact('portfolios', 'categories', 'seo'));
    }

    public function show(Portfolio $portfolio): View
    {
        $portfolio->incrementViewCount();
        $portfolio->load('category');
        $relatedPortfolios = Portfolio::published()
            ->where('id', '!=', $portfolio->id)
            ->where(function ($q) use ($portfolio) {
                $q->where('category_id', $portfolio->category_id);
            })
            ->limit(3)
            ->get();

        $seo = $this->seoService->forModel($portfolio)->render();

        return view('public.portfolio-show', compact('portfolio', 'relatedPortfolios', 'seo'));
    }
}

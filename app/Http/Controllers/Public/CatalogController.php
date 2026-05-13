<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdvertisingPoint;
use App\Models\Category;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function __construct(private SeoService $seoService) {}

    public function index(Request $request): View
    {
        $query = AdvertisingPoint::published()->with('category');

        // Advanced Filter
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('orientation')) {
            $query->where('orientation', $request->orientation);
        }
        if ($request->filled('light_type')) {
            $query->where('light_type', $request->light_type);
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('location_name', 'like', "%{$request->search}%");
            });
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'popular' => $query->orderBy('view_count', 'desc'),
            default => $query->latest('published_at'),
        };

        $points = $query->paginate(12)->withQueryString();
        $cities = AdvertisingPoint::distinct()->pluck('city')->sort()->values();
        $categories = Category::byType('product')->active()->get();

        $seo = $this->seoService->forPage(
            'Katalog Billboard & Reklame - PT. Jaya Makmur',
            'Jelajahi katalog billboard dan titik reklame terbaik dari PT. Jaya Makmur. Filter berdasarkan lokasi, harga, dan spesifikasi.',
            'katalog reklame, billboard dijual, sewa billboard, PT Jaya Makmur'
        )->render();

        return view('public.catalog', compact('points', 'cities', 'categories', 'seo'));
    }

    public function show(AdvertisingPoint $point): View
    {   
        
        

        $point->incrementViewCount();
        $point->load('category');
        $relatedPoints = AdvertisingPoint::published()
        ->where('id', '!=', $point->id)
        ->where('city', $point->city)
        ->limit(4)
        ->get();
        
        $seo = $this->seoService->forModel($point)->render();
        
        $whatsappLink = "https://wa.me/6281234567890?text=Halo%20PT. Jaya Kreasi Makmu%20Makmur%2C%20saya%20tertarik%20dengan%20iklan%20berjudul%20$point->title";

        return view('public.catalog-show', compact('point', 'relatedPoints', 'seo', 'whatsappLink'));
    }
}

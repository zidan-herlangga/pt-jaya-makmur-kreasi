<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(private SeoService $seoService) {}

    public function privacy(): View
    {
        $seo = $this->seoService->forPage(
            'Kebijakan Privasi - ' . setting('site_name', 'PT. Jaya Makmur'),
            'Kebijakan privasi ' . setting('site_name', 'PT. Jaya Makmur') . ' dalam mengelola data pribadi pengguna website.',
            'kebijakan privasi, privasi, data pribadi'
        )->render();

        return view('public.privacy', compact('seo'));
    }

    public function terms(): View
    {
        $seo = $this->seoService->forPage(
            'Syarat & Ketentuan - ' . setting('site_name', 'PT. Jaya Makmur'),
            'Syarat dan ketentuan penggunaan layanan ' . setting('site_name', 'PT. Jaya Makmur') . '.',
            'syarat ketentuan, terms and conditions'
        )->render();

        return view('public.terms', compact('seo'));
    }
}

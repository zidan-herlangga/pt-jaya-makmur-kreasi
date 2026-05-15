<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Portfolio;
use App\Services\ImageOptimizationService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function __construct(
        private ImageOptimizationService $imageService,
        private SeoService $seoService
    ) {
        $this->middleware(['auth', 'role:admin|super-admin|editor']);
    }

    public function index(Request $request): View
    {
        $query = Portfolio::with('category');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('client_name', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $portfolios = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::byType('product')->active()->get();
        $stats = [
            'total' => Portfolio::count(),
            'published' => Portfolio::published()->count(),
            'draft' => Portfolio::draft()->count(),
        ];

        return view('admin.portfolios.index', compact('portfolios', 'categories', 'stats'));
    }

    public function create(): View
    {
        $categories = Category::byType('product')->active()->get();
        $seo = $this->seoService->forPage('Tambah Portfolio Baru')->render();

        return view('admin.portfolios.create', compact('categories', 'seo'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220', 'unique:portfolios,slug'],
            'client_name' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);

        if (empty($data['published_at'])) {
            $data['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $images = $this->imageService->process(
                $request->file('thumbnail'),
                'portfolios',
                $data['slug'] ?? str($data['title'])->slug()
            );
            $data['thumbnail'] = $images['original'];
            $data['og_image'] = $images['og'];
        }

        if ($request->hasFile('images')) {
            $gallery = [];
            foreach ($request->file('images') as $image) {
                $result = $this->imageService->process($image, 'portfolios/gallery', uniqid());
                $gallery[] = $result['original'];
            }
            $data['images'] = $gallery;
        }

        $portfolio = Portfolio::create($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', "Portfolio '{$portfolio->title}' berhasil ditambahkan.");
    }

    public function show(Portfolio $portfolio): View
    {
        $portfolio->load('category');
        $seo = $this->seoService->forModel($portfolio)->render();

        return view('admin.portfolios.show', compact('portfolio', 'seo'));
    }

    public function edit(Portfolio $portfolio): View
    {
        $categories = Category::byType('product')->active()->get();
        $seo = $this->seoService->forPage('Edit: ' . $portfolio->title)->render();

        return view('admin.portfolios.edit', compact('portfolio', 'categories', 'seo'));
    }

    public function update(Request $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220', 'unique:portfolios,slug,' . $portfolio->id],
            'client_name' => ['nullable', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);

        if (empty($data['published_at'])) {
            $data['published_at'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($portfolio->thumbnail) {
                $this->imageService->delete('portfolios', $portfolio->slug);
            }

            $images = $this->imageService->process(
                $request->file('thumbnail'),
                'portfolios',
                $data['slug'] ?? $portfolio->slug
            );
            $data['thumbnail'] = $images['original'];
            $data['og_image'] = $images['og'];
        }

        if ($request->hasFile('images')) {
            $gallery = $portfolio->images ?? [];
            foreach ($request->file('images') as $image) {
                $result = $this->imageService->process($image, 'portfolios/gallery', uniqid());
                $gallery[] = $result['original'];
            }
            $data['images'] = $gallery;
        }

        $portfolio->update($data);

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', "Portfolio '{$portfolio->title}' berhasil diperbarui.");
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        if ($portfolio->thumbnail) {
            $this->imageService->delete('portfolios', $portfolio->slug);
        }

        $portfolio->delete();

        return redirect()
            ->route('admin.portfolios.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Services\ImageOptimizationService;
use App\Services\SeoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        private ImageOptimizationService $imageService,
        private SeoService $seoService
    ) {
        $this->middleware(['auth', 'role:admin|super-admin|editor']);
    }

    public function index(Request $request): View
    {
        $query = Post::with(['author', 'category']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content_body', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::byType('post')->active()->get();
        $stats = [
            'total' => Post::count(),
            'published' => Post::published()->count(),
            'draft' => Post::draft()->count(),
        ];

        return view('admin.posts.index', compact('posts', 'categories', 'stats'));
    }

    public function create(): View
    {
        $categories = Category::byType('post')->active()->get();
        $seo = $this->seoService->forPage('Tulis Berita Baru')->render();

        return view('admin.posts.create', compact('categories', 'seo'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220', 'unique:posts,slug'],
            'content_body' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:draft,published,archived'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['author_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $images = $this->imageService->process(
                $request->file('featured_image'),
                'posts',
                $data['slug'] ?? str($data['title'])->slug()
            );
            $data['featured_image'] = $images['original'];
            $data['og_image'] = $images['og'];
        }

        $post = Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', "Berita '{$post->title}' berhasil ditambahkan.");
    }

    public function show(Post $post): View
    {
        $post->load(['author', 'category']);
        $seo = $this->seoService->forModel($post)->render();

        return view('admin.posts.show', compact('post', 'seo'));
    }

    public function edit(Post $post): View
    {
        $categories = Category::byType('post')->active()->get();
        $seo = $this->seoService->forPage('Edit: ' . $post->title)->render();

        return view('admin.posts.edit', compact('post', 'categories', 'seo'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220', 'unique:posts,slug,' . $post->id],
            'content_body' => ['required', 'string'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:draft,published,archived'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                $this->imageService->delete('posts', $post->slug);
            }

            $images = $this->imageService->process(
                $request->file('featured_image'),
                'posts',
                $data['slug'] ?? $post->slug
            );
            $data['featured_image'] = $images['original'];
            $data['og_image'] = $images['og'];
        }

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', "Berita '{$post->title}' berhasil diperbarui.");
    }

    public function destroy(Post $post): RedirectResponse
    {
        if ($post->featured_image) {
            $this->imageService->delete('posts', $post->slug);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

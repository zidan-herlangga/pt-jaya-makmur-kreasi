<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Services\SeoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(private SeoService $seoService) {}

    public function index(Request $request): View
    {
        $query = Post::published()->with(['author', 'category']);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->latest('published_at')->paginate(9);

        $categories = Category::byType('post')->active()->get();

        $seo = $this->seoService->forPage(
            'Berita & Artikel',
            'Berita terbaru, tips, dan artikel seputar dunia reklame, billboard, dan pemasaran luar ruang.',
            'berita reklame, artikel billboard, tips pemasaran'
        )->render();

        return view('public.posts', compact('posts', 'categories', 'seo'));
    }

    public function show(Post $post): View
    {
        $post->incrementViewCount();
        $post->load(['author', 'category']);
        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                $q->where('category_id', $post->category_id)
                    ->orWhereRaw('MATCH(title, content_body, excerpt) AGAINST(? IN NATURAL LANGUAGE MODE)', [$post->title]);
            })
            ->limit(3)
            ->get();

        $seo = $this->seoService->forModel($post)->render();

        return view('public.post-show', compact('post', 'relatedPosts', 'seo'));
    }
}

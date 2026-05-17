<?php

use App\Http\Controllers\Admin\AdvertisingPointController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\NewsletterSubscriberController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\AiModelController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\CatalogController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InquiryController as PublicInquiryController;
use App\Http\Controllers\Public\NewsletterController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\PortfolioController;
use App\Http\Controllers\Public\PostController;
use App\Http\Controllers\Public\SitemapController;
use App\Models\User;
use App\Services\ActivityLoggerService;
use Illuminate\Support\Facades\Route;

// SEO Routes
Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/kebijakan-privasi', [PageController::class, 'privacy'])->name('privacy');
Route::get('/syarat-ketentuan', [PageController::class, 'terms'])->name('terms');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::prefix('katalog')->name('catalog.')->group(function () {
    Route::get('/', [CatalogController::class, 'index'])->name('index');
    Route::get('/{point:slug}', [CatalogController::class, 'show'])->name('show');
});

Route::prefix('berita')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/{post:slug}', [PostController::class, 'show'])->name('show');
});

Route::prefix('kontak')->name('inquiry.')->group(function () {
    Route::get('/', [PublicInquiryController::class, 'create'])->name('create');
    Route::post('/', [PublicInquiryController::class, 'store'])->name('store');
});

Route::prefix('portofolio')->name('portofolio.')->group(function () {
    Route::get('/', [PortfolioController::class, 'index'])->name('index');
    Route::get('/{portfolio:slug}', [PortfolioController::class, 'show'])->name('show');
});

Route::get('/produk/{point:slug}', [CatalogController::class, 'show'])->name('product.show');

// Chatbot API
Route::post('/api/chatbot/query', [\App\Http\Controllers\Api\ChatbotController::class, 'query'])
    ->name('api.chatbot.query')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Auth Routes (Login only)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            app(ActivityLoggerService::class)->login();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    });
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    app(ActivityLoggerService::class)->logout();
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::prefix('ai-models')->name('ai-models.')->group(function () {
        Route::get('/', [AiModelController::class, 'index'])->name('index');
        Route::get('/create', [AiModelController::class, 'create'])->name('create');
        Route::post('/', [AiModelController::class, 'store'])->name('store');
        Route::get('/{aiModel}/edit', [AiModelController::class, 'edit'])->name('edit');
        Route::put('/{aiModel}', [AiModelController::class, 'update'])->name('update');
        Route::delete('/{aiModel}', [AiModelController::class, 'destroy'])->name('destroy');
        Route::patch('/{aiModel}/toggle-active', [AiModelController::class, 'toggleActive'])->name('toggle-active');
    });

    Route::prefix('advertising-points')->name('advertising-points.')->group(function () {
        Route::get('/', [AdvertisingPointController::class, 'index'])->name('index');
        Route::get('/create', [AdvertisingPointController::class, 'create'])->name('create');
        Route::post('/', [AdvertisingPointController::class, 'store'])->name('store');
        Route::get('/{advertisingPoint}', [AdvertisingPointController::class, 'show'])->name('show');
        Route::get('/{advertisingPoint}/edit', [AdvertisingPointController::class, 'edit'])->name('edit');
        Route::put('/{advertisingPoint}', [AdvertisingPointController::class, 'update'])->name('update')->withTrashed();
        Route::delete('/{advertisingPoint}', [AdvertisingPointController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-destroy', [AdvertisingPointController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::patch('/{advertisingPoint}/toggle-status', [AdvertisingPointController::class, 'toggleStatus'])->name('toggle-status');
    });

    Route::resource('portfolios', AdminPortfolioController::class);
    Route::post('/portfolios/bulk-destroy', [AdminPortfolioController::class, 'bulkDestroy'])->name('portfolios.bulk-destroy');
    Route::resource('posts', AdminPostController::class);
    Route::post('/posts/bulk-destroy', [AdminPostController::class, 'bulkDestroy'])->name('posts.bulk-destroy');

    Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');
    Route::post('/inquiries/bulk-destroy', [InquiryController::class, 'bulkDestroy'])->name('inquiries.bulk-destroy');
    Route::patch('/inquiries/{inquiry}/process', [InquiryController::class, 'markProcessed'])->name('inquiries.process');
    
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::post('/categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
    Route::prefix('newsletter-subscribers')->name('newsletter-subscribers.')->group(function () {
        Route::get('/', [NewsletterSubscriberController::class, 'index'])->name('index');
        Route::delete('/{newsletterSubscriber}', [NewsletterSubscriberController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-destroy', [NewsletterSubscriberController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::get('/export', [NewsletterSubscriberController::class, 'export'])->name('export');
    });
});

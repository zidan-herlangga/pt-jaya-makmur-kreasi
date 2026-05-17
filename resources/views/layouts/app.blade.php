<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#16a34a" id="theme-color">
    <meta name="color-scheme" content="light dark">

    {{-- Dark Mode Init --}}
    <script>
        (function() {
            const isDark = localStorage.getItem('darkMode') === 'true';
            if (isDark) {
                document.documentElement.classList.add('dark');
                document.getElementById('theme-color')?.setAttribute('content', '#020617');
            }
        })();
    </script>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="{{ setting('site_name', 'PT. Jaya Makmur') }}">
    <meta name="application-name" content="{{ setting('site_name', 'PT. Jaya Makmur') }}">

    {{-- Dynamic SEO Meta Tags --}}
    <title>{{ $seo['meta_title'] ?? config('app.name') }} - Advertising</title>
    <meta name="description" content="{{ $seo['description'] ?? '' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? '' }}">
    <meta name="robots" content="{{ setting('meta_robots', 'index, follow') }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    {{-- Site Verification --}}
    @if (setting('google_verification'))
        <meta name="google-site-verification" content="{{ setting('google_verification') }}">
    @endif
    @if (setting('bing_verification'))
        <meta name="msvalidate.01" content="{{ setting('bing_verification') }}">
    @endif
    @if (setting('yandex_verification'))
        <meta name="yandex-verification" content="{{ setting('yandex_verification') }}">
    @endif
    @if (setting('baidu_verification'))
        <meta name="baidu-site-verification" content="{{ setting('baidu_verification') }}">
    @endif
    @if (setting('facebook_page_id'))
        <meta property="fb:pages" content="{{ setting('facebook_page_id') }}">
    @endif

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta property="og:title" content="{{ $seo['og_title'] ?? ($seo['meta_title'] ?? config('app.name')) }}">
    <meta property="og:description" content="{{ $seo['og_description'] ?? ($seo['description'] ?? '') }}">
    <meta property="og:image" content="{{ $seo['og_image'] ?? asset('images/og-default.jpg') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $seo['site_name'] ?? config('app.name') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}">
    <meta name="twitter:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta name="twitter:title" content="{{ $seo['site_name'] ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $seo['description'] ?? '' }}">
    <meta name="twitter:image" content="{{ $seo['og_image'] ?? asset('images/og-default.jpg') }}">
    <meta name="twitter:site" content="{{ setting('site_name', config('app.name')) }}">

    {{-- JSON-LD Structured Data --}}
    @if (!empty($seo['json_ld']))
        <script type="application/ld+json">
            {!! $seo['json_ld'] !!}
        </script>
    @endif

    {{-- Organization Schema (homepage only) --}}
    @if (request()->is('/'))
        <script type="application/ld+json">
            {!! json_encode(\App\Services\SeoService::generateOrganizationSchema(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif

    {{-- Local Business Schema (all pages) --}}
    <script type="application/ld+json">
        {!! json_encode(\App\Services\SeoService::generateLocalBusinessSchema(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    {{-- BreadcrumbList Schema --}}
    @if (!empty($seo['breadcrumbs']))
        <script type="application/ld+json">
            {!! json_encode($seo['breadcrumbs'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
        </script>
    @endif

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon"
        href="{{ setting('favicon') ? Storage::url(setting('favicon')) : asset('favicon.ico') }}">
    <link rel="apple-touch-icon"
        href="{{ setting('favicon') ? Storage::url(setting('favicon')) : asset('favicon.ico') }}">

    {{-- Preconnect & DNS Prefetch --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- CDN Tailwind CSS --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Google Analytics --}}
    @if (setting('google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ setting('google_analytics_id') }}');
        </script>
    @endif

    {{-- Google Tag Manager --}}
    @if (setting('google_tag_manager'))
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{{ setting('google_tag_manager') }}');
        </script>
    @endif

    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100"
    x-data="{
        mobileMenu: false,
        scrollY: 0,
        darkMode: localStorage.getItem('darkMode') === 'true',
    
        toggleDark() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
                document.getElementById('theme-color')?.setAttribute('content', '#020617');
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('theme-color')?.setAttribute('content', '#16a34a');
            }
        },
    
        init() {
            window.addEventListener('scroll', () => { this.scrollY = window.scrollY }, { passive: true });
            $el.querySelectorAll('[data-aos]').forEach(el => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const delay = el.dataset.aosDelay || 0;
                            setTimeout(() => el.classList.add('aos-animate'), delay);
                            observer.unobserve(el);
                        }
                    });
                }, { threshold: 0.1 });
                observer.observe(el);
            });
        },
        get scrolled() { return this.scrollY > 50 }
    }" :class="{ 'bg-white shadow-md dark:bg-slate-900': scrolled }">

    {{-- Google Tag Manager (noscript) --}}
    @if (setting('google_tag_manager'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ setting('google_tag_manager') }}"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    {{-- Navigation --}}
    @include('layouts.partials.navigation')

    {{-- Main Content --}}
    <main class="pt-16 lg:pt-20">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')

    {{-- Chatbot --}}
    @include('layouts.partials.chatbot')

    {{-- Scroll to top button --}}
    <button x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 500)" x-show="show"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-transition
        class="fixed bottom-6 right-6 z-50 p-3 bg-slate-900 hover:bg-green-500 text-white rounded-xl shadow-xl shadow-slate-900/20 hover:shadow-green-500/20 transition-all duration-300 dark:bg-slate-800 dark:hover:bg-green-600 dark:shadow-slate-900/40"
        aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </button>

    @stack('scripts')
</body>

</html>

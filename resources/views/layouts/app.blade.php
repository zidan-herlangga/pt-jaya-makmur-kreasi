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

<body class="font-sans antialiased bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100" x-data="{
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
}"
    :class="{ 'bg-white shadow-md dark:bg-slate-900': scrolled }">

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

    {{-- WhatsApp Floating Button --}}
    <a href="https://wa.me/{{ setting('whatsapp_number', '6281234567890') }}?text={{ urlencode(setting('whatsapp_text', 'Halo saya tertarik dengan layanan reklame')) }}"
        target="_blank" rel="noopener noreferrer" x-data="{ show: false }" x-init="window.addEventListener('scroll', () => show = window.scrollY > 300)" x-show="show"
        x-transition
        class="fixed bottom-6 right-20 z-50 p-3.5 bg-green-500 hover:bg-green-600 text-white rounded-xl shadow-xl shadow-green-500/20 hover:shadow-green-500/40 hover:scale-110 transition-all duration-300 group dark:shadow-green-500/10"
        aria-label="WhatsApp">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
        <span
            class="absolute -top-10 right-0 bg-slate-900 text-white text-xs font-medium px-3 py-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-lg">Chat
            via WhatsApp</span>
    </a>

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

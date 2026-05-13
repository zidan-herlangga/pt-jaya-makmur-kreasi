<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Dynamic SEO Meta Tags --}}
    <title>{{ $seo['site_name'] ?? config('app.name') }} - Advertising</title>
    <meta name="description" content="{{ $seo['description'] ?? '' }}">
    <meta name="keywords" content="{{ $seo['keywords'] ?? '' }}">
    <link rel="canonical" href="{{ $seo['canonical'] ?? url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta property="og:title" content="{{ $seo['site_name'] ?? config('app.name') }}">
    <meta property="og:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="og:image" content="{{ $seo['og_image'] ?? asset('images/og-default.jpg') }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="{{ $seo['site_name'] ?? config('app.name') }}">

    {{-- Twitter --}}
    <meta property="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}">
    <meta property="twitter:url" content="{{ $seo['canonical'] ?? url()->current() }}">
    <meta property="twitter:title" content="{{ $seo['site_name'] ?? config('app.name') }}">
    <meta property="twitter:description" content="{{ $seo['description'] ?? '' }}">
    <meta property="twitter:image" content="{{ $seo['og_image'] ?? asset('images/og-default.jpg') }}">

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

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon"
        href="{{ setting('favicon') ? Storage::url(setting('favicon')) : asset('favicon.ico') }}">
    <link rel="apple-touch-icon"
        href="{{ setting('favicon') ? Storage::url(setting('favicon')) : asset('favicon.ico') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- CDN Tailwind CSS --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-900" x-data="{
    mobileMenu: false,
    scrollY: 0,
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
    :class="{ 'bg-white shadow-md': scrolled }">


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
        class="fixed bottom-6 right-20 z-50 p-3.5 bg-green-500 hover:bg-green-600 text-white rounded-xl shadow-xl shadow-green-500/20 hover:shadow-green-500/40 hover:scale-110 transition-all duration-300 group"
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
        class="fixed bottom-6 right-6 z-50 p-3 bg-slate-900 hover:bg-green-500 text-white rounded-xl shadow-xl shadow-slate-900/20 hover:shadow-green-500/20 transition-all duration-300"
        aria-label="Scroll to top">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </button>

    @stack('scripts')
</body>

</html>

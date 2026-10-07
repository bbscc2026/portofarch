@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'overHero' => false,
])

@php
    $siteName = $site['site_name'] ?? 'Port of Arch';
    $pageTitle = $title ? "{$title} — {$siteName}" : "{$siteName} — ".($site['tagline'] ?? '');
    $metaDescription = $description ?? strip_tags((string) rich($site['hero_statement'] ?? ''));
    $nav = [
        ['Projects', route('projects.index'), 'projects.*'],
        ['Studio', route('studio'), 'studio'],
        ['Services', route('services'), 'services'],
        ['Contact', route('contact'), 'contact'],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta name="theme-color" content="#121212">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $image ?? asset('images/og.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">

    {{-- The JSON-LD context key is concatenated because Blade treats the literal word as its context directive. --}}
    @php
        $schema = json_encode([
            '@'.'context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => $siteName,
            'alternateName' => 'POA',
            'url' => url('/'),
            'image' => asset('images/og.jpg'),
            'email' => $site['email'] ?? null,
            'telephone' => $site['phone'] ?? null,
            'foundingDate' => $site['founded_year'] ?? null,
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Jeddah', 'addressCountry' => 'SA'],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);
    @endphp
    <script type="application/ld+json">{!! $schema !!}</script>

    {{-- Hide animated elements before first paint (no flash), but show everything if scripts fail to start. --}}
    <script>
        if (!matchMedia('(prefers-reduced-motion: reduce)').matches) {
            document.documentElement.classList.add('motion');
            setTimeout(function () {
                if (!window.__motionReady) document.documentElement.classList.remove('motion');
            }, 3500);
        }
    </script>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ menu: false }" x-effect="document.dispatchEvent(new CustomEvent('menu:toggle', { detail: menu }))"
      :class="{ 'overflow-hidden': menu }" @keydown.escape.window="menu = false">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[80] focus:bg-white focus:px-4 focus:py-2">Skip to content</a>

    {{-- Intro curtain, played once per visit. --}}
    <div data-intro class="pointer-events-none fixed inset-0 z-[75] hidden flex-col items-center justify-center gap-8 bg-ink [.motion_&]:flex" aria-hidden="true">
        <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-14 w-auto sm:h-16">
        <span class="h-px w-32 bg-white/15"><span data-intro-bar class="block h-px w-full origin-left scale-x-0 bg-white"></span></span>
    </div>

    {{-- Header: transparent and white over a hero image, solid white once scrolled (or on pages without a hero). --}}
    <header data-over-hero="{{ $overHero ? 'true' : 'false' }}" @class(['site-header fixed inset-x-0 top-0 z-40', 'is-solid' => ! $overHero])>
        <div class="wrap flex items-center justify-between py-4 lg:py-5">
            <a href="{{ route('home') }}" class="block py-1" aria-label="{{ $siteName }} — home">
                <img src="{{ asset('images/logo-white.png') }}" alt="{{ $siteName }}" width="480" height="169" class="site-logo h-8 w-auto lg:h-9">
            </a>

            <nav class="hidden items-center gap-10 md:flex" aria-label="Main">
                @foreach ($nav as $i => [$label, $href, $pattern])
                    <a href="{{ $href }}" @class(['label group flex items-baseline gap-2 py-2', 'opacity-100' => request()->routeIs($pattern)])>
                        <span class="text-[9px] opacity-50 tabular-nums">0{{ $i + 1 }}</span>
                        <span @class(['link-line pb-0.5', 'bg-[length:100%_1px]' => request()->routeIs($pattern)])>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <button type="button" class="label flex min-h-11 items-center gap-3 md:hidden" @click="menu = true" aria-label="Open menu" aria-haspopup="dialog">
                Menu
                <span class="flex w-6 flex-col gap-1.5" aria-hidden="true"><span class="h-px w-full bg-current"></span><span class="h-px w-full bg-current"></span></span>
            </button>
        </div>
    </header>

    {{-- Mobile menu --}}
    <div x-cloak x-show="menu" x-transition:enter="transition duration-500 ease-[cubic-bezier(.22,1,.36,1)]" x-transition:enter-start="opacity-0"
         x-transition:leave="transition duration-300 ease-in" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex flex-col overflow-y-auto bg-ink text-white md:hidden" role="dialog" aria-modal="true" aria-label="Menu">
        <div class="wrap flex items-center justify-between py-4">
            <img src="{{ asset('images/logo-white.png') }}" alt="" class="h-8 w-auto">
            <button type="button" class="label flex min-h-11 items-center gap-3" @click="menu = false">
                Close <span class="relative block h-4 w-4" aria-hidden="true"><span class="absolute top-1/2 h-px w-full rotate-45 bg-current"></span><span class="absolute top-1/2 h-px w-full -rotate-45 bg-current"></span></span>
            </button>
        </div>
        <nav class="wrap mt-6 flex flex-col border-t border-white/15" aria-label="Mobile">
            @foreach (array_merge([['Home', route('home'), 'home']], $nav) as $i => [$label, $href, $pattern])
                <a href="{{ $href }}" class="flex items-baseline justify-between border-b border-white/15 py-4"
                   x-show="menu" x-transition:enter="transition duration-700 ease-[cubic-bezier(.22,1,.36,1)]"
                   x-transition:enter-start="opacity-0 translate-y-6" style="transition-delay: {{ 120 + $i * 60 }}ms">
                    <span @class(['display text-[12vw] leading-none', 'text-white/45' => ! request()->routeIs($pattern)])>{{ $label }}</span>
                    <span class="text-xs text-white/40 tabular-nums">0{{ $i + 1 }}</span>
                </a>
            @endforeach
        </nav>
        <div class="wrap mt-auto grid gap-1 pt-10 pb-[max(2.5rem,env(safe-area-inset-bottom))] text-sm text-white/70">
            <a href="mailto:{{ $site['email'] ?? '' }}" class="py-1.5">{{ $site['email'] ?? '' }}</a>
            <a href="tel:{{ preg_replace('/\s+/', '', $site['phone'] ?? '') }}" class="py-1.5">{{ $site['phone'] ?? '' }}</a>
            <span class="py-1.5 text-white/40">{{ $site['address'] ?? '' }}</span>
        </div>
    </div>

    <main id="main">
        {{ $slot }}
    </main>

    @include('partials.footer')
</body>
</html>
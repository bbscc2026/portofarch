{{--
    Hero: full-screen media with large centred statements that hand over every few seconds.
    Each statement brings its own background (film, then project covers). On scroll the media frame
    shrinks while the statement fades (see heroSequence/heroScroll in motion.js).
--}}
@php
    $slideTotal = max(count($slides), 1);
@endphp

<section data-hero class="relative h-[100svh] min-h-[560px] overflow-hidden bg-white">
    <h1 class="sr-only">{{ strip_tags((string) rich($site['hero_statement'] ?? '')) }}</h1>

    <div data-hero-frame class="absolute inset-0 overflow-hidden bg-ink will-change-transform">
        @foreach ($slides as $i => $slide)
            <div data-hero-slide="{{ $i }}" class="absolute inset-0" style="opacity: {{ $i === 0 ? 1 : 0 }}">
                @if ($slide['type'] === 'video')
                    <video data-slide-video class="h-full w-full object-cover" muted loop playsinline
                           preload="{{ $i === 0 ? 'auto' : 'metadata' }}" @if ($i === 0) autoplay @endif
                           @if ($slide['poster']) poster="{{ $slide['poster'] }}" @endif aria-hidden="true">
                        @if ($slide['webm'])
                            <source src="{{ $slide['webm'] }}" type="video/webm">
                        @endif
                        <source src="{{ $slide['src'] }}" type="video/mp4">
                    </video>
                @else
                    <img src="{{ $slide['src'] }}" alt="" class="h-full w-full object-cover" @if ($i > 0) loading="lazy" @endif>
                @endif
            </div>
        @endforeach
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-black/25"></div>
    </div>

    {{-- Statements --}}
    <div data-hero-text class="pointer-events-none absolute inset-0 grid place-items-center px-5 text-center text-white" aria-hidden="true">
        @foreach ($statements as $i => [$first, $second])
            <p data-statement data-slide="{{ $i % $slideTotal }}" @class(['hero-statement display col-start-1 row-start-1 text-[clamp(2.2rem,8.2vw,9.5rem)] leading-[0.9] whitespace-nowrap', 'is-first' => $i === 0])>
                <span class="block overflow-hidden pb-[0.04em]"><span class="block">{{ $first }}</span></span>
                <span class="block overflow-hidden pb-[0.04em]"><span class="block">{{ $second }}</span></span>
            </p>
        @endforeach
        <p data-statement data-slide="0" class="hero-statement display col-start-1 row-start-1 text-[clamp(2.2rem,8.2vw,9.5rem)] leading-[0.9] whitespace-nowrap">
            <span class="block overflow-hidden pb-[0.04em]"><span class="block">We are</span></span>
            <span class="block overflow-hidden pb-[0.06em]"><span class="block"><img src="{{ asset('images/logo-white.png') }}" alt="" class="mx-auto mt-[0.12em] h-[0.78em] w-auto"></span></span>
        </p>
    </div>

    {{-- Bottom bar: current slide caption + scroll cue --}}
    <div data-hero-bar class="absolute inset-x-0 bottom-0 text-white">
        <div class="wrap flex items-end justify-between gap-4 pb-5 sm:pb-8">
            <div class="min-w-0">
                @foreach ($slides as $i => $slide)
                    <a href="{{ $slide['url'] }}" data-hero-caption="{{ $i }}" @class(['group flex min-h-11 min-w-0 items-center gap-4 text-sm', 'hidden' => $i > 0])>
                        <span class="label shrink-0 text-white/60 tabular-nums">{{ $slide['type'] === 'video' ? 'Film' : str_pad($i, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="h-px w-6 shrink-0 bg-white/50" aria-hidden="true"></span>
                        <span class="truncate">{{ $slide['title'] }}</span>
                        <span class="shrink-0 transition-transform duration-500 group-hover:translate-x-1" aria-hidden="true">→</span>
                    </a>
                @endforeach
            </div>
            <a href="#studio" class="label hidden shrink-0 items-center gap-3 sm:flex">
                Scroll
                <span class="relative block h-10 w-px overflow-hidden bg-white/30"><span class="hero-scroll-line absolute inset-x-0 top-0 h-1/2 bg-white"></span></span>
            </a>
        </div>
    </div>
</section>

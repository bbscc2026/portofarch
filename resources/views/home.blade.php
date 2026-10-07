<x-layouts.site over-hero>
    @include('partials.home-hero')

    {{-- (01) Studio: the statement lights up word by word as it scrolls into view. --}}
    <section id="studio" class="wrap scroll-mt-20 py-24 lg:py-36">
        <div class="grid gap-y-10 border-t border-ink pt-6 lg:grid-cols-12 lg:gap-x-10">
            <div class="flex flex-col justify-between gap-8 lg:col-span-3">
                <p class="label text-mute" data-reveal>(01) Studio</p>
                <div class="hidden lg:block" data-reveal>
                    <a href="{{ route('studio') }}" class="btn min-w-56">About the studio <span aria-hidden="true">→</span></a>
                </div>
            </div>
            <div class="lg:col-span-9">
                @foreach (preg_split('/\R{2,}/', $site['intro'] ?? '') as $i => $paragraph)
                    @if ($i === 0)
                        <p class="text-[clamp(1.9rem,4.2vw,4.4rem)] leading-[1.06] font-light tracking-[-0.03em]" data-words>{{ rich($paragraph) }}</p>
                    @else
                        <p class="mt-10 max-w-xl text-lg leading-relaxed text-graphite lg:mt-14 lg:ml-auto" data-reveal>{{ rich($paragraph) }}</p>
                    @endif
                @endforeach
                <div class="mt-8 lg:hidden" data-reveal>
                    <a href="{{ route('studio') }}" class="btn min-w-56">About the studio <span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>

        {{-- Key facts, set out like a drawing's title block --}}
        <dl class="mt-16 grid grid-cols-2 border-t border-l border-line lg:mt-24 lg:grid-cols-4">
            @foreach ([
                ['Established', $site['founded_year'] ?? '2018', false],
                ['Projects', $projectCount, true],
                ['Clients', $clients->count(), true],
                ['Studio', 'Jeddah', false],
            ] as [$label, $value, $isNumber])
                <div class="flex min-h-40 flex-col justify-between border-r border-b border-line p-5 lg:min-h-52 lg:p-7" data-reveal>
                    <dt class="label text-mute">{{ $label }}</dt>
                    <dd class="font-display text-[clamp(2.6rem,5vw,5rem)] leading-none font-medium tabular-nums" @if ($isNumber) data-count="{{ $value }}" @endif>{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    </section>

    {{-- (02) Selected works --}}
    @include('partials.home-showcase')

    {{-- (03) Index of works --}}
    <section class="wrap py-24 lg:py-36">
        <div class="mb-10 flex flex-wrap items-end justify-between gap-6 lg:mb-14">
            <div>
                <p class="label text-mute" data-reveal>(03) Index</p>
                <h2 class="display mt-5 text-[clamp(3rem,7vw,7rem)]" data-split>Index of <span class="accent">works</span></h2>
            </div>
            <a href="{{ route('projects.index') }}" class="btn min-w-56" data-reveal>All projects <span aria-hidden="true">→</span></a>
        </div>
        @include('partials.project-index', ['projects' => $projects])
    </section>

    @include('partials.approach', ['number' => '04'])

    {{-- (05) Services --}}
    <section class="wrap py-24 lg:py-36">
        <div class="grid gap-10 border-t border-ink pt-6 lg:grid-cols-12">
            <div class="lg:col-span-4" data-reveal>
                <h2 class="label text-mute">(05) Services</h2>
                <p class="mt-6 text-[clamp(2rem,3vw,3rem)] leading-[1.05] font-light tracking-tight" data-split>From the first sketch to the <span class="accent">last fitting.</span></p>
                <a href="{{ route('services') }}" class="btn mt-8 min-w-56">Our services <span aria-hidden="true">→</span></a>
            </div>
            <ol class="lg:col-span-8">
                @foreach ($services as $i => $service)
                    <li data-reveal>
                        <a href="{{ route('services') }}" class="group grid grid-cols-[2.5rem_1fr_auto] items-start gap-x-4 gap-y-2 border-b border-line py-7 transition-colors duration-300 first:border-t sm:grid-cols-[3.5rem_1fr_1.2fr_auto] sm:gap-x-6">
                            <span class="pt-1.5 text-sm text-mute tabular-nums">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <h3 class="text-2xl tracking-tight transition-transform duration-500 ease-arch group-hover:translate-x-2 lg:text-3xl">{{ $service->title }}</h3>
                            <p class="col-start-2 row-start-2 leading-relaxed text-graphite sm:col-start-3 sm:row-start-1">{{ $service->summary }}</p>
                            <span class="col-start-3 row-start-1 pt-1 text-lg transition-transform duration-500 ease-arch group-hover:translate-x-1 sm:col-start-4" aria-hidden="true">→</span>
                        </a>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @include('partials.clients', ['number' => '06'])
    @include('partials.press', ['number' => '07'])
</x-layouts.site>

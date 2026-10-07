<x-layouts.site title="Studio" description="Port of Arch is an architecture and interior design studio founded in Jeddah in 2018.">
    <section class="wrap pt-32 pb-14 sm:pt-40 lg:pt-48 lg:pb-20">
        <p class="label text-mute">Studio</p>
        <h1 class="mt-8 max-w-[20ch] text-[clamp(2.4rem,5.6vw,5.8rem)] leading-[1.02] font-light tracking-[-0.035em]" data-split="load">
            An architecture and interior studio from Jeddah, designing spaces with <span class="accent">purpose</span> since {{ $site['founded_year'] ?? '2018' }}.
        </h1>
    </section>

    @if ($image?->coverUrl())
        <figure class="wrap">
            <div class="relative aspect-[4/5] overflow-hidden bg-plaster sm:aspect-[16/9] md:aspect-[21/9]" data-clip>
                <div class="absolute inset-x-0 -top-[12%] h-[124%]" data-speed="0.2">
                    <img src="{{ $image->coverUrl() }}" alt="{{ $image->title }}" class="h-full w-full object-cover" loading="lazy">
                </div>
            </div>
            <figcaption class="mt-3 flex gap-4 text-sm text-mute"><span>Fig. 01</span><span>{{ $image->title }}, {{ $image->location }}</span></figcaption>
        </figure>
    @endif

    {{-- (01) Profile --}}
    <section class="wrap py-24 lg:py-36">
        <div class="grid gap-10 border-t border-ink pt-6 lg:grid-cols-12">
            <h2 class="label text-mute lg:col-span-3" data-reveal>(01) Profile</h2>
            <div class="space-y-8 lg:col-span-9">
                @foreach (preg_split('/\R{2,}/', $site['intro'] ?? '') as $i => $paragraph)
                    @if ($i === 0)
                        <p class="statement" data-words>{{ rich($paragraph) }}</p>
                    @else
                        <p class="max-w-2xl text-lg leading-relaxed text-graphite lg:ml-auto" data-reveal>{{ rich($paragraph) }}</p>
                    @endif
                @endforeach
                <p class="max-w-2xl text-lg leading-relaxed text-graphite lg:ml-auto" data-reveal>
                    Our portfolio spans cultural and educational spaces, retail and beauty, hospitality, workplaces and private homes. Whatever the scale, the aim is the same: architecture that is useful, enduring and quietly memorable.
                </p>
            </div>
        </div>

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

    {{-- (02) Vision --}}
    <section class="wrap pb-24 lg:pb-36">
        <div class="grid gap-10 border-t border-ink pt-6 lg:grid-cols-12">
            <h2 class="label text-mute lg:col-span-3" data-reveal>(02) Vision</h2>
            <div class="grid border-t border-line sm:grid-cols-3 sm:border-t-0 lg:col-span-9">
                @foreach ([
                    ['Inspire', 'Spaces should lift the people who use them — through light, proportion and material.'],
                    ['Function', 'Beauty has to work. Plans, circulation and details are resolved for real, daily use.'],
                    ['Endure', 'We design for the long term: durable materials, climatic sense and timeless forms.'],
                ] as $i => [$title, $text])
                    <div @class(['border-b border-line py-8 sm:border-b-0 sm:py-0', 'sm:border-l sm:pl-8' => $i > 0, 'sm:pr-8' => $i < 2]) data-reveal>
                        <span class="text-sm text-mute tabular-nums">0{{ $i + 1 }}</span>
                        <h3 class="display mt-8 text-5xl lg:text-6xl">{{ $title }}</h3>
                        <p class="mt-4 leading-relaxed text-graphite">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.approach', ['number' => '03'])

    <div class="pt-24 lg:pt-36">
        @include('partials.clients', ['number' => '04'])
        @include('partials.press', ['number' => '05'])
    </div>
</x-layouts.site>

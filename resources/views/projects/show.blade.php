<x-layouts.site :title="$project->title" :description="$project->meta_description ?? $project->excerpt" :image="$project->coverUrl()" over-hero>
    {{-- Full-bleed hero with condensed title --}}
    <section class="relative h-[100svh] min-h-[600px] overflow-hidden bg-ink text-white">
        @if ($project->coverUrl())
            <div class="absolute inset-x-0 -top-[15%] h-[130%]" data-speed="0.25">
                <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" class="h-full w-full object-cover" fetchpriority="high">
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-black/30"></div>
        <div class="wrap relative flex h-full flex-col justify-end pb-8 lg:pb-14">
            <p class="label text-white/70">{{ $project->category }} — {{ $project->location }}</p>
            <h1 class="display mt-5 max-w-[14ch] text-[clamp(3.4rem,11vw,12rem)] break-words" data-split="load" data-delay="0.15">{{ $project->title }}</h1>
        </div>
    </section>

    {{-- Project data, set out like a drawing's title block --}}
    @php
        $facts = array_filter([
            'Location' => $project->location,
            'Status' => $project->status,
            'Year' => $project->year,
            'Client' => $project->client,
            'Programme' => $project->category,
            'Scope' => $project->scope,
            'Area' => $project->area,
        ]);
    @endphp
    <section class="wrap grid gap-12 py-16 lg:grid-cols-12 lg:py-24">
        <dl class="grid grid-cols-2 self-start border-t border-ink lg:col-span-4" data-reveal>
            @foreach ($facts as $label => $value)
                <div class="border-b border-line py-3 pr-4">
                    <dt class="label text-mute">{{ $label }}</dt>
                    <dd class="mt-1.5 leading-snug">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
        @if ($project->excerpt)
            <p class="statement lg:col-span-7 lg:col-start-6" data-split>{{ rich($project->excerpt) }}</p>
        @endif
    </section>

    {{-- Story, interleaved with the gallery --}}
    @php
        $paragraphs = $project->paragraphs();
        $images = $project->images->values();
        $first = $images->take(3);
        $rest = $images->slice(3)->values();
    @endphp

    <section class="wrap grid gap-8 pb-16 lg:grid-cols-12 lg:pb-24">
        <p class="label text-mute lg:col-span-3 lg:col-start-3">Description</p>
        <div class="space-y-6 text-lg leading-relaxed text-graphite lg:col-span-6">
            @foreach (array_slice($paragraphs, 0, 2) as $paragraph)
                <p data-reveal>{{ rich($paragraph) }}</p>
            @endforeach
        </div>
    </section>

    @include('projects.partials.gallery', ['images' => $first, 'figureOffset' => 0])

    @if (count($paragraphs) > 2)
        <section class="wrap grid gap-8 py-16 lg:grid-cols-12 lg:py-28">
            <div class="space-y-6 text-lg leading-relaxed text-graphite lg:col-span-6 lg:col-start-6">
                @foreach (array_slice($paragraphs, 2) as $paragraph)
                    <p data-reveal>{{ rich($paragraph) }}</p>
                @endforeach
            </div>
        </section>
    @endif

    @include('projects.partials.gallery', ['images' => $rest, 'figureOffset' => $first->count()])

    {{-- Credits & press --}}
    @if ($project->credits || $project->pressArticles->isNotEmpty())
        <section class="wrap grid gap-12 py-16 lg:grid-cols-12 lg:py-24">
            @if ($project->credits)
                <div class="lg:col-span-5" data-reveal>
                    <h2 class="label text-mute">Credits</h2>
                    <ul class="mt-5 border-t border-ink">
                        @foreach (explode('·', $project->credits) as $credit)
                            <li class="border-b border-line py-3 text-graphite">{{ trim($credit) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($project->pressArticles->isNotEmpty())
                <div class="lg:col-span-6 lg:col-start-7" data-reveal>
                    <h2 class="label text-mute">Published in</h2>
                    <ul class="mt-5 border-t border-ink">
                        @foreach ($project->pressArticles as $article)
                            <li>
                                <a href="{{ $article->url }}" target="_blank" rel="noopener" class="group flex min-h-14 items-baseline justify-between gap-4 border-b border-line py-3">
                                    <span><span class="label mr-4 text-mute">{{ $article->publication }}</span><span class="link-line group-hover:bg-[length:100%_1px]">{{ $article->title }}</span></span>
                                    <span class="shrink-0" aria-hidden="true">↗</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    @endif

    {{-- Next project --}}
    @if ($next && $next->isNot($project))
        <a href="{{ route('projects.show', $next) }}" class="group relative block h-[70vh] min-h-[420px] overflow-hidden bg-ink text-white">
            @if ($next->coverUrl())
                <img src="{{ $next->coverUrl() }}" alt="{{ $next->title }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover opacity-60 transition duration-[1400ms] ease-arch group-hover:scale-[1.03] group-hover:opacity-75">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="wrap relative flex h-full flex-col justify-end pb-10 lg:pb-14">
                <p class="label text-white/70">Next project →</p>
                <p class="display mt-4 text-[clamp(3rem,8vw,8rem)]">{{ $next->title }}</p>
            </div>
        </a>
    @endif
</x-layouts.site>

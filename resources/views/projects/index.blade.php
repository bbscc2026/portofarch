<x-layouts.site title="Projects" description="Selected architecture and interior design projects by Port of Arch — education, retail, hospitality and commercial spaces across Saudi Arabia.">
    <div x-data="{ view: 'grid' }">
        <section class="wrap pt-32 sm:pt-40 lg:pt-48">
            @php
                $filter = 'label inline-flex min-h-11 shrink-0 items-center px-1';
                $toggle = 'label min-h-11';
                $toggleState = fn (string $view) => "view === '{$view}' ? 'text-ink underline underline-offset-[6px]' : 'text-mute hover:text-ink'";
            @endphp

            <div class="flex items-end justify-between gap-6">
                <h1 class="display text-[clamp(4.2rem,15vw,15rem)]" data-split="load">Projects</h1>
                <p class="mb-3 hidden text-sm text-mute tabular-nums sm:block">({{ str_pad($projects->count(), 2, '0', STR_PAD_LEFT) }})</p>
            </div>

            {{-- Phones: count + view switch on their own row under the title --}}
            <div class="mt-3 flex items-center justify-between sm:hidden">
                <p class="text-sm text-mute tabular-nums">{{ str_pad($projects->count(), 2, '0', STR_PAD_LEFT) }} {{ Str::plural('project', $projects->count()) }}</p>
                <div class="flex gap-5" role="group" aria-label="View">
                    <button type="button" class="{{ $toggle }}" :class="{{ $toggleState('grid') }}" @click="view = 'grid'" :aria-pressed="view === 'grid'">Grid</button>
                    <button type="button" class="{{ $toggle }}" :class="{{ $toggleState('index') }}" @click="view = 'index'" :aria-pressed="view === 'index'">Index</button>
                </div>
            </div>

            {{-- Filter + view switch. On phones the filters sit on one row that scrolls sideways. --}}
            <div class="relative mt-4 flex items-center justify-between gap-x-8 border-y border-line sm:mt-10 sm:py-3">
                <nav class="-mx-5 flex gap-x-6 overflow-x-auto px-5 [scrollbar-width:none] sm:mx-0 sm:flex-wrap sm:gap-y-1 sm:overflow-visible sm:px-0 [&::-webkit-scrollbar]:hidden" aria-label="Filter by category">
                    <a href="{{ route('projects.index') }}" @class([$filter, 'text-ink underline underline-offset-[6px]' => ! $activeCategory, 'text-mute hover:text-ink' => $activeCategory])>All</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('projects.index', ['category' => $category]) }}" @class([$filter, 'text-ink underline underline-offset-[6px]' => $activeCategory === $category, 'text-mute hover:text-ink' => $activeCategory !== $category])>{{ $category }}</a>
                    @endforeach
                    <span class="w-1 shrink-0 sm:hidden" aria-hidden="true"></span>
                </nav>
                {{-- Fade hinting that the filter row scrolls (phones only) --}}
                <span class="pointer-events-none absolute inset-y-0 -right-5 w-12 bg-gradient-to-l from-white to-transparent sm:hidden" aria-hidden="true"></span>
                <div class="hidden shrink-0 gap-6 sm:flex" role="group" aria-label="View">
                    <button type="button" class="{{ $toggle }}" :class="{{ $toggleState('grid') }}" @click="view = 'grid'" :aria-pressed="view === 'grid'">Grid</button>
                    <button type="button" class="{{ $toggle }}" :class="{{ $toggleState('index') }}" @click="view = 'index'" :aria-pressed="view === 'index'">Index</button>
                </div>
            </div>
        </section>

        <section class="wrap pt-12 pb-24 lg:pt-16 lg:pb-36">
            @if ($projects->isEmpty())
                <p class="text-graphite">No projects in this category yet.</p>
            @else
                <div x-show="view === 'grid'" class="grid gap-x-8 gap-y-16 md:grid-cols-2 lg:gap-x-12 lg:gap-y-24">
                    @foreach ($projects as $i => $project)
                        <div @class(['md:mt-32' => $i % 2 === 1])>
                            @include('partials.project-card', [
                                'project' => $project,
                                'ratio' => $i % 4 === 0 || $i % 4 === 3 ? 'aspect-[4/5]' : 'aspect-[4/5] md:aspect-[4/3]',
                                'index' => $i,
                            ])
                        </div>
                    @endforeach
                </div>
                <div x-show="view === 'index'" x-cloak>
                    @include('partials.project-index', ['projects' => $projects])
                </div>
            @endif
        </section>
    </div>
</x-layouts.site>

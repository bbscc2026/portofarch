{{-- Index of works: a schedule-style table of every published project. The row's image previews on hover (desktop). --}}
<div class="border-t border-ink" x-data="{ preview: null }">
    <div class="label hidden grid-cols-12 gap-6 border-b border-line py-3 text-mute md:grid">
        <span class="col-span-1">No.</span>
        <span class="col-span-4">Project</span>
        <span class="col-span-3">Location</span>
        <span class="col-span-2">Programme</span>
        <span class="col-span-2 text-right">Status</span>
    </div>
    <ul>
        @foreach ($projects as $i => $project)
            <li class="relative" data-reveal>
                <a href="{{ route('projects.show', $project) }}"
                   class="group grid grid-cols-[2.5rem_1fr_auto] items-baseline gap-x-4 gap-y-1 border-b border-line py-5 transition-colors duration-300 hover:bg-plaster md:grid-cols-12 md:gap-6 md:px-0"
                   @mouseenter="preview = {{ $i }}" @mouseleave="preview = null">
                    <span class="text-sm text-mute tabular-nums md:col-span-1">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="text-xl tracking-tight transition-transform duration-500 ease-arch group-hover:translate-x-2 md:col-span-4 md:text-2xl">{{ $project->title }}</span>
                    <span class="col-start-2 text-sm text-graphite md:col-span-3 md:col-start-auto md:row-start-auto md:text-base">{{ $project->location }}</span>
                    <span class="hidden text-graphite md:col-span-2 md:block">{{ $project->category }}</span>
                    <span class="col-start-3 row-start-1 text-right text-sm text-mute md:col-span-2 md:col-start-auto md:row-start-auto md:text-base">{{ $project->year ?? $project->status }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    {{-- Floating preview image (pointer devices only) --}}
    <div class="pointer-events-none fixed top-1/2 right-[8vw] z-30 hidden aspect-[4/5] w-[22vw] max-w-sm -translate-y-1/2 overflow-hidden bg-plaster [@media(hover:hover)]:lg:block"
         x-show="preview !== null" x-transition.opacity.duration.300ms x-cloak aria-hidden="true">
        @foreach ($projects as $i => $project)
            @if ($project->coverUrl())
                <img src="{{ $project->coverUrl() }}" alt="" loading="lazy" class="absolute inset-0 h-full w-full object-cover" x-show="preview === {{ $i }}">
            @endif
        @endforeach
    </div>
</div>

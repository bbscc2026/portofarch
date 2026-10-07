@php
    $ratio ??= 'aspect-[4/3]';
    $index ??= null;
@endphp

<a href="{{ route('projects.show', $project) }}" class="group block">
    <div class="img-zoom relative overflow-hidden bg-plaster {{ $ratio }}" data-clip>
        @if ($project->coverUrl())
            <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover">
        @endif
    </div>
    <div class="mt-4 grid grid-cols-[auto_1fr_auto] items-baseline gap-x-4 border-t border-line pt-3">
        <span class="text-sm text-mute tabular-nums">{{ $index !== null ? str_pad($index + 1, 2, '0', STR_PAD_LEFT) : '' }}</span>
        <h3 class="text-xl tracking-tight lg:text-2xl">
            <span class="link-line group-hover:bg-[length:100%_1px]">{{ $project->title }}</span>
        </h3>
        <span class="text-sm text-mute">{{ $project->year ?? $project->status }}</span>
        <p class="col-start-2 mt-1 text-sm text-mute">{{ $project->category }} · {{ $project->location }}</p>
    </div>
</a>

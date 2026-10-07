@php
    $principles = [
        ['Context first', 'Every project starts with its place — the site, the climate, the street and the culture around it. We let those conditions shape the design rather than imposing a style.'],
        ['Detail & precision', 'From concept to construction we care about proportion, material integrity and how things are made. Good details are what people feel every day.'],
        ['Responsible by design', 'Daylight, shade, natural ventilation and durable materials come before mechanical fixes — spaces that perform well and age gracefully.'],
    ];
@endphp

<section class="bg-ink text-white">
    <div class="wrap py-24 lg:py-36">
        <div class="grid gap-10 border-t border-white/30 pt-6 lg:grid-cols-12">
            <h2 class="label text-white/50 lg:col-span-3" data-reveal>({{ $number ?? '03' }}) Approach</h2>
            <p class="statement lg:col-span-9" data-split>
                We listen closely, study the place, and design spaces that are <span class="accent">beautifully made</span> and connected to the people who use them.
            </p>
        </div>
        <div class="mt-16 grid border-t border-white/15 md:grid-cols-3 lg:mt-24">
            @foreach ($principles as $i => [$title, $text])
                <div @class(['py-8 md:px-8 md:py-10', 'md:border-l md:border-white/15' => $i > 0, 'md:pl-0' => $i === 0, 'border-t border-white/15 md:border-t-0' => $i > 0]) data-reveal>
                    <span class="text-sm text-white/45 tabular-nums">0{{ $i + 1 }}</span>
                    <h3 class="mt-10 text-2xl tracking-tight lg:mt-16">{{ $title }}</h3>
                    <p class="mt-4 max-w-sm leading-relaxed text-white/60">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

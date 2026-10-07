<x-layouts.site title="Services" description="Interior architecture, architecture, 3D visualisation and project delivery from Port of Arch, Jeddah.">
    <section class="wrap pt-32 pb-14 sm:pt-40 lg:pt-48 lg:pb-20">
        <h1 class="display text-[clamp(4.2rem,15vw,15rem)]" data-split="load">Services</h1>
        <p class="statement mt-10 max-w-[30ch]" data-split="load" data-delay="0.3">
            From the first conversation to the final fitting — <span class="accent">one studio,</span> one point of contact.
        </p>
    </section>

    <section class="wrap pb-24 lg:pb-36">
        <ol class="border-t border-ink">
            @foreach ($services as $i => $service)
                <li class="grid gap-5 border-b border-line py-10 lg:grid-cols-12 lg:gap-8 lg:py-14" data-reveal>
                    <span class="text-sm text-mute tabular-nums lg:col-span-1">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h2 class="text-3xl tracking-tight lg:col-span-4 lg:text-4xl">{{ $service->title }}</h2>
                    <div class="space-y-4 lg:col-span-6 lg:col-start-7">
                        <p class="text-lg leading-relaxed">{{ $service->summary }}</p>
                        @if ($service->body)
                            <p class="leading-relaxed text-graphite">{{ $service->body }}</p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </section>

    {{-- Process --}}
    <section class="bg-ink text-white">
        <div class="wrap py-24 lg:py-36">
            <div class="grid gap-10 border-t border-white/30 pt-6 lg:grid-cols-12">
                <p class="label text-white/50 lg:col-span-3">Process</p>
                <h2 class="display text-[clamp(3rem,8vw,8rem)] lg:col-span-9" data-split>How we <span class="accent">work</span></h2>
            </div>
            <div class="mt-16 grid border-t border-white/15 sm:grid-cols-2 lg:mt-24 lg:grid-cols-4">
                @foreach ([
                    ['Listen', 'A first meeting to understand your goals, site, timeline and budget.'],
                    ['Concept', 'Ideas, references and early layouts that set a clear direction for the project.'],
                    ['Develop', 'Detailed design, materials and 3D visualisation, refined together with you.'],
                    ['Deliver', 'Drawings, specifications and site coordination through to handover.'],
                ] as $i => [$title, $text])
                    <div @class(['border-b border-white/15 py-8 sm:pr-8 lg:border-b-0 lg:py-10', 'lg:border-l lg:pl-8' => $i > 0, 'sm:border-l sm:pl-8 lg:pl-8' => $i % 2 === 1]) data-reveal>
                        <span class="text-sm text-white/45 tabular-nums">Stage 0{{ $i + 1 }}</span>
                        <h3 class="display mt-10 text-4xl lg:text-5xl">{{ $title }}</h3>
                        <p class="mt-3 leading-relaxed text-white/60">{{ $text }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    @if ($faqs->isNotEmpty())
        <section class="wrap py-24 lg:py-36">
            <div class="grid gap-10 border-t border-ink pt-6 lg:grid-cols-12">
                <div class="lg:col-span-3" data-reveal>
                    <h2 class="label text-mute">Questions</h2>
                    <a href="{{ route('contact') }}" class="btn mt-8 min-w-56">Ask us directly <span aria-hidden="true">→</span></a>
                </div>
                <div class="lg:col-span-9">
                    @foreach ($faqs as $faq)
                        <details class="group border-b border-line first:border-t-0" data-reveal>
                            <summary class="flex min-h-16 cursor-pointer list-none items-center justify-between gap-6 py-6 text-lg tracking-tight sm:text-xl [&::-webkit-details-marker]:hidden">
                                {{ $faq->question }}
                                <span class="relative block h-4 w-4 shrink-0" aria-hidden="true">
                                    <span class="absolute top-1/2 left-0 h-px w-full bg-current"></span>
                                    <span class="absolute top-0 left-1/2 h-full w-px bg-current transition-transform duration-300 group-open:scale-y-0"></span>
                                </span>
                            </summary>
                            <p class="max-w-2xl pb-8 leading-relaxed text-graphite">{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.site>

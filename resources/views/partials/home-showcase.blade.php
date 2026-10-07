{{--
    Project showcase: a sticky lead-in sentence, then full-screen project panels that stack over
    each other, each one finishing the sentence with the project's showcase line.
--}}
@if ($showcase->isNotEmpty())
    <section data-showcase class="relative">
        <div class="sticky top-0 grid h-[100svh] place-items-center bg-white px-5 text-center">
            <div>
                <p class="label text-mute">(02) Selected works</p>
                <h2 class="display mx-auto mt-6 max-w-[20ch] text-[clamp(2.8rem,7.4vw,8.5rem)] text-balance" data-split>We saw the <span class="accent">opportunity</span> to…</h2>
            </div>
        </div>

        @foreach ($showcase as $i => $project)
            <article data-panel class="sticky top-0 h-[100svh] overflow-hidden bg-ink text-white">
                <div data-panel-inner class="absolute inset-0 origin-top">
                    @if ($project->coverUrl())
                        <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" decoding="async" class="absolute inset-0 h-full w-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/45"></div>

                    <div class="relative grid h-full grid-rows-[auto_1fr_auto] px-5 pt-24 pb-6 sm:px-8 lg:px-12 lg:pt-28 lg:pb-10">
                        {{-- Metadata strip --}}
                        <dl class="grid grid-cols-2 gap-4 border-t border-white/30 pt-4 text-sm sm:grid-cols-4">
                            <div><dt class="label text-white/55">Project</dt><dd class="mt-1">{{ $project->title }}</dd></div>
                            <div><dt class="label text-white/55">Location</dt><dd class="mt-1">{{ $project->location }}</dd></div>
                            <div class="hidden sm:block"><dt class="label text-white/55">Programme</dt><dd class="mt-1">{{ $project->category }}</dd></div>
                            <div class="hidden sm:block"><dt class="label text-white/55">Status</dt><dd class="mt-1">{{ $project->status }}{{ $project->year ? ', '.$project->year : '' }}</dd></div>
                        </dl>

                        <div class="flex flex-col items-center justify-center text-center">
                            <h3 class="display max-w-[22ch] text-[clamp(2.4rem,6.2vw,7rem)] text-balance">
                                {{ $project->tagline ?: $project->excerpt }}
                            </h3>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-light mt-10 min-w-56">
                                View project <span aria-hidden="true">→</span>
                            </a>
                        </div>

                        <div class="flex items-end justify-between gap-4 text-sm">
                            <span class="font-display text-2xl tabular-nums">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }} / {{ str_pad($showcase->count(), 2, '0', STR_PAD_LEFT) }}</span>
                            <a href="{{ route('projects.index') }}" class="label link-line py-3">All projects ({{ $projectCount }})</a>
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </section>
@endif

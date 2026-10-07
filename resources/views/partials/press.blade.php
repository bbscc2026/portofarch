@if ($press->isNotEmpty())
    <section class="wrap pb-24 lg:pb-36">
        <div class="grid gap-10 border-t border-ink pt-6 lg:grid-cols-12">
            <div class="lg:col-span-3" data-reveal>
                <h2 class="label text-mute">({{ $number ?? '06' }}) Press</h2>
            </div>
            <ul class="lg:col-span-9">
                @foreach ($press as $article)
                    <li data-reveal>
                        <a href="{{ $article->url }}" target="_blank" rel="noopener"
                           class="group grid grid-cols-[1fr_auto] items-baseline gap-x-6 gap-y-1 border-b border-line py-6 first:pt-0 sm:grid-cols-[11rem_1fr_auto]">
                            <span class="label text-mute">{{ $article->publication }}</span>
                            <span class="col-start-1 text-xl tracking-tight sm:col-start-2 sm:row-start-1">
                                <span class="link-line group-hover:bg-[length:100%_1px]">{{ $article->title }}</span>
                                @if ($article->project)
                                    <span class="mt-1 block text-sm text-mute">{{ $article->project->title }}</span>
                                @endif
                            </span>
                            <span class="col-start-2 row-span-2 row-start-1 transition-transform duration-500 ease-arch group-hover:translate-x-1 group-hover:-translate-y-1 sm:col-start-3 sm:row-span-1" aria-hidden="true">↗</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

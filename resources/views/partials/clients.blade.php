@if ($clients->isNotEmpty())
    <section class="wrap pb-24 lg:pb-36">
        <div class="grid gap-10 border-t border-ink pt-6 lg:grid-cols-12">
            <div class="lg:col-span-3" data-reveal>
                <h2 class="label text-mute">({{ $number ?? '05' }}) Clients</h2>
                <p class="mt-6 max-w-xs text-sm leading-relaxed text-graphite">Cultural institutions, brands and private clients we have worked with.</p>
            </div>
            <ul class="grid grid-cols-2 border-t border-l border-line sm:grid-cols-3 lg:col-span-9" data-reveal>
                @foreach ($clients as $client)
                    <li class="border-r border-b border-line">
                        <a @if ($client->url) href="{{ $client->url }}" target="_blank" rel="noopener" @endif
                           class="group grid aspect-[3/2] place-items-center p-8" title="{{ $client->name }}">
                            @if ($client->logoUrl())
                                <img src="{{ $client->logoUrl() }}" alt="{{ $client->name }}" loading="lazy"
                                     class="max-h-14 max-w-[70%] object-contain opacity-60 mix-blend-multiply grayscale transition duration-500 group-hover:opacity-100">
                            @else
                                <span class="text-lg">{{ $client->name }}</span>
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif

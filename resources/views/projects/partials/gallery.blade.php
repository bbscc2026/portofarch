{{-- Wide images span the full row; the others pair up two to a row. Captions are numbered like drawing figures. --}}
@if ($images->isNotEmpty())
    <section class="wrap grid gap-x-4 gap-y-8 md:grid-cols-2 lg:gap-x-6 lg:gap-y-12">
        @foreach ($images as $image)
            <figure @class(['md:col-span-2' => $image->is_wide])>
                <div @class(['overflow-hidden bg-plaster', 'aspect-[4/3] md:aspect-[16/9]' => $image->is_wide, 'aspect-[4/5]' => ! $image->is_wide]) data-clip>
                    <img src="{{ $image->url() }}" alt="{{ $image->caption ?? '' }}" loading="lazy" decoding="async" class="h-full w-full object-cover">
                </div>
                @if ($image->caption)
                    <figcaption class="mt-3 flex gap-4 text-sm text-mute">
                        <span class="tabular-nums">Fig. {{ str_pad(($figureOffset ?? 0) + $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span>{{ $image->caption }}</span>
                    </figcaption>
                @endif
            </figure>
        @endforeach
    </section>
@endif

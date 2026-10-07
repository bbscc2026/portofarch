@php
    $socials = collect(['Instagram' => 'instagram', 'LinkedIn' => 'linkedin', 'YouTube' => 'youtube', 'Facebook' => 'facebook'])
        ->map(fn ($key) => $site[$key] ?? null)
        ->filter();
    $email = $site['email'] ?? '';
    $phone = $site['phone'] ?? '';
    $address = $site['address'] ?? 'Jeddah, Saudi Arabia';
    $mapUrl = 'https://www.google.com/maps/search/?api=1&query='.rawurlencode(($site['site_name'] ?? 'Port of Arch').' '.$address);
    $footerLink = 'inline-flex min-h-11 lg:min-h-9 items-center text-white/70 transition-colors duration-300 hover:text-white';
    $column = 'border-t border-white/15 pt-5 lg:border-t-0 lg:border-l lg:px-6 lg:pt-0 first:lg:border-l-0 first:lg:pl-0';
@endphp

<footer class="overflow-hidden bg-ink text-white">
    {{-- 01 · Enquiries --}}
    <div class="wrap pt-24 lg:pt-36">
        <div class="grid gap-y-10 border-t border-white/25 pt-6 lg:grid-cols-12 lg:gap-x-10">
            <p class="label text-white/45 lg:col-span-3">Enquiries</p>
            <div class="lg:col-span-9">
                <p class="text-lg text-white/55">Have a site, a brief or simply an idea?</p>
                <a href="{{ route('contact') }}" class="group mt-4 inline-flex max-w-full items-end gap-[0.25em] text-[clamp(3rem,8.4vw,9.5rem)]">
                    <span class="display whitespace-nowrap">Start a <span class="accent">project</span></span>
                    <span class="mb-[0.14em] shrink-0 text-[0.45em] font-light transition-transform duration-700 ease-arch group-hover:translate-x-3" aria-hidden="true">→</span>
                </a>
                <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                    @if ($email)
                        <a href="mailto:{{ $email }}" class="btn btn-light sm:min-w-64">Email the studio <span aria-hidden="true">→</span></a>
                    @endif
                    @if (! empty($site['whatsapp']))
                        <a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" class="btn btn-light border-white/35 sm:min-w-64">WhatsApp <span aria-hidden="true">↗</span></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 02 · Title block --}}
    <div class="wrap mt-24 lg:mt-36">
        <div class="grid gap-x-0 gap-y-10 border-y border-white/15 py-10 sm:grid-cols-2 lg:grid-cols-3 lg:py-12">
            <div class="{{ $column }}">
                <p class="label text-white/45">Studio</p>
                <address class="mt-4 text-white/80 not-italic leading-relaxed">
                    {{ $site['site_name'] ?? 'Port of Arch' }}<br>
                    {{ $address }}
                </address>
                <p class="mt-3 text-sm text-white/40 tabular-nums">21.49° N, 39.19° E · GMT+3</p>
                <a href="{{ $mapUrl }}" target="_blank" rel="noopener" class="label mt-4 inline-flex min-h-11 lg:min-h-9 items-center gap-2 text-white/70 hover:text-white">Open in Maps <span aria-hidden="true">↗</span></a>
            </div>

            <div class="{{ $column }}">
                <p class="label text-white/45">Contact</p>
                <ul class="mt-3">
                    @if ($email)
                        <li><a href="mailto:{{ $email }}" class="{{ $footerLink }} break-all">{{ $email }}</a></li>
                    @endif
                    @if ($phone)
                        <li><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}" class="{{ $footerLink }} whitespace-nowrap">{{ $phone }}</a></li>
                    @endif
                    @if (! empty($site['whatsapp']))
                        <li><a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" class="{{ $footerLink }}">WhatsApp ↗</a></li>
                    @endif
                    @foreach ($socials as $name => $url)
                        <li><a href="{{ $url }}" target="_blank" rel="noopener" class="{{ $footerLink }}">{{ $name }} ↗</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="{{ $column }}">
                <p class="label text-white/45">Index</p>
                <ul class="mt-3 grid grid-cols-2 gap-x-6 lg:grid-cols-1">
                    @foreach ([['Home', route('home')], ['Projects', route('projects.index')], ['Studio', route('studio')], ['Services', route('services')], ['Contact', route('contact')]] as $i => [$label, $href])
                        <li>
                            <a href="{{ $href }}" class="{{ $footerLink }} group gap-3">
                                <span class="text-[10px] text-white/35 tabular-nums">0{{ $i + 1 }}</span>
                                <span class="link-line">{{ $label }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>

    {{-- 03 · Wordmark, sized to span the full page width exactly --}}
    <div class="wrap mt-10 lg:mt-14" aria-hidden="true">
        <svg viewBox="0 0 1000 118" class="block w-full text-white" data-reveal>
            <text x="0" y="112" textLength="1000" lengthAdjust="spacingAndGlyphs" fill="currentColor"
                  style="font-family: var(--font-display); font-weight: 500; font-size: 150px; letter-spacing: -0.01em;">PORT OF ARCH</text>
        </svg>
    </div>

    {{-- 04 · Colophon --}}
    <div class="wrap">
        <div class="mt-6 flex flex-col gap-4 border-t border-white/15 py-6 pb-[max(1.5rem,env(safe-area-inset-bottom))] text-xs text-white/45 sm:flex-row sm:items-center sm:justify-between">
            <p>© {{ now()->year }} {{ $site['site_name'] ?? 'Port of Arch' }} · Architecture & Interiors · Est. {{ $site['founded_year'] ?? '2018' }}, Jeddah</p>
            <a href="#main" class="label inline-flex min-h-11 lg:min-h-9 items-center gap-2 self-start text-white/60 hover:text-white sm:self-auto">Back to top <span aria-hidden="true">↑</span></a>
        </div>
    </div>
</footer>

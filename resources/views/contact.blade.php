<x-layouts.site title="Contact" description="Start a project with Port of Arch — architecture and interior design studio in Jeddah, Saudi Arabia.">
    @php
        $field = 'mt-1 w-full border-0 border-b border-line bg-transparent px-0 py-3 text-base placeholder:text-mute/70 transition-colors focus:border-ink focus:ring-0 focus:outline-none sm:text-lg';
        $phoneHref = 'tel:'.preg_replace('/\s+/', '', $site['phone'] ?? '');
    @endphp

    <section class="wrap pt-32 pb-24 sm:pt-40 lg:pt-48 lg:pb-36">
        <h1 class="display text-[clamp(4rem,12vw,12rem)]" data-split="load">Contact</h1>

        <div class="mt-14 grid gap-16 border-t border-ink pt-8 lg:mt-20 lg:grid-cols-12">
            {{-- Studio details --}}
            <div class="lg:col-span-4">
                <p class="max-w-sm text-lg leading-relaxed text-graphite" data-reveal>Tell us about your site, brief and timeline. We usually reply within one working day.</p>

                <dl class="mt-10 border-t border-line" data-reveal>
                    <div class="border-b border-line py-4">
                        <dt class="label text-mute">Email</dt>
                        <dd class="mt-1.5 text-lg"><a href="mailto:{{ $site['email'] ?? '' }}" class="link-line break-all">{{ $site['email'] ?? '' }}</a></dd>
                    </div>
                    <div class="border-b border-line py-4">
                        <dt class="label text-mute">Telephone</dt>
                        <dd class="mt-1.5 text-lg"><a href="{{ $phoneHref }}" class="link-line whitespace-nowrap">{{ $site['phone'] ?? '' }}</a></dd>
                    </div>
                    @if (! empty($site['whatsapp']))
                        <div class="border-b border-line py-4">
                            <dt class="label text-mute">WhatsApp</dt>
                            <dd class="mt-1.5 text-lg"><a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" class="link-line">Message the studio ↗</a></dd>
                        </div>
                    @endif
                    <div class="border-b border-line py-4">
                        <dt class="label text-mute">Studio</dt>
                        <dd class="mt-1.5 text-lg">{{ $site['address'] ?? '' }}<span class="mt-1 block text-sm text-mute">21.49° N, 39.19° E</span></dd>
                    </div>
                </dl>
            </div>

            {{-- Enquiry form --}}
            <div class="lg:col-span-7 lg:col-start-6">
                @if (session('sent'))
                    <div class="border border-ink p-8 sm:p-12" role="status">
                        <p class="label text-mute">Enquiry received</p>
                        <p class="statement mt-6">Thank you — we will be in touch shortly.</p>
                    </div>
                @else
                    <form method="POST" action="{{ route('contact.store') }}" class="space-y-10" novalidate data-reveal>
                        @csrf
                        {{-- Honeypot: real visitors never see or fill this. --}}
                        <div class="hidden" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>

                        <fieldset>
                            <legend class="label text-mute">Project type</legend>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($projectTypes as $type)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="project_type" value="{{ $type }}" class="peer sr-only" @checked(old('project_type') === $type)>
                                        <span class="inline-flex min-h-11 items-center border border-line px-4 text-sm transition-colors peer-checked:border-ink peer-checked:bg-ink peer-checked:text-white peer-focus-visible:outline-2 peer-focus-visible:outline-ink hover:border-ink">{{ $type }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('project_type') <span class="mt-2 block text-sm text-arch">{{ $message }}</span> @enderror
                        </fieldset>

                        <div class="grid gap-10 sm:grid-cols-2">
                            <label class="block">
                                <span class="label text-mute">Name *</span>
                                <input type="text" name="name" value="{{ old('name') }}" required autocomplete="name" class="{{ $field }}">
                                @error('name') <span class="mt-2 block text-sm text-arch">{{ $message }}</span> @enderror
                            </label>
                            <label class="block">
                                <span class="label text-mute">Email *</span>
                                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" inputmode="email" class="{{ $field }}">
                                @error('email') <span class="mt-2 block text-sm text-arch">{{ $message }}</span> @enderror
                            </label>
                        </div>

                        <label class="block">
                            <span class="label text-mute">Telephone</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}" autocomplete="tel" inputmode="tel" class="{{ $field }}" placeholder="+966">
                            @error('phone') <span class="mt-2 block text-sm text-arch">{{ $message }}</span> @enderror
                        </label>

                        <label class="block">
                            <span class="label text-mute">Project brief *</span>
                            <textarea name="message" rows="5" required class="{{ $field }} resize-y" placeholder="Site location, approximate area, timeline, budget…">{{ old('message') }}</textarea>
                            @error('message') <span class="mt-2 block text-sm text-arch">{{ $message }}</span> @enderror
                        </label>

                        <button type="submit" class="btn btn-solid min-h-14 w-full sm:w-auto sm:min-w-64">
                            Send enquiry <span aria-hidden="true">→</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>
</x-layouts.site>

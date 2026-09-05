@php
    $tips = [
        ['image' => 'images/actu3.jpg', 'alt' => "Une bonne coiffure améliore la journée"],
        ['image' => 'images/actu4.jpg', 'alt' => "Pourquoi protéger ses cheveux la nuit avec un bonnet en satin"],
    ];
    $totalSlides = count($tips) + 1;
@endphp

<div data-tips-modal class="fixed inset-0 z-[60] hidden items-center justify-center bg-ink-900/70 p-4 backdrop-blur-sm">
    <div class="relative w-full max-w-sm">
        <button type="button" data-tips-close aria-label="Fermer" class="absolute -top-3 -right-3 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-white text-ink-900 shadow-lg transition hover:bg-brand-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="overflow-hidden rounded-2xl bg-white shadow-2xl">
            <p class="section-eyebrow px-5 pt-5">Conseil du jour</p>

            <div class="relative mt-2">
                @foreach ($tips as $i => $tip)
                    <img
                        src="{{ asset($tip['image']) }}"
                        alt="{{ $tip['alt'] }}"
                        data-tips-slide
                        class="w-full {{ $i === 0 ? '' : 'hidden' }}"
                    >
                @endforeach

                {{-- Always the last slide: an invitation to book --}}
                <div data-tips-slide class="group relative hidden aspect-[4/5] w-full flex-col items-center justify-center gap-4 overflow-hidden p-8 text-center text-white">
                    <img
                        src="{{ asset('images/braids18.jpg') }}"
                        alt=""
                        class="absolute inset-0 h-full w-full scale-100 object-cover transition duration-500 ease-out group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-900/90 via-brand-900/60 to-rose-900/40"></div>

                    <span class="relative flex h-14 w-14 items-center justify-center rounded-full bg-white/15 backdrop-blur-sm transition duration-300 group-hover:scale-110 group-hover:bg-white/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </span>
                    <h3 class="relative font-serif text-2xl font-semibold drop-shadow-sm">Envie de tester ce look ?</h3>
                    <p class="relative text-white/90">Réservez votre rendez-vous en ligne en quelques clics, pour toutes les femmes.</p>
                    <a
                        href="{{ route('booking.create') }}"
                        class="btn-secondary relative bg-white text-brand-700 transition duration-200 hover:scale-105 hover:bg-brand-50 hover:shadow-lg"
                    >
                        Réserver maintenant
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-between p-4">
                <button type="button" data-tips-prev aria-label="Conseil précédent" class="btn-secondary px-3 py-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <div class="flex gap-1.5">
                    @for ($i = 0; $i < $totalSlides; $i++)
                        <span data-tips-dot class="h-1.5 w-1.5 rounded-full {{ $i === 0 ? 'bg-brand-600' : 'bg-ink-900/20' }}"></span>
                    @endfor
                </div>

                <button type="button" data-tips-next aria-label="Conseil suivant" class="btn-secondary px-3 py-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

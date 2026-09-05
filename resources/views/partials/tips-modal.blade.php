@php
    $tips = [
        ['image' => 'images/actu3.jpg', 'alt' => "Une bonne coiffure améliore la journée"],
        ['image' => 'images/actu4.jpg', 'alt' => "Pourquoi protéger ses cheveux la nuit avec un bonnet en satin"],
    ];
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
            </div>

            <div class="flex items-center justify-between p-4">
                <button type="button" data-tips-prev aria-label="Conseil précédent" class="btn-secondary px-3 py-2 text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <div class="flex gap-1.5">
                    @foreach ($tips as $i => $tip)
                        <span data-tips-dot class="h-1.5 w-1.5 rounded-full {{ $i === 0 ? 'bg-brand-600' : 'bg-ink-900/20' }}"></span>
                    @endforeach
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

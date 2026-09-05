@php
    $navLinks = [
        'home' => 'Accueil',
        'services.index' => 'Prestations',
        'trainings.index' => 'Formations',
        'gallery' => 'Galerie',
        'about' => 'À propos',
        'contact' => 'Contact',
    ];
@endphp

<header class="sticky top-0 z-50 border-b border-ink-900/5 bg-ink-50/90 backdrop-blur">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8" aria-label="Navigation principale">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-serif text-xl font-semibold text-brand-800">
            <img src="{{ asset('images/logoAbi.jpg') }}" alt="Abigail's Braids" class="h-10 w-10 rounded-full object-cover">
            Abigail's Braids
        </a>

        <div class="hidden items-center gap-8 md:flex">
            @foreach ($navLinks as $routeName => $label)
                <a
                    href="{{ route($routeName) }}"
                    class="text-sm font-medium {{ request()->routeIs($routeName) ? 'text-brand-700' : 'text-ink-900/70 hover:text-brand-700' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="hidden md:block">
            <a href="{{ route('booking.create') }}" class="btn-primary">
                Réserver
            </a>
        </div>

        <button
            type="button"
            data-nav-toggle
            class="inline-flex items-center justify-center rounded-lg p-2 text-ink-900 md:hidden"
            aria-controls="mobile-nav"
            aria-expanded="false"
        >
            <span class="sr-only">Ouvrir le menu</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
            </svg>
        </button>
    </nav>

    <div id="mobile-nav" data-mobile-nav class="hidden border-t border-ink-900/5 md:hidden">
        <div class="space-y-1 px-4 py-3">
            @foreach ($navLinks as $routeName => $label)
                <a
                    href="{{ route($routeName) }}"
                    class="block rounded-lg px-3 py-2 text-base font-medium {{ request()->routeIs($routeName) ? 'bg-brand-100 text-brand-800' : 'text-ink-900/80 hover:bg-brand-50' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
            <a href="{{ route('booking.create') }}" class="btn-primary mt-2 w-full">
                Réserver
            </a>
        </div>
    </div>
</header>

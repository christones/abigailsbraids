@php
    $adminTabs = [
        'admin.dashboard' => 'Réservations',
        'admin.training-registrations.index' => 'Inscriptions',
        'admin.services.index' => 'Prestations',
        'admin.trainings.index' => 'Formations',
        'admin.gallery.index' => 'Galerie',
        'admin.products.index' => 'Boutique',
    ];
@endphp

<div class="mt-6 flex flex-wrap gap-2 border-b border-ink-900/10">
    @foreach ($adminTabs as $routeName => $label)
        <a
            href="{{ route($routeName) }}"
            class="border-b-2 px-3 py-2 text-sm font-medium {{ request()->routeIs($routeName) || request()->routeIs($routeName.'.*') ? 'border-brand-600 text-brand-700' : 'border-transparent text-ink-900/60 hover:text-brand-700' }}"
        >
            {{ $label }}
        </a>
    @endforeach
</div>

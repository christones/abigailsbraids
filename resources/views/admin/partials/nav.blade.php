@php
    $adminTabs = [
        'admin.dashboard' => 'Réservations',
        'admin.training-registrations.index' => 'Inscriptions',
        'admin.services.index' => 'Prestations',
        'admin.trainings.index' => 'Formations',
        'admin.gallery.index' => 'Galerie',
        'admin.products.index' => 'Boutique',
        'admin.product-orders.index' => 'Commandes',
    ];

    // Sub-pages that should keep a tab highlighted (e.g. product categories live under Boutique).
    $adminTabExtras = [
        'admin.products.index' => ['admin.products.*', 'admin.product-categories.*'],
        'admin.product-orders.index' => ['admin.product-orders.*'],
    ];

    // Sub-pages that should keep a tab highlighted (e.g. product categories live under Boutique).
    $adminTabExtras = [
        'admin.products.index' => ['admin.products.*', 'admin.product-categories.*'],
    ];
@endphp

<div class="mt-6 flex flex-wrap gap-2 border-b border-ink-900/10">
    @foreach ($adminTabs as $routeName => $label)
        <a
            href="{{ route($routeName) }}"
            class="border-b-2 px-3 py-2 text-sm font-medium {{ request()->routeIs($routeName) || request()->routeIs($routeName.'.*') || request()->routeIs(...($adminTabExtras[$routeName] ?? [])) ? 'border-brand-600 text-brand-700' : 'border-transparent text-ink-900/60 hover:text-brand-700' }}"
        >
            {{ $label }}
        </a>
    @endforeach
</div>

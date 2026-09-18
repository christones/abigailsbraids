@extends('layouts.app')

@section('title', "Options — {$service->name} — Espace salon")

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Options — {{ $service->name }}</h1>
            </div>
            <a href="{{ route('admin.services.edit', $service) }}" class="btn-secondary text-sm">Retour à la prestation</a>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 ring-1 ring-green-600/20">
                {{ session('success') }}
            </div>
        @endif

        <p class="mt-6 text-sm text-ink-900/60">
            Ajoutez ici les variantes proposées pour cette prestation : modèle (ex. 2 / 4 / 6 tresses), avec/sans
            rajouts, longueurs, tailles, couleurs, etc. Chaque option appartient à une catégorie libre (ex. "Modèle",
            "Couleur") et s'affiche comme un choix à cocher pour la cliente au moment de la réservation.
        </p>
        <p class="mt-2 text-sm text-ink-900/60">
            Deux astuces automatiques : une valeur commençant par <strong>« Autre »</strong> (ex. "Autre couleur")
            fait apparaître un champ de précision pour la cliente. Une valeur contenant <strong>« personnalisé »</strong>
            (ex. "Modèle personnalisé") masque les autres options et invite la cliente à utiliser les champs photo/message
            du formulaire de réservation.
        </p>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.services.options.create', $service) }}" class="btn-primary text-sm">Ajouter une option</a>
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-ink-900/5">
            <table class="min-w-full divide-y divide-ink-900/5 text-sm">
                <thead class="bg-brand-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-900/60">
                    <tr>
                        <th class="px-4 py-3">Catégorie d'option</th>
                        <th class="px-4 py-3">Valeur</th>
                        <th class="px-4 py-3">Supplément</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($options as $option)
                        <tr>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $option->group_label }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ $option->value_label }}</td>
                            <td class="px-4 py-3 text-ink-900/70">
                                {{ $option->extra_price ? '+'.number_format((float) $option->extra_price, 0, ',', ' ').' €' : '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($option->is_active)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-ink-900/10 px-2 py-0.5 text-xs font-medium text-ink-900/60">Masquée</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.services.options.edit', [$service, $option]) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">Modifier</a>
                                <form method="POST" action="{{ route('admin.services.options.destroy', [$service, $option]) }}" class="mt-1" onsubmit="return confirm('Supprimer cette option ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-ink-900/50">Aucune option pour cette prestation.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

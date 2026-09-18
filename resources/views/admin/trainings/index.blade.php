@extends('layouts.app')

@section('title', "Formations — Espace salon")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Formations</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary text-sm">Se déconnecter</button>
            </form>
        </div>

        @include('admin.partials.nav')

        @if (session('success'))
            <div class="mt-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 ring-1 ring-green-600/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.trainings.create') }}" class="btn-primary text-sm">Ajouter une formation</a>
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-ink-900/5">
            <table class="min-w-full divide-y divide-ink-900/5 text-sm">
                <thead class="bg-brand-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-900/60">
                    <tr>
                        <th class="px-4 py-3">Ordre</th>
                        <th class="px-4 py-3">Photo</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Niveau</th>
                        <th class="px-4 py-3">Prix</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($trainings as $training)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-0.5">
                                    <form method="POST" action="{{ route('admin.trainings.move-up', $training) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-ink-900/50 hover:text-brand-700" title="Monter" aria-label="Monter">&uarr;</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.trainings.move-down', $training) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-ink-900/50 hover:text-brand-700" title="Descendre" aria-label="Descendre">&darr;</button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <img
                                    src="{{ $training->image_path ? asset($training->image_path) : 'https://placehold.co/80x80/faeadb/863f1f?text=%20' }}"
                                    alt="{{ $training->name }}"
                                    class="h-12 w-12 rounded-lg object-cover"
                                >
                            </td>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $training->name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ $training->level ?? '—' }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ number_format((float) $training->price_from, 0, ',', ' ') }} €</td>
                            <td class="px-4 py-3">
                                @if ($training->is_active)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-ink-900/10 px-2 py-0.5 text-xs font-medium text-ink-900/60">Masquée</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.trainings.edit', $training) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">Modifier</a>
                                <form method="POST" action="{{ route('admin.trainings.destroy', $training) }}" class="mt-1" onsubmit="return confirm('Supprimer cette formation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-ink-900/50">Aucune formation pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

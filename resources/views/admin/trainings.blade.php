@extends('layouts.app')

@section('title', "Formations — Espace salon")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Inscriptions aux formations</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary text-sm">Se déconnecter</button>
            </form>
        </div>

        <div class="mt-6 flex gap-2 border-b border-ink-900/10">
            <a href="{{ route('admin.dashboard') }}" class="border-b-2 border-transparent px-3 py-2 text-sm font-medium text-ink-900/60 hover:text-brand-700">Réservations</a>
            <a href="{{ route('admin.trainings.index') }}" class="border-b-2 border-brand-600 px-3 py-2 text-sm font-medium text-brand-700">Formations</a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div class="card p-5">
                <p class="text-sm text-ink-900/50">Total</p>
                <p class="mt-1 font-serif text-3xl font-semibold text-ink-900">{{ $counts['total'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-sm text-ink-900/50">En attente</p>
                <p class="mt-1 font-serif text-3xl font-semibold text-brand-600">{{ $counts['pending'] }}</p>
            </div>
            <div class="card p-5">
                <p class="text-sm text-ink-900/50">Confirmées</p>
                <p class="mt-1 font-serif text-3xl font-semibold text-green-600">{{ $counts['confirmed'] }}</p>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-2">
            <a href="{{ route('admin.trainings.index') }}" class="rounded-full px-4 py-1.5 text-sm {{ $status === '' ? 'bg-brand-600 text-white' : 'bg-white text-ink-900/70 ring-1 ring-ink-900/10' }}">Toutes</a>
            @foreach (\App\Models\TrainingRegistration::statusLabels() as $value => $label)
                <a
                    href="{{ route('admin.trainings.index', ['statut' => $value]) }}"
                    class="rounded-full px-4 py-1.5 text-sm {{ $status === $value ? 'bg-brand-600 text-white' : 'bg-white text-ink-900/70 ring-1 ring-ink-900/10' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-ink-900/5">
            <table class="min-w-full divide-y divide-ink-900/5 text-sm">
                <thead class="bg-brand-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-900/60">
                    <tr>
                        <th class="px-4 py-3">Candidate</th>
                        <th class="px-4 py-3">Formation</th>
                        <th class="px-4 py-3">Date souhaitée</th>
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($registrations as $registration)
                        <tr>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $registration->candidate_name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ $registration->training->name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">
                                {{ $registration->preferred_date->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-ink-900/70">
                                <div>{{ $registration->candidate_phone }}</div>
                                <div class="text-xs text-ink-900/50">{{ $registration->candidate_email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.trainings.update', $registration) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-lg border-0 bg-brand-50 px-2 py-1 text-xs font-medium text-brand-800 ring-1 ring-inset ring-brand-200"
                                    >
                                        @foreach (\App\Models\TrainingRegistration::statusLabels() as $value => $label)
                                            <option value="{{ $value }}" @selected($registration->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.trainings.destroy', $registration) }}" onsubmit="return confirm('Supprimer cette inscription ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-ink-900/50">Aucune inscription pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $registrations->links() }}
        </div>
    </section>
@endsection

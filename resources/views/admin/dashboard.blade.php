@extends('layouts.app')

@section('title', "Réservations — Espace salon")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Réservations</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary text-sm">Se déconnecter</button>
            </form>
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
            <a href="{{ route('admin.dashboard') }}" class="rounded-full px-4 py-1.5 text-sm {{ $status === '' ? 'bg-brand-600 text-white' : 'bg-white text-ink-900/70 ring-1 ring-ink-900/10' }}">Toutes</a>
            @foreach (\App\Models\Booking::statusLabels() as $value => $label)
                <a
                    href="{{ route('admin.dashboard', ['statut' => $value]) }}"
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
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Prestation</th>
                        <th class="px-4 py-3">Date &amp; heure</th>
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($bookings as $booking)
                        <tr>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $booking->client_name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ $booking->service->name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">
                                {{ $booking->preferred_date->format('d/m/Y') }} à {{ $booking->preferred_time }}
                            </td>
                            <td class="px-4 py-3 text-ink-900/70">
                                <div>{{ $booking->client_phone }}</div>
                                <div class="text-xs text-ink-900/50">{{ $booking->client_email }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        class="rounded-lg border-0 bg-brand-50 px-2 py-1 text-xs font-medium text-brand-800 ring-1 ring-inset ring-brand-200"
                                    >
                                        @foreach (\App\Models\Booking::statusLabels() as $value => $label)
                                            <option value="{{ $value }}" @selected($booking->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Supprimer cette réservation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-ink-900/50">Aucune réservation pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </section>
@endsection

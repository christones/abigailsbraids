<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', "Abigail's Braids") — Tresses & Nattes Africaines à Strasbourg</title>
    <meta name="description" content="@yield('description', "Abigail's Braids, salon de tresses et nattes africaines à Strasbourg. Box braids, knotless, vanilles, cornrows... Réservez votre rendez-vous en ligne.")">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/logoAbi.jpg') }}" type="image/jpeg">
    <link rel="apple-touch-icon" href="{{ asset('images/logoAbi.jpg') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    @include('partials.navbar')

    <main class="flex-1">
        @if (session('status'))
            <div class="mx-auto mt-4 max-w-4xl px-4">
                <div class="rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 ring-1 ring-green-600/20">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.tips-modal')
</body>
</html>

<footer class="border-t border-ink-900/5 bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-serif text-xl font-semibold text-brand-800">
                <img src="{{ asset('images/logoAbi.jpg') }}" alt="Abigail's Braids" class="h-10 w-10 rounded-full object-cover">
                Abigail's Braids
            </a>
            <p class="mt-4 max-w-xs text-sm text-ink-900/70">
                Salon spécialisé en tresses et nattes africaines à Strasbourg. Box braids, knotless, vanilles, cornrows et soins capillaires, pour sublimer toutes les femmes.
            </p>
            <div class="mt-5 flex gap-4">
                <a href="https://www.facebook.com/abigailsbraids" target="_blank" rel="noopener noreferrer" class="text-ink-900/60 hover:text-brand-700" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.89h2.78l-.45 2.91h-2.33V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>
                </a>
                <a href="https://www.instagram.com/tresses_africaine_strasbourg/" target="_blank" rel="noopener noreferrer" class="text-ink-900/60 hover:text-brand-700" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.22.6 1.77 1.16.55.55.9 1.11 1.16 1.77.25.64.42 1.37.47 2.43.05 1.06.06 1.4.06 4.12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.93 4.93 0 0 1-1.16 1.77 4.93 4.93 0 0 1-1.77 1.16c-.64.25-1.37.42-2.43.47-1.06.05-1.4.06-4.12.06s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.93 4.93 0 0 1-1.77-1.16 4.93 4.93 0 0 1-1.16-1.77c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.22 1.16-1.77A4.93 4.93 0 0 1 5.46.53c.64-.25 1.37-.42 2.43-.47C8.94.01 9.28 0 12 0Zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10Zm0 8.2A3.2 3.2 0 1 1 12 6.8a3.2 3.2 0 0 1 0 6.4Zm5.4-8.4a1.17 1.17 0 1 1-2.33 0 1.17 1.17 0 0 1 2.33 0Z"/></svg>
                </a>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-900">Navigation</h3>
            <ul class="mt-4 space-y-2 text-sm text-ink-900/70">
                <li><a href="{{ route('services.index') }}" class="hover:text-brand-700">Nos prestations</a></li>
                <li><a href="{{ route('trainings.index') }}" class="hover:text-brand-700">Nos formations</a></li>
                <li><a href="{{ route('gallery') }}" class="hover:text-brand-700">Galerie</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-brand-700">À propos</a></li>
                <li><a href="{{ route('booking.create') }}" class="hover:text-brand-700">Prendre rendez-vous</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-brand-700">Contact</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-900">Nous trouver</h3>
            <ul class="mt-4 space-y-2 text-sm text-ink-900/70">
                <li>Strasbourg, France</li>
                <li><a href="tel:+33650991931" class="hover:text-brand-700">+33 6 50 99 19 31</a></li>
                <li><a href="mailto:contact@abigailsbraids.com" class="hover:text-brand-700">contact@abigailsbraids.com</a></li>
                <li class="pt-2">Mardi – Samedi : 9h – 18h</li>
                <li>Dimanche &amp; Lundi : fermé</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-ink-900/5 py-6 text-center text-xs text-ink-900/50">
        <p>
            &copy; {{ now()->year }} Abigail's Braids — Tous droits réservés.
            <span class="text-ink-900/30">·</span>
            Designed by <a href="https://techovasolutions.ca" target="_blank" rel="noopener noreferrer" class="text-ink-900/50 hover:text-brand-700">TechOva</a>
        </p>
    </div>
</footer>

import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';
import flatpickr from 'flatpickr';
import { French } from 'flatpickr/dist/l10n/fr.js';

document.addEventListener('DOMContentLoaded', () => {
    // Hero slider on the homepage
    const heroEl = document.querySelector('.hero-swiper');
    if (heroEl) {
        new Swiper(heroEl, {
            modules: [Autoplay, Navigation, Pagination],
            loop: true,
            effect: 'fade',
            speed: 800,
            autoplay: {
                delay: 5500,
                disableOnInteraction: false,
            },
            pagination: {
                el: heroEl.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: heroEl.querySelector('.swiper-button-next'),
                prevEl: heroEl.querySelector('.swiper-button-prev'),
            },
        });
    }

    // Gallery / realisations slider
    const galleryEl = document.querySelector('.gallery-swiper');
    if (galleryEl) {
        new Swiper(galleryEl, {
            modules: [Autoplay, Navigation, Pagination],
            slidesPerView: 1.15,
            spaceBetween: 16,
            centeredSlides: false,
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
            },
            pagination: {
                el: galleryEl.querySelector('.swiper-pagination'),
                clickable: true,
            },
            navigation: {
                nextEl: galleryEl.querySelector('.swiper-button-next'),
                prevEl: galleryEl.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                640: { slidesPerView: 2.2, spaceBetween: 20 },
                1024: { slidesPerView: 3.2, spaceBetween: 24 },
            },
        });
    }

    // Testimonials slider
    const testimonialsEl = document.querySelector('.testimonials-swiper');
    if (testimonialsEl) {
        new Swiper(testimonialsEl, {
            modules: [Autoplay, Pagination],
            slidesPerView: 1,
            spaceBetween: 24,
            autoplay: {
                delay: 6000,
                disableOnInteraction: false,
            },
            pagination: {
                el: testimonialsEl.querySelector('.swiper-pagination'),
                clickable: true,
            },
            breakpoints: {
                768: { slidesPerView: 2 },
            },
        });
    }

    // Booking date picker: closed Sundays (0) and Mondays (1), earliest tomorrow
    const dateInput = document.querySelector('#preferred_date');
    if (dateInput) {
        flatpickr(dateInput, {
            locale: French,
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j F Y',
            altInputClass: 'form-input',
            minDate: new Date().fp_incr(1),
            disable: [(date) => date.getDay() === 0 || date.getDay() === 1],
            disableMobile: true,
        });
    }

    // Mobile navigation toggle
    const navToggle = document.querySelector('[data-nav-toggle]');
    const mobileNav = document.querySelector('[data-mobile-nav]');
    if (navToggle && mobileNav) {
        navToggle.addEventListener('click', () => {
            mobileNav.classList.toggle('hidden');
            navToggle.setAttribute(
                'aria-expanded',
                mobileNav.classList.contains('hidden') ? 'false' : 'true'
            );
        });
    }

    // "Conseil du jour" popup: shown once per browser session
    const tipsModal = document.querySelector('[data-tips-modal]');
    if (tipsModal) {
        const slides = tipsModal.querySelectorAll('[data-tips-slide]');
        const dots = tipsModal.querySelectorAll('[data-tips-dot]');
        let tipIndex = 0;

        const showTip = (i) => {
            tipIndex = (i + slides.length) % slides.length;
            slides.forEach((slide, idx) => slide.classList.toggle('hidden', idx !== tipIndex));
            dots.forEach((dot, idx) => {
                dot.classList.toggle('bg-brand-600', idx === tipIndex);
                dot.classList.toggle('bg-ink-900/20', idx !== tipIndex);
            });
        };

        const openTips = () => {
            tipsModal.classList.remove('hidden');
            tipsModal.classList.add('flex');
        };

        const closeTips = () => {
            tipsModal.classList.add('hidden');
            tipsModal.classList.remove('flex');
        };

        tipsModal.querySelector('[data-tips-prev]').addEventListener('click', () => showTip(tipIndex - 1));
        tipsModal.querySelector('[data-tips-next]').addEventListener('click', () => showTip(tipIndex + 1));
        tipsModal.querySelector('[data-tips-close]').addEventListener('click', closeTips);
        tipsModal.addEventListener('click', (event) => {
            if (event.target === tipsModal) closeTips();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') closeTips();
        });

        try {
            if (!sessionStorage.getItem('tipsModalShown')) {
                setTimeout(openTips, 1500);
                sessionStorage.setItem('tipsModalShown', '1');
            }
        } catch (e) {
            // Storage unavailable (private browsing, etc.) -- skip the auto-popup.
        }
    }
});

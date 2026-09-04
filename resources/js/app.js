import Swiper from 'swiper';
import { Autoplay, Navigation, Pagination } from 'swiper/modules';

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
});

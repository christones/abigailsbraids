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

    // Booking date picker: earliest tomorrow. Days are not restricted here since
    // opening hours are not finalized yet; availability is confirmed by phone/e-mail.
    const dateInput = document.querySelector('#preferred_date');
    if (dateInput) {
        flatpickr(dateInput, {
            locale: French,
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'j F Y',
            altInputClass: 'form-input',
            minDate: new Date().fp_incr(1),
            disableMobile: true,
        });
    }

    // Booking: option groups (models, add-ons, colors...) are admin-managed
    // per service. Render the right groups for the selected service, reveal a
    // free-text field for "Autre..." choices, and hint at the photo/notes
    // fields when a "personnalisé" choice makes the other groups irrelevant.
    const bookingForm = document.querySelector('[data-booking-form]');
    if (bookingForm && window.bookingServiceOptions) {
        const serviceField = bookingForm.querySelector('#service_id');
        const optionsContainer = bookingForm.querySelector('[data-service-options]');

        const updateGroupState = (wrapper) => {
            const checked = wrapper.querySelector('input[type="radio"]:checked');
            const otherWrapper = wrapper.querySelector('[data-other-field]');
            const chosenLabel = checked ? checked.dataset.optionLabel || '' : '';
            otherWrapper.classList.toggle('hidden', !/^autre/i.test(chosenLabel));

            const isCustom = /personnalis/i.test(chosenLabel);
            optionsContainer.querySelectorAll('[data-option-group]').forEach((el) => {
                if (el !== wrapper) {
                    el.classList.toggle('hidden', isCustom);
                    if (isCustom) {
                        // Clear any previous selection in the now-irrelevant groups
                        // so a stale choice isn't submitted alongside "personnalisé".
                        el.querySelectorAll('input[type="radio"]').forEach((radio) => { radio.checked = false; });
                        const nestedOther = el.querySelector('[data-other-field]');
                        if (nestedOther) {
                            nestedOther.classList.add('hidden');
                            nestedOther.querySelector('input').value = '';
                        }
                    }
                }
            });

            let hint = optionsContainer.querySelector('[data-custom-hint]');
            if (isCustom) {
                if (!hint) {
                    hint = document.createElement('p');
                    hint.dataset.customHint = '';
                    hint.className = 'rounded-lg bg-brand-50 px-4 py-3 text-sm text-ink-900/70';
                    hint.textContent = "Utilisez les champs « photo d'inspiration » et « message » plus bas pour décrire le modèle souhaité.";
                    wrapper.after(hint);
                }
            } else if (hint) {
                hint.remove();
            }
        };

        const renderGroup = (group) => {
            const wrapper = document.createElement('div');
            wrapper.dataset.optionGroup = group.group;

            const legend = document.createElement('span');
            legend.className = 'form-label';
            legend.textContent = group.group;
            wrapper.appendChild(legend);

            const choices = document.createElement('div');
            choices.className = 'mt-2 flex flex-wrap gap-2';

            group.options.forEach((option) => {
                const label = document.createElement('label');
                label.className = 'cursor-pointer rounded-lg border border-ink-900/10 bg-white px-3 py-2 text-sm font-medium text-ink-900/80 transition has-[:checked]:border-brand-600 has-[:checked]:bg-brand-600 has-[:checked]:text-white has-[:checked]:shadow-sm hover:border-brand-300';

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = `option_choices[${group.group}]`;
                input.value = option.id;
                input.className = 'sr-only';
                input.dataset.optionLabel = option.label;
                input.addEventListener('change', () => updateGroupState(wrapper));

                label.appendChild(input);
                label.appendChild(document.createTextNode(option.label));
                choices.appendChild(label);
            });

            wrapper.appendChild(choices);

            const otherWrapper = document.createElement('div');
            otherWrapper.className = 'mt-2 hidden';
            otherWrapper.dataset.otherField = '';
            const otherInput = document.createElement('input');
            otherInput.type = 'text';
            otherInput.name = `option_other[${group.group}]`;
            otherInput.placeholder = 'Précisez';
            otherInput.className = 'form-input';
            otherWrapper.appendChild(otherInput);
            wrapper.appendChild(otherWrapper);

            return wrapper;
        };

        const renderOptionsForService = (serviceId) => {
            optionsContainer.innerHTML = '';
            const groups = window.bookingServiceOptions[serviceId];
            if (!groups || groups.length === 0) return;
            groups.forEach((group) => optionsContainer.appendChild(renderGroup(group)));
        };

        if (serviceField.tagName === 'SELECT') {
            serviceField.addEventListener('change', () => renderOptionsForService(serviceField.value));
        }

        if (serviceField.value) {
            renderOptionsForService(serviceField.value);
        }
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
            slides.forEach((slide, idx) => {
                const isActive = idx === tipIndex;
                slide.classList.toggle('hidden', !isActive);
                if (slide.tagName !== 'IMG') {
                    slide.classList.toggle('flex', isActive);
                }
            });
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

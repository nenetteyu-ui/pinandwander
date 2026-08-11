(function () {
    'use strict';

    var header    = document.getElementById('site-header');
    var navToggle = document.getElementById('nav-toggle');
    var siteNav   = document.getElementById('site-nav');
    var hero      = document.getElementById('hero');

    // ── Header scroll behaviour ────────────────────────────────────────
    function updateHeader() {
        // Transparent only when sitting at the top of a page that HAS a hero;
        // every other case gets the solid (green) header so the logo stays legible.
        if (window.scrollY > 60 || !hero) {
            header.classList.add('is-scrolled');
            header.classList.remove('is-transparent');
        } else {
            header.classList.remove('is-scrolled');
            header.classList.add('is-transparent');
        }
    }

    if (hero) {
        header.classList.add('is-transparent');
    } else {
        header.classList.add('is-scrolled');
    }

    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();

    // ── Mobile nav toggle ──────────────────────────────────────────────
    function openNav() {
        siteNav.classList.add('is-open');
        navToggle.classList.add('is-active');
        navToggle.setAttribute('aria-expanded', 'true');
        document.body.classList.add('nav-open');
    }

    function closeNav() {
        siteNav.classList.remove('is-open');
        navToggle.classList.remove('is-active');
        navToggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('nav-open');
    }

    if (navToggle && siteNav) {
        navToggle.addEventListener('click', function () {
            siteNav.classList.contains('is-open') ? closeNav() : openNav();
        });

        // Close when a link is tapped
        siteNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeNav);
        });

        // Close when clicking the overlay (the ::before pseudo on body)
        document.addEventListener('click', function (e) {
            if (
                document.body.classList.contains('nav-open') &&
                !siteNav.contains(e.target) &&
                e.target !== navToggle &&
                !navToggle.contains(e.target)
            ) {
                closeNav();
            }
        });

        // Close on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && siteNav.classList.contains('is-open')) {
                closeNav();
                navToggle.focus();
            }
        });
    }

    // ── Hero slideshow ────────────────────────────────────────────────
    if (hero) {
        var slides = hero.querySelectorAll('.hero-slide');
        var reduceMotion = window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (slides.length > 1 && !reduceMotion) {
            var current = 0;
            setInterval(function () {
                slides[current].classList.remove('is-active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('is-active');
            }, 6000);
        }
    }
})();

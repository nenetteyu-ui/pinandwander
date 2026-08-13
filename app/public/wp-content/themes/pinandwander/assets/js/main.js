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

    // ── Scroll reveal ─────────────────────────────────────────────────
    // Elements marked .reveal fade and rise as they scroll into view.
    // Children of a [data-reveal-stagger] container arrive in sequence.
    (function () {
        var revealEls = document.querySelectorAll('.reveal');
        if (!revealEls.length) {
            return;
        }

        function showAll() {
            for (var i = 0; i < revealEls.length; i++) {
                revealEls[i].classList.add('is-visible');
            }
        }

        // Older browsers, or anyone who prefers less motion: just show it.
        if (!('IntersectionObserver' in window)) {
            showAll();
            return;
        }
        if (window.matchMedia &&
            window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            showAll();
            return;
        }

        // Stagger each group's direct children so grids arrive as a wave.
        var groups = document.querySelectorAll('[data-reveal-stagger]');
        for (var g = 0; g < groups.length; g++) {
            var kids = groups[g].children;
            var step = parseInt(groups[g].getAttribute("data-reveal-stagger"), 10) || 110;
            var shown = 0;
            for (var k = 0; k < kids.length; k++) {
                if (kids[k].classList.contains('reveal')) {
                    // Cap the delay so a long archive page never stalls.
                    kids[k].style.setProperty(
                        '--reveal-delay',
                        Math.min(shown * step, step * 5) + 'ms'
                    );
                    shown++;
                }
            }
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            // Fire a little before the element is fully on screen.
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.08
        });

        // Reveal is for content you scroll TO. Anything already on screen at
        // load is shown at once with the transition suppressed, so headings
        // never fade in under the visitor's eyes on arrival.
        var viewportH = window.innerHeight || document.documentElement.clientHeight;

        for (var n = 0; n < revealEls.length; n++) {
            if (revealEls[n].getBoundingClientRect().top < viewportH) {
                revealEls[n].classList.add('is-instant', 'is-visible');
            } else {
                observer.observe(revealEls[n]);
            }
        }
    })();

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
            }, 7500);
        }
    }
})();

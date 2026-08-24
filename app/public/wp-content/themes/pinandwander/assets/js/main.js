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

        // Reveal is for content you scroll TO. Anything already on screen at
        // load is shown at once with the transition suppressed, so headings
        // never fade in under the visitor's eyes on arrival.
        var viewportH = window.innerHeight || document.documentElement.clientHeight;
        var pending = [];

        for (var n = 0; n < revealEls.length; n++) {
            if (revealEls[n].getBoundingClientRect().top < viewportH) {
                revealEls[n].classList.add('is-instant', 'is-visible');
            } else {
                pending.push(revealEls[n]);
            }
        }
        if (!pending.length) return;

        // An element counts as reached once its top edge is inside the
        // viewport. Deliberately not a percentage of the element: a share of
        // a 3300px article body would demand hundreds of pixels on screen
        // before firing, so the reader scrolls into blank space and the text
        // snaps in late.
        function sweep() {
            ticking = false;
            var limit = (window.innerHeight || 0) * 0.94;
            for (var i = pending.length - 1; i >= 0; i--) {
                if (pending[i].getBoundingClientRect().top < limit) {
                    pending[i].classList.add('is-visible');
                    if (observer) observer.unobserve(pending[i]);
                    pending.splice(i, 1);
                }
            }
            if (!pending.length) {
                window.removeEventListener('scroll', onScroll);
                window.removeEventListener('resize', onScroll);
            }
        }

        var ticking = false;
        function onScroll() {
            if (ticking) return;
            ticking = true;
            // A timer rather than requestAnimationFrame: rAF is tied to the
            // compositor and stops firing when the page is not being painted,
            // which would strand the sweep. The flag coalesces a burst of
            // scroll events into one pass.
            setTimeout(sweep, 0);
        }

        // IntersectionObserver does the work cheaply; the scroll sweep above
        // is the guarantee, so nothing can end up stranded at opacity 0.
        var observer = new IntersectionObserver(function (entries) {
            for (var i = 0; i < entries.length; i++) {
                if (!entries[i].isIntersecting) continue;
                entries[i].target.classList.add('is-visible');
                observer.unobserve(entries[i].target);
                var at = pending.indexOf(entries[i].target);
                if (at > -1) pending.splice(at, 1);
            }
        }, { rootMargin: '0px 0px -6% 0px', threshold: 0 });

        pending.forEach(function (el) { observer.observe(el); });

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll);
        sweep();
    })();

    // The hero crossfade is pure CSS (see pinandwander_hero_inline_css in
    // functions.php) so it starts on paint and never stalls behind a
    // throttled background timer.

    // ── Trip story: photo column ──────────────────────────────────────
    // On wide screens the story's photos move into a sticky column beside the
    // text, and cross-fade as you read past them. Below the breakpoint they
    // stay inline, in reading order. This runs from a classic footer script,
    // which executes before deferred module scripts, so the photos are in
    // place before WordPress hydrates its lightbox on them.
    (function () {
        var split = document.querySelector('.trip-split');
        if (!split) return;

        var prose   = split.querySelector('.prose');
        var gallery = split.querySelector('.trip-gallery');
        if (!prose || !gallery) return;

        var figures = [];
        var kids = prose.children;
        for (var i = 0; i < kids.length; i++) {
            if (kids[i].tagName === 'FIGURE') figures.push(kids[i]);
        }
        // One photo has nothing to cross-fade to; none has nothing to move.
        if (figures.length < 2) return;

        // Bookmark each photo's spot so it can go back when the screen narrows.
        var slots = figures.map(function (fig) {
            var slot = document.createComment('pw-figure');
            fig.parentNode.insertBefore(slot, fig);
            return slot;
        });

        var wide = window.matchMedia('(min-width: 1024px)');
        var moved = false;
        var current = -1;

        function show(index) {
            if (index === current) return;
            current = index;
            for (var i = 0; i < figures.length; i++) {
                var on = (i === index);
                figures[i].classList.toggle('is-current', on);
                // Keep the hidden photos out of the tab order and away from
                // screen readers — they are stacked on the visible one, so
                // without this a keyboard user would meet every photo at once.
                if (on) figures[i].removeAttribute('inert');
                else figures[i].setAttribute('inert', '');
            }
        }

        function update() {
            if (!moved) return;
            var box = prose.getBoundingClientRect();
            var viewH = window.innerHeight;
            // How far the reader has travelled through the text, 0 → 1.
            var span = Math.max(box.height - viewH * 0.5, 1);
            var read = Math.min(Math.max(viewH * 0.45 - box.top, 0), span);
            show(Math.min(figures.length - 1, Math.floor(read / span * figures.length)));
        }

        function apply() {
            if (wide.matches && !moved) {
                figures.forEach(function (fig) { gallery.appendChild(fig); });
                moved = true;
                split.classList.add('is-split');
                current = -1;
                update();
            } else if (!wide.matches && moved) {
                figures.forEach(function (fig, i) {
                    slots[i].parentNode.insertBefore(fig, slots[i]);
                    fig.classList.remove('is-current');
                });
                moved = false;
                split.classList.remove('is-split');
            }
        }

        window.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', function () { apply(); update(); });
        if (wide.addEventListener) wide.addEventListener('change', apply);
        else if (wide.addListener) wide.addListener(apply);
        apply();
    })();
})();

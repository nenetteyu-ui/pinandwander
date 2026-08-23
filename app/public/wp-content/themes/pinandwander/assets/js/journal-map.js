(function () {
    'use strict';

    var mapEl   = document.getElementById('journal-map');
    var listEl  = document.getElementById('jmapList');
    var panelEl = document.getElementById('jmapPanel');
    var dataEl  = document.getElementById('jmap-data');
    if (!mapEl || !listEl || !panelEl || !dataEl) return;

    var regions;
    try { regions = JSON.parse(dataEl.textContent); } catch (e) { return; }
    if (!regions || !regions.length) return;

    var GRADS = [
        'linear-gradient(150deg,#0d2233,#1e4d6a)',
        'linear-gradient(150deg,#1a2f1a,#3d6a3d)',
        'linear-gradient(150deg,#331a0d,#7a4020)',
        'linear-gradient(150deg,#2a1a36,#5a3366)',
        'linear-gradient(150deg,#0d1f33,#1e3d66)'
    ];
    var PIN_SCALE = 4.6;

    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[c];
        });
    }

    // Build hit areas + pins into the map
    var byId = {}, frag = '';
    regions.forEach(function (r) {
        byId[r.slug] = r;
        frag += '<rect class="jhit" data-region="' + esc(r.slug) + '" x="' + r.hit[0] + '" y="' + r.hit[1] +
                '" width="' + r.hit[2] + '" height="' + r.hit[3] + '"/>';
    });
    regions.forEach(function (r) {
        frag += '<g class="jpin" data-region="' + esc(r.slug) + '" role="button" tabindex="0" aria-label="' + esc(r.name) +
                '" transform="translate(' + r.pin[0] + ',' + r.pin[1] + ') scale(' + PIN_SCALE + ')">' +
                // Two nested groups, both anchored at the pin's tip:
                //   .jpin-art   — grows smoothly on hover (transition)
                //   .jpin-pulse — the steady heartbeat (animation)
                // They nest so the pin can ease up to size and pulse at the
                // same time. Scaling the outer <g> instead would overwrite the
                // transform attribute that positions it on the map.
                '<g class="jpin-art">' +
                '<g class="jpin-pulse">' +
                '<path class="jpin-shape" d="M0,0 C-5,-8 -8,-11 -8,-16 A8,8 0 1 1 8,-16 C8,-11 5,-8 0,0 Z"/>' +
                '<circle class="jpin-dot" cx="0" cy="-16" r="3"/>' +
                '</g>' +
                '</g>' +
                '<text class="jpin-label" x="0" y="19" text-anchor="middle">' + esc(r.name) + '</text>' +
                '</g>';
    });
    mapEl.insertAdjacentHTML('beforeend', frag);

    function select(slug) {
        var r = byId[slug];
        if (!r) return;
        panelEl.classList.add('has-selection');
        mapEl.querySelectorAll('.jpin').forEach(function (p) {
            p.classList.toggle('is-active', p.getAttribute('data-region') === slug);
        });
        renderList(r);
    }

    function renderList(r) {
        var html = '<h2 class="jmap-region">' + esc(r.name) + '</h2>' +
                   '<p class="jmap-count">' + r.stories.length + ' ' + (r.stories.length === 1 ? 'story' : 'stories') + '</p>' +
                   '<ul class="jstory-list">';
        r.stories.forEach(function (s, i) {
            var bg = s.thumb ? "url('" + encodeURI(s.thumb) + "')" : GRADS[i % GRADS.length];
            html += '<li><a class="jstory-item" href="' + encodeURI(s.url) + '">' +
                    '<span class="jstory-thumb" style="background-image:' + bg + '"></span>' +
                    '<span class="jstory-info"><span class="jstory-t">' + esc(s.title) + '</span>' +
                    '<span class="jstory-d">' + esc(s.date) + '</span></span>' +
                    '<span class="jstory-arrow">→</span></a></li>';
        });
        html += '</ul>';
        listEl.innerHTML = html;
    }

    mapEl.addEventListener('click', function (e) {
        var t = e.target.closest('.jpin, .jhit');
        if (t && t.getAttribute('data-region')) select(t.getAttribute('data-region'));
    });
    // Hovering the pin — or anywhere in its region's hit area, which is what
    // clicking already responds to — grows and pulses that pin.
    function pinFor(el) {
        var slug = el && el.getAttribute('data-region');
        return slug ? mapEl.querySelector('.jpin[data-region="' + slug + '"]') : null;
    }
    ['pointerover', 'pointerout'].forEach(function (evt) {
        mapEl.addEventListener(evt, function (e) {
            if (!e.target.closest) return;
            var pin = pinFor(e.target.closest('.jpin, .jhit'));
            if (pin) pin.classList.toggle('is-hover', evt === 'pointerover');
        });
    });

    mapEl.addEventListener('keydown', function (e) {
        if (e.key !== 'Enter' && e.key !== ' ') return;
        var t = e.target.closest('.jpin');
        if (t) { e.preventDefault(); select(t.getAttribute('data-region')); }
    });
})();

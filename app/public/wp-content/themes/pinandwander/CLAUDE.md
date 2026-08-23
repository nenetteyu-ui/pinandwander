# Pin & Wander - WordPress Theme

## Site Overview
- **Site:** pinandwander.com
- **Type:** Travel advisor + photographer portfolio and blog
- **Owner:** Travel advisor and photographer
- **Brand concept:** Pin the place you dream of, go and wander it, then repeat — the endless loop of travel. (Formerly "Repeat Wander List.")

## Design Vision
- Photo-forward, magazine editorial feel
- Full-width photography throughout
- Photos are the hero, not the text
- Minimal, elegant typography
- Mobile responsive
- Professional and beautiful
- **The site should feel alive, not static** — see Motion below

## Motion

Motion is part of the first draft of any page, not a polish pass. The
benchmarks are the hero slideshow and the pulsing map pin.

**Patterns already built — reuse these:**

| Pattern | How to use it |
|---------|----------------|
| Scroll reveal | Add `reveal` to a block. Put `data-reveal-stagger="110"` on a grid parent and its children arrive in a wave. |
| Hero crossfade | Pure CSS, generated in `pinandwander_hero_inline_css()`. Timing adapts to however many photos sit in `assets/hero/`. |
| Hover that moves | Map pins: `.jpin-art` transitions the size, nested `.jpin-pulse` animates the beat. Two groups so it can ease up *and* pulse at once. |

**Rules learned the hard way:**

- **Keyframes, not transitions, for anything that must move on load.** A
  transition needs a state change; server-rendered markup usually has none, so
  the element just sits there. This is what left the first hero slide static.
- **CSS animation over JS timers.** `setInterval` stalls behind background-tab
  throttling.
- **Reveal is for content you scroll *to*.** Anything already on screen at load
  is shown instantly — headings must never fade in under the reader.
- **Always honour `prefers-reduced-motion: reduce`.**
- **No animation libraries, no build step.** Node is deliberately not
  installed. Plain CSS and small vanilla JS only.

## Brand Colours
| Use | Hex | Notes |
|-----|-----|-------|
| Backgrounds, dark panels | `#10231a` | The site green. Very dark — reads as near-black when used for *text*. |
| **Text on light backgrounds** | `#1d4a34` | Confirmed 2026-08-13. The mid-green from the hero gradient; the one that actually reads as sea green. Use for the wordmark and type on cream or white. |
| Cream / page background | `#f5f3ef` | |
| Gold accent (on dark) | `#c9a96e` | Washes out on cream — use the darker gold there. |
| Gold accent (on cream) | `#a8863d` | |

Display face: Cormorant Garamond (italic 400 required — the gold ampersand
in the wordmark depends on it). Body: Inter.

## Pages
1. **Home** - Full screen hero photo, site name overlay, short tagline, latest trips in large visual grid below
2. **Blog / Photo Journal** - Large photo cards for each post, destination name overlaid on image, filterable by region
3. **Individual Trip Pages** - Full width photos throughout, text woven between photos, editorial magazine style
4. **About** - Personal and warm, portrait photo, story as travel advisor + photographer
5. **Contact / Work with me** - Simple contact form, services offered, social links

## Goals
- Inspire travelers through photography
- Market travel advisory services
- Drive contact form submissions

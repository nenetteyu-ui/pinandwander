# Pin & Wander — Tooling Inventory

A running list of everything installed or configured for building this site,
so it's easy to remember what we set up and why. Newest first.

| Date | What | Where | Why |
|------|------|-------|-----|
| 2026-08-13 | 6 companion skills: `design`, `design-system`, `brand`, `banner-design`, `ui-styling`, `slides` | `~/.claude/skills/` | Rest of the same repo — logos, design tokens, brand voice, banners, Tailwind/shadcn, presentations |
| 2026-08-13 | **ui-ux-pro-max** skill v2.13.0 | `~/.claude/skills/ui-ux-pro-max/` | Searchable UI/UX design database — 84 styles, 192 palettes, 74 font pairings, 98 UX guidelines |
| 2026-08-11 | Repo-local SSH command | `.git/config` in this repo | Fixes `Permission denied (publickey)` on push |
| 2026-08-10 | Git + GitHub backup | this repo → `github.com/nenetteyu-ui/pinandwander` | Version history and off-machine backup |

---

## Details

### ui-ux-pro-max (design skill)

- **Version:** 2.13.0 · MIT licence · by NextLevelBuilder
- **Source:** https://github.com/nextlevelbuilder/ui-ux-pro-max-skill
- **Installed to:** `~/.claude/skills/ui-ux-pro-max/` (44 files, 1.8 MB)
- **Needs:** Python 3 (already on this Mac at `/usr/bin/python3`)

Installed by hand rather than with the project's `npx ui-ux-pro-max-cli init`
installer, to avoid running downloaded code. The scripts were checked first:
standard library only, no network calls, no `subprocess`, no `eval`.

The bundled `SKILL.md` pointed at its scripts via `${CLAUDE_PLUGIN_ROOT}`, which
is only set for plugin-style installs. All 11 paths were rewritten to
`~/.claude/skills/ui-ux-pro-max` so it works as a personal skill.

Try it with:

```bash
python3 ~/.claude/skills/ui-ux-pro-max/scripts/search.py "travel photography portfolio" --domain style
```

To remove: `rm -rf ~/.claude/skills/ui-ux-pro-max`

### The 6 companion skills

Installed from the same repo on 2026-08-13, the same way (copied by hand, no
installer run). Total for all seven: 8.2 MB.

| Skill | Size | What it does | Works today? |
|-------|------|--------------|--------------|
| `design` | 316K | Logos (55 styles), corporate identity, design tokens | Search yes; logo *generation* needs a Gemini API key |
| `design-system` | 240K | Token architecture (primitive→semantic→component), slide generation | Python parts yes; `.cjs` token scripts need Node |
| `brand` | 128K | Brand voice, messaging frameworks, asset management | Needs Node — all 4 scripts are `.cjs` |
| `ui-styling` | 5.7M | Tailwind config generation, shadcn/ui components | Config generator yes; `shadcn_add.py` shells out to `npx` |
| `slides` | 32K | HTML presentations with Chart.js | Yes — reference material, no scripts |
| `banner-design` | 20K | Social/ad/hero banners | Partly — see missing dependencies below |

**Two caveats worth remembering:**

1. **Node isn't installed on this Mac.** Anything ending in `.cjs` won't run yet
   — that's all of `brand`, plus the token generators in `design-system`, plus
   shadcn component installs in `ui-styling`. Python 3 is present, so the
   Python-based skills work now. Install Node only if you want those parts.
2. **`banner-design` expects skills that aren't in this repo** — `ai-artist`,
   `ai-multimodal`, and `chrome-devtools`. Its banner *strategy* guidance still
   reads fine, but the image-generation steps will not resolve.

Image generation in `design` and `banner-design` goes through Google's Gemini
API and looks for a `GEMINI_API_KEY` environment variable. Nothing is set, so
those paths are inert — no key, no calls, no cost.

Correction to an earlier note: `design-system/scripts/fetch-background.py`
does **not** download anything despite its name. It only builds a Pexels search
URL string for a human to open.

To remove any of them: `rm -rf ~/.claude/skills/<name>`

### Repo-local SSH command

`git push` failed with `Permission denied (publickey)` even though
`ssh -T git@github.com` authenticated fine — the SSH agent had no identities
loaded and git wasn't falling back to the key on disk. Fixed with:

```bash
git config core.sshCommand "ssh -o IdentitiesOnly=yes -i ~/.ssh/id_ed25519"
```

This lives in `.git/config`, so it is never committed and applies only to this
project. VS Code and GitHub Desktop pick it up too. If other repos hit the same
error, the global fix is an entry in `~/.ssh/config` instead.

### Git + GitHub

- **Remote:** `git@github.com:nenetteyu-ui/pinandwander.git`
- **Tracked:** the custom theme only
- **Ignored:** WordPress core, `wp-config.php`, uploads, and Local's `conf/` + `logs/`

`~/rwl-web-app` is an unrelated starter repo GitHub created during sign-in. Not
in use — safe to delete.

---

## Evaluated, deliberately not installed

### 21st.dev / Magic MCP — 2026-08-13

A catalog of React components plus an MCP server that generates UI from plain
descriptions. The install command doing the rounds is:

```bash
npx @21st-dev/cli@latest install claude --api-key YOUR_KEY
```

**Not used, because it outputs React + TypeScript only** (shadcn/ui, Tailwind,
Radix). Their docs state there is no Vue, Svelte, Angular, or vanilla JS
support. This site is a WordPress PHP theme with hand-written CSS, so nothing it
generates would drop in. It also needs Node (not installed), a paid-ish account
and API key, and its free tier is only a handful of generations.

Worth revisiting only if a future project is React/Next.js — the same goes for
the `ui-styling` and `design-system` skills.

### Node.js — 2026-08-13

Deliberately skipped. WordPress runs on PHP, which Local already provides, so
the site needs nothing from Node. Revisit only if the `.cjs` scripts in `brand`
and `design-system` become genuinely useful. See notes above.

---

## Still to do

- **Deploy:** hosting on WP Engine, so the site goes live through Local's built-in
  **Connect** push, not through git. GitHub stays as version history only.
- Social links are still placeholders (`#`) in the footer and on the contact page.

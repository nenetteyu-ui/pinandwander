# Pin & Wander — Tooling Inventory

A running list of everything installed or configured for building this site,
so it's easy to remember what we set up and why. Newest first.

| Date | What | Where | Why |
|------|------|-------|-----|
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

**Not installed** — the same repo also bundles `design`, `design-system`,
`brand`, `banner-design`, `ui-styling`, and `slides`. The `design-system` one
includes scripts that fetch images over the network, so it would need its own
check before installing.

To remove: `rm -rf ~/.claude/skills/ui-ux-pro-max`

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

## Still to do

- **Deploy:** hosting on WP Engine, so the site goes live through Local's built-in
  **Connect** push, not through git. GitHub stays as version history only.
- Social links are still placeholders (`#`) in the footer and on the contact page.

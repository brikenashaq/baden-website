# BADEN Hausmeisterservice – Website (Startseite)

A small PHP website, no framework and no database. German first; English can be added later.
Pages built: **Startseite** and **Leistungen**.
Home page: full-screen photo slideshow, six service cards, "all 16 services" list, reasons, 4-step process, contact form.

## Open it

**Quick look (no PHP needed):** unzip, then double-click `preview.html`. The contact form does not work in this mode.

**Run it properly (with the form):**
```
cd baden-website
php -S localhost:8000
```
Open http://localhost:8000. (Mac: `brew install php` once, if PHP is missing.)

## Where to change things

| What | File |
|---|---|
| Phone, WhatsApp, e-mail, address, hours, mail recipient | `data/site.php` |
| All texts (headlines, services, steps, form labels) | `lang/de.php` |
| Colors | top of `assets/css/style.css` (`:root`) |
| Leistungen page texts | `lang/de-leistungen.php` |
| Leistungen page photos | `assets/img/leistungen/` – one photo per service by file name, e.g. `01-1.jpg`, `01-1b.jpg` (see `FOTOS.txt` there) |
| Photo helper (shrink + remove GPS) | `php tools/optimize-photos.php` |
| Hero photos | `assets/img/hero/hero-1.jpg … hero-4.jpg` (1920 px) and `hero-1-1200.jpg …` (1200 px, for phones) |
| Service card photos | `assets/img/cards/<name>.jpg` (3:2, 1200 × 800 px) |
| Logo | `assets/img/logo/` |
| Menu links | `data/site.php` → `pages` |

Things worth knowing:
- Anything in `[SQUARE BRACKETS]` is a placeholder. Search the project for `[` before launch.
- A missing card photo shows a neat "Foto folgt" tile automatically (see `entruempelung`). Add `assets/img/cards/entruempelung.jpg` and it appears.
- Leistungen page photos: add `01-1.jpg` (area 01, service 1), `01-2.jpg` … and the area slideshow picks them up by itself. Open `leistungen.php?fotos` to see which slots are filled.
- Leistungen page: the sixth area (Entrümpelung & Umzug) shows a "Foto folgt" panel until `assets/img/leistungen/stage-6.jpg` exists. The big lettering is filled with `textfill.jpg` (a wide strip of the service photos).
- Before/after slider: add `assets/img/referenzen/vorher-1.jpg` and `nachher-1.jpg`. The section appears by itself.
- Hero slides (photo, crop position, darkness, headline): `lang/de.php` → `hero` → `slides`.

## Contact form (`send.php`)
- `dev_mode` is **true** in `data/site.php`: requests are only written to `data/outbox.txt`, nothing is mailed. Good for testing.
- On the real server: set `dev_mode` to `false`, and set `mail_to` and `mail_from` (the sender must be an address of the site's own domain).
- Spam protection without Google: hidden field and timer. If spam gets through later, add a rate limit or use PHPMailer with the host's SMTP account.

## Before launch – checklist
1. Replace all `[PLACEHOLDERS]` (phone, address, region, hours, intro text).
2. Confirm with the client every claim on the page: *Fester Ansprechpartner, Klare Preise inkl. MwSt., Termine nach Absprache, Saubere Arbeit* and that Winterdienst means snow clearing and gritting. Remove what is not true. If the client is a Kleinunternehmer, change the VAT notes.
3. Replace the Pexels stand-in photos with the client's own photos. Do not present people from stock photos as the client's team. Strip GPS data from every photo (ImageOptim, squoosh.app).
4. Write the real **Impressum** and **Datenschutzerklärung** (eRecht24 or Datenschutz-Generator.de). The pages `impressum.php` and `datenschutz.php` are drafts only.
5. Hosting in Germany with PHP 8, SSL (https) and an AVV signed with the host. Put the files on the server by SFTP.
6. Set `dev_mode` to `false` and send a test request.
7. Test on a real phone, and run Lighthouse in Chrome (speed and accessibility).
8. Delete `preview*.html` from the server, since they are only for double-click viewing.

## Privacy by design
No cookies, no analytics, no external fonts, maps, videos or chat. Fonts are in `assets/fonts/`. If you add Google Analytics, a map, YouTube or similar later, you need a cookie banner (Real Cookie Banner or Borlabs are made for German law).

## Next steps (not built yet)
Preise page with price calculator, Referenzen page, Über uns, Kontakt page, and the English version in `/en/` (copy `lang/de.php` to `lang/en.php`, set `$base = '../'`).

Photos: stand-ins from Pexels. Fonts: Barlow Condensed and Manrope (SIL Open Font License).

## Applying an update zip safely (never replace whole folders!)
An update zip contains only new or changed files. Merge them into your project, do not replace folders.
1. **Finder:** hold the **Option** key while dropping the folder. The dialog then offers **Merge**. Never choose **Replace** for a folder.
2. **Terminal (safest):** type `rsync -av ` then drag the unzipped inner `baden-website` folder into the window, add `/` at the end, a space, drag your own project folder in, add `/` at the end, press Enter. rsync only adds and overwrites files with the same name and never deletes anything. Add `-n` after `-av` first to preview.
3. **Git:** run `git init`, `git add .` and `git commit -m "before update"` before you start. After copying, `git status` shows what changed, and `git checkout .` undoes everything.

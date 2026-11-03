<?php
declare(strict_types=1);

/** Text sicher für HTML ausgeben (schützt vor eingeschleustem Code). */
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Pfad zu einer Datei im Ordner assets/. $base ist '' auf Hauptseiten und '../' in Unterordnern (z. B. en/). */
function asset(string $path): string
{
    global $base;
    return ($base ?? '') . 'assets/' . ltrim($path, '/');
}

/** Prüft, ob eine Datei in assets/ wirklich existiert (z. B. ein Foto, das noch fehlt). */
function has_asset(string $path): bool
{
    return is_file(__DIR__ . '/../assets/' . ltrim($path, '/'));
}

/** Ziel eines Menüpunkts. Anker (#kontakt) bleiben auf der Seite, wenn es den Abschnitt dort gibt – sonst führen sie zur Startseite. */
function page_href(string $key): string
{
    global $site, $page, $base;
    $href = $site['pages'][$key] ?? '#';
    if ($href !== '' && $href[0] === '#') {
        $local = !empty($page['home']) || in_array($key, $page['local'] ?? [], true);
        return $local ? $href : ($base ?? '') . 'index.php' . $href;
    }
    return ($base ?? '') . $href;
}

/** Einfache Linien-Icons (inline SVG, kein externer Dienst). */
function icon(string $name, int $size = 22): string
{
    static $paths = [
        'arrow'  => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'phone'  => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
        'chat'   => '<path d="M4 5h16v11H9l-5 4z"/>',
        'mail'   => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'pin'    => '<path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/>',
        'clock'  => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'left'   => '<path d="M15 5l-7 7 7 7"/>',
        'right'  => '<path d="M9 5l7 7-7 7"/>',
        'pause'  => '<path d="M9 5v14M15 5v14"/>',
        'play'   => '<path d="M8 5l11 7-11 7z"/>',
        'down'   => '<path d="M12 4v16M6 14l6 6 6-6"/>',
        'check'  => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'camera' => '<path d="M4 8h3l2-3h6l2 3h3v11H4z"/><circle cx="12" cy="13" r="3.5"/>',
        'swap'   => '<path d="M9 7l-5 5 5 5M15 7l5 5-5 5"/>',
    ];
    return '<svg class="icon" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
        . ($paths[$name] ?? '') . '</svg>';
}

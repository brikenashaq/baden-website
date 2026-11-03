<?php
declare(strict_types=1);

/**
 * Foto-Helfer für assets/img/leistungen/
 *
 * Was er tut:
 *  - verkleinert große Fotos auf höchstens 1600 Pixel an der langen Seite
 *  - speichert sie neu (Qualität 80) – dabei verschwinden GPS-/Kameradaten
 *  - wandelt .jpeg/.png/.webp-Dateien in .jpg um (nur .jpg wird von der Seite gefunden)
 *  - legt vorher eine Kopie des Originals in tools/originals/ ab
 *
 * Aufruf im Ordner baden-website:   php tools/optimize-photos.php
 * Benötigt PHP mit GD-Erweiterung (bei Homebrew-PHP ist sie dabei).
 */

if (!function_exists('imagecreatefromjpeg')) {
    fwrite(STDERR, "Die PHP-Erweiterung GD fehlt. Alternative: Fotos mit squoosh.app oder ImageOptim verkleinern.\n");
    exit(1);
}

$dir  = realpath(__DIR__ . '/../assets/img/leistungen');
$orig = __DIR__ . '/originals';
$max  = 1600;
$qual = 80;

if ($dir === false) {
    fwrite(STDERR, "Ordner assets/img/leistungen nicht gefunden.\n");
    exit(1);
}

function load_any(string $file)
{
    $info = @getimagesize($file);
    if ($info === false) {
        return null;
    }
    $im = match ($info[2]) {
        IMAGETYPE_JPEG => @imagecreatefromjpeg($file),
        IMAGETYPE_PNG  => @imagecreatefrompng($file),
        IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($file) : false,
        default        => false,
    };
    if ($im === false) {
        return null;
    }
    // Drehung laut Kamera (EXIF) berücksichtigen, damit Hochformat-Fotos nicht liegen
    if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {
        $exif = @exif_read_data($file);
        $o = (int) ($exif['Orientation'] ?? 1);
        $im = match ($o) { 3 => imagerotate($im, 180, 0), 6 => imagerotate($im, -90, 0), 8 => imagerotate($im, 90, 0), default => $im };
    }
    return $im;
}

function has_gps(string $file): bool
{
    if (!function_exists('exif_read_data')) {
        return false;
    }
    $exif = @exif_read_data($file, 'GPS');
    return is_array($exif) && !empty($exif['GPSLatitude']);
}

$files = array_merge(glob($dir . '/*.jpg') ?: [], glob($dir . '/*.jpeg') ?: [], glob($dir . '/*.JPG') ?: [], glob($dir . '/*.png') ?: [], glob($dir . '/*.webp') ?: []);
$done = 0;
$skipped = 0;

foreach ($files as $file) {
    $name = basename($file);
    $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $info = @getimagesize($file);
    if ($info === false) {
        echo "übersprungen (kein Bild): $name\n";
        continue;
    }
    [$w, $h] = $info;
    $needsWork = $ext !== 'jpg' || max($w, $h) > $max || has_gps($file);
    if (!$needsWork) {
        $skipped++;
        continue;
    }

    $im = load_any($file);
    if ($im === null) {
        echo "konnte nicht gelesen werden: $name\n";
        continue;
    }

    if (!is_dir($orig)) {
        mkdir($orig, 0775, true);
    }
    copy($file, $orig . '/' . $name);

    $w = imagesx($im);
    $h = imagesy($im);
    if (max($w, $h) > $max) {
        $scale = $max / max($w, $h);
        $im = imagescale($im, (int) round($w * $scale), (int) round($h * $scale), IMG_BICUBIC);
    }

    $target = $dir . '/' . pathinfo($file, PATHINFO_FILENAME) . '.jpg';
    imagejpeg($im, $target, $qual);          // neu gespeichert: keine GPS-/Kameradaten mehr
    imageinterlace($im, true);
    if ($ext !== 'jpg' && $target !== $file) {
        unlink($file);                       // das Original liegt in tools/originals/
    }
    printf("fertig: %s → %d × %d px, %d KB\n", $name, imagesx($im), imagesy($im), (int) round(filesize($target) / 1024));
    $done++;
}

echo "\n$done Foto(s) bearbeitet, $skipped waren schon in Ordnung.\n";

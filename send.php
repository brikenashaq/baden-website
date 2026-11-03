<?php
declare(strict_types=1);

/**
 * Kontaktformular – nimmt die Anfrage entgegen und schickt sie per E-Mail.
 * Schutz vor Spam ohne Google reCAPTCHA: verstecktes Feld (Honeypot) + Zeitprüfung.
 * Einstellungen (Empfänger, dev_mode) stehen in data/site.php.
 */

$site = require __DIR__ . '/data/site.php';

/** Seite, von der das Formular kam (nur diese Seiten sind erlaubt – verhindert fremde Weiterleitungen). */
$backPage = 'index.php';

function back(string $query = ''): never
{
    global $backPage;
    header('Location: ' . $backPage . ($query !== '' ? '?' . $query : '') . '#kontakt', true, 303);
    exit;
}

/** Text auf eine Höchstlänge kürzen (funktioniert mit und ohne mbstring, auch mit Umlauten). */
function cut(string $v, int $max): string
{
    if (function_exists('mb_substr')) {
        return mb_substr($v, 0, $max, 'UTF-8');
    }
    return preg_match('/^.{0,' . $max . '}/us', $v, $m) === 1 ? $m[0] : substr($v, 0, $max);
}

/** Betreff so kodieren, dass Umlaute in jedem Mailprogramm richtig ankommen. */
function mime_subject(string $s): string
{
    if (function_exists('mb_encode_mimeheader')) {
        return mb_encode_mimeheader($s, 'UTF-8');
    }
    return '=?UTF-8?B?' . base64_encode($s) . '?=';
}

function clean(string $v, int $max, bool $multiline = false): string
{
    $v = trim($v);
    $v = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $v) ?? '';
    if (!$multiline) {
        $v = trim(preg_replace('/[\r\n]+/', ' ', $v) ?? '');   // verhindert eingeschleuste Mail-Kopfzeilen
    }
    return cut($v, $max);
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    back();
}

$requested = (string) ($_POST['back'] ?? '');
if (in_array($requested, ['index.php', 'leistungen.php'], true)) {
    $backPage = $requested;
}

// 1) Spam-Schutz: Das versteckte Feld muss leer sein. Bots füllen es aus – denen tun wir so, als wäre alles gut.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    back('gesendet=1');
}

// 2) Zeitprüfung: Menschen brauchen mehr als 3 Sekunden fürs Ausfüllen.
$age = time() - (int) ($_POST['ts'] ?? 0);
if ($age < 3 || $age > 7 * 86400) {
    back('fehler=1');
}

// 3) Felder lesen und bereinigen
$name    = clean((string) ($_POST['name'] ?? ''), 120);
$phone   = clean((string) ($_POST['phone'] ?? ''), 40);
$email   = clean((string) ($_POST['email'] ?? ''), 160);
$place   = clean((string) ($_POST['place'] ?? ''), 120);
$service = clean((string) ($_POST['service'] ?? ''), 80);
$message = clean((string) ($_POST['message'] ?? ''), 3000, true);
$privacy = ($_POST['privacy'] ?? '') === '1';

// 4) Prüfen: Name, Datenschutz-Haken, und Telefon ODER E-Mail
$emailOk = $email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
if ($name === '' || !$privacy || ($phone === '' && $email === '') || !$emailOk) {
    back('fehler=1');
}

// 5) Nachricht zusammenbauen
$lines = [
    'Neue Anfrage über die Website',
    str_repeat('-', 40),
    'Name:      ' . $name,
    'Telefon:   ' . ($phone !== '' ? $phone : '-'),
    'E-Mail:    ' . ($email !== '' ? $email : '-'),
    'PLZ / Ort: ' . ($place !== '' ? $place : '-'),
    'Leistung:  ' . ($service !== '' ? $service : '-'),
    '',
    'Nachricht:',
    $message !== '' ? $message : '-',
    '',
    str_repeat('-', 40),
    'Datenschutz-Hinweis bestätigt am ' . date('d.m.Y H:i') . ' Uhr',
];
$body    = implode("\r\n", $lines);
$subject = 'Neue Anfrage: ' . ($service !== '' ? $service : 'Website') . ' – ' . $name;

// 6) Senden – oder im Testmodus nur in data/outbox.txt speichern
if (!empty($site['dev_mode'])) {
    $ok = file_put_contents(
        __DIR__ . '/data/outbox.txt',
        '=== ' . date('c') . " ===\r\nAn: " . $site['mail_to'] . "\r\nBetreff: " . $subject . "\r\n\r\n" . $body . "\r\n\r\n",
        FILE_APPEND | LOCK_EX
    ) !== false;
} else {
    $headers = [
        'From: ' . $site['mail_from'],
        'Content-Type: text/plain; charset=UTF-8',
        'MIME-Version: 1.0',
    ];
    if ($email !== '' && $emailOk) {
        $headers[] = 'Reply-To: ' . $email;
    }
    $ok = mail($site['mail_to'], mime_subject($subject), $body, implode("\r\n", $headers));
}

back($ok ? 'gesendet=1' : 'fehler=1');

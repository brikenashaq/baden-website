<?php
declare(strict_types=1);

$base = '';
$site = require __DIR__ . '/data/site.php';
$t    = require __DIR__ . '/lang/de.php';
require __DIR__ . '/partials/functions.php';

$page = ['title' => 'Datenschutzerklärung – ' . $site['name'], 'desc' => 'Datenschutzerklärung von ' . $site['name'], 'home' => false];
require __DIR__ . '/partials/header.php';
?>
<section class="legal">
  <div class="wrap">
    <h1>Datenschutzerklärung</h1>

    <p class="box"><strong>Entwurf – bitte vor dem Start ersetzen.</strong> Die rechtsverbindliche Datenschutzerklärung erstellen Sie mit einem Generator (z. B. eRecht24 oder Datenschutz-Generator.de) oder mit einem Anwalt. Verantwortlich ist der Betreiber der Website. Die folgende Liste zeigt, was diese Website technisch tut. Sie dient als Grundlage für den Generator.</p>

    <h2>Verantwortlicher</h2>
    <p>[FIRMENNAME], [ANSCHRIFT], <?= e($site['email_display']) ?>, <?= e($site['phone_display']) ?></p>

    <h2>Was diese Website technisch verarbeitet</h2>
    <ul>
      <li>Hosting bei [HOSTER, Standort Deutschland]; der Server speichert beim Aufruf technisch notwendige Zugriffsdaten (Log-Dateien). Mit dem Hoster ist ein Auftragsverarbeitungsvertrag (AVV) abzuschließen.</li>
      <li>Schriften (Barlow Condensed, Manrope) werden vom eigenen Server geladen, nicht von Google.</li>
      <li>Keine Cookies, keine Analyse- oder Werbedienste, keine eingebundenen Karten, Videos oder Chat-Widgets.</li>
      <li>Kontaktformular: Name, Telefon und/oder E-Mail, PLZ/Ort, gewünschte Leistung und Nachricht werden per E-Mail an den Betreiber gesendet, um die Anfrage zu bearbeiten. Rechtsgrundlage und Speicherdauer sind im Generator anzugeben.</li>
      <li>WhatsApp- und Telefon-Links öffnen erst nach einem Klick eine externe App oder einen externen Dienst.</li>
    </ul>

    <h2>Ihre Rechte</h2>
    <p>[Betroffenenrechte, Beschwerderecht bei der Aufsichtsbehörde usw. – aus dem Generator übernehmen]</p>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>

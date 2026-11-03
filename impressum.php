<?php
declare(strict_types=1);

$base = '';
$site = require __DIR__ . '/data/site.php';
$t    = require __DIR__ . '/lang/de.php';
require __DIR__ . '/partials/functions.php';

$page = ['title' => 'Impressum – ' . $site['name'], 'desc' => 'Impressum von ' . $site['name'], 'home' => false];
require __DIR__ . '/partials/header.php';
?>
<section class="legal">
  <div class="wrap">
    <h1>Impressum</h1>

    <p class="box"><strong>Entwurf – bitte vor dem Start ersetzen.</strong> Die Angaben müssen vollständig und richtig sein. Einen fertigen Text erzeugen z. B. eRecht24 oder der Datenschutz-Generator mit den Firmendaten des Kunden. Verantwortlich für den Inhalt ist der Betreiber der Website.</p>

    <h2>Angaben gemäß § 5 DDG</h2>
    <p>
      [FIRMENNAME mit Rechtsform]<br>
      [INHABER / GESCHÄFTSFÜHRER]<br>
      [STRASSE UND HAUSNUMMER – kein Postfach]<br>
      [PLZ ORT]
    </p>

    <h2>Kontakt</h2>
    <p>
      Telefon: <?= e($site['phone_display']) ?><br>
      E-Mail: <?= e($site['email_display']) ?>
    </p>

    <h2>Umsatzsteuer-ID</h2>
    <p>Umsatzsteuer-Identifikationsnummer nach § 27 a UStG: [USt-IdNr., falls vorhanden]</p>

    <h2>Registereintrag</h2>
    <p>[Registergericht und Registernummer, falls vorhanden]</p>
  </div>
</section>
<?php require __DIR__ . '/partials/footer.php'; ?>

<?php
declare(strict_types=1);

$base = '';
$site = require __DIR__ . '/data/site.php';
$t    = require __DIR__ . '/lang/de.php';
$L    = require __DIR__ . '/lang/de-leistungen.php';
require __DIR__ . '/partials/functions.php';

$page = [
    'title'   => $L['meta']['title'] . ' | ' . $site['region'],
    'desc'    => $L['meta']['description'],
    'home'    => false,
    'hero'    => true,                         // Header startet durchsichtig über dem Bild
    'current' => 'leistungen',                 // markierter Menüpunkt
    'local'   => ['kontakt'],                  // der Kontakt-Abschnitt liegt auf dieser Seite
    'css'     => ['css/leistungen.css'],
    'js'      => ['js/leistungen.js'],
];

$chapters = $L['chapters'];
$total    = count($chapters);
$pad      = static fn (int $n): string => str_pad((string) $n, 2, '0', STR_PAD_LEFT);

/**
 * Fotos eines Bereichs einsammeln – automatisch nach Dateinamen:
 *   stage-1.jpg          Titelfoto des Bereichs (zeigt den Bereich allgemein)
 *   01-1.jpg             Foto für die 1. Leistung in Bereich 01
 *   01-1b.jpg, 01-1c.jpg weitere Fotos derselben Leistung (b, c, d)
 *   01-2.jpg             Foto für die 2. Leistung in Bereich 01 … usw.
 * Fehlt eine Datei, wird sie einfach übersprungen.
 */
function chapter_slides(array $c): array
{
    $slides = [];
    if (has_asset('img/leistungen/' . $c['img'] . '.jpg')) {
        $slides[] = ['src' => 'img/leistungen/' . $c['img'] . '.jpg', 'service' => -1, 'label' => $c['rail'], 'alt' => $c['alt']];
    }
    foreach ($c['items'] as $si => $item) {
        foreach (['', 'b', 'c', 'd'] as $suffix) {
            $name = $c['num'] . '-' . ($si + 1) . $suffix;
            if (has_asset('img/leistungen/' . $name . '.jpg')) {
                $slides[] = ['src' => 'img/leistungen/' . $name . '.jpg', 'service' => $si, 'label' => $item, 'alt' => $item];
            }
        }
    }
    if (!$slides) {
        $slides[] = ['src' => null, 'service' => -1, 'label' => $c['rail'], 'alt' => $c['alt']];   // Platzhalter "Foto folgt"
    }
    return $slides;
}

$slidesByChapter = [];
foreach ($chapters as $n => $c) {
    $slidesByChapter[$n] = chapter_slides($c);
}

require __DIR__ . '/partials/header.php';
?>

<div class="scroll-progress" aria-hidden="true"><span></span></div>

<!-- ============ HERO: riesige Schrift, gefüllt mit den Fotos der Leistungen ============ -->
<section class="lhero" aria-labelledby="lhero-title">
  <svg class="lhero__roof" viewBox="0 0 400 300" aria-hidden="true" focusable="false"><polyline points="10,285 200,40 390,285" fill="none" stroke="#C99B5C" stroke-width="22"/><polyline points="90,290 200,170 310,290" fill="none" stroke="#C99B5C" stroke-width="14"/></svg>

  <div class="wrap lhero__inner">
    <span class="eyebrow eyebrow--gold"><?= e($L['hero']['eyebrow']) ?></span>
    <h1 class="lhero__word" id="lhero-title"><span><?= e($L['hero']['word']) ?></span></h1>
    <p class="lhero__sub"><?= e($L['hero']['sub']) ?></p>

    <ul class="lhero__stats">
      <?php foreach ($L['hero']['stats'] as [$num, $label]): ?>
        <li><b data-count="<?= (int) $num ?>"><?= (int) $num ?></b><span><?= e($label) ?></span></li>
      <?php endforeach; ?>
      <li class="lhero__tag"><span><?= e($L['hero']['tag']) ?></span></li>
    </ul>
  </div>

  <a class="lhero__scroll" href="#bereiche"><span><?= e($L['hero']['scroll']) ?></span> <?= icon('down', 20) ?></a>
</section>

<!-- ============ BEREICHE: links ein Foto, das beim Scrollen wechselt – rechts die Leistungen ============ -->
<section class="chapters" id="bereiche">

  <div class="stage">
    <div class="stage__imgs" aria-hidden="true">
      <?php foreach ($slidesByChapter as $n => $list): ?>
        <?php foreach ($list as $k => $sl): $isFirst = ($n === 0 && $k === 0); ?>
          <div class="stage__img<?= $isFirst ? ' is-active' : '' ?>" data-chapter="<?= $n ?>" data-service="<?= (int) $sl['service'] ?>" data-label="<?= e($sl['label']) ?>">
            <?php if ($sl['src']): ?>
              <img <?= $isFirst ? 'src="' . e(asset($sl['src'])) . '" fetchpriority="high"' : 'data-src="' . e(asset($sl['src'])) . '"' ?> alt="" width="1200" height="1500">
            <?php else: ?>
              <div class="stage__empty"><?= icon('camera', 56) ?><span><?= e($L['photo_missing']) ?></span></div>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endforeach; ?>
      <div class="stage__num"><span><?= e($chapters[0]['num']) ?></span></div>
      <div class="stage__meta"><div class="stage__cap"></div><div class="stage__dots" data-chapter="-1"></div></div>
    </div>

    <nav class="stage__rail" aria-label="<?= e($L['rail_label']) ?>">
      <ol>
        <?php foreach ($chapters as $n => $c): ?>
          <li>
            <button class="rail__btn" type="button" data-target="bereich-<?= $n + 1 ?>"<?= $n === 0 ? ' aria-current="true"' : '' ?> aria-label="<?= e($L['goto'] . ' ' . $c['num'] . ': ' . $c['rail']) ?>">
              <span class="rail__name"><?= e($c['rail']) ?></span><span class="rail__no"><?= e($c['num']) ?></span>
            </button>
          </li>
        <?php endforeach; ?>
      </ol>
    </nav>
  </div>

  <div class="chapter-list">
    <?php foreach ($chapters as $n => $c): ?>
      <article class="chapter" id="bereich-<?= $n + 1 ?>" data-num="<?= e($c['num']) ?>">

        <!-- Fotos nur auf dem Handy (am Computer zeigt die Bühne links die Fotos) -->
        <figure class="chapter__photo" data-chapter="<?= $n ?>">
          <?php foreach ($slidesByChapter[$n] as $k => $sl): ?>
            <div class="cp__slide<?= $k === 0 ? ' is-active' : '' ?>" data-service="<?= (int) $sl['service'] ?>">
              <?php if ($sl['src']): ?>
                <img src="<?= e(asset($sl['src'])) ?>" alt="<?= e($sl['alt']) ?>" width="1200" height="1500" loading="lazy">
              <?php else: ?>
                <div class="stage__empty"><?= icon('camera', 44) ?><span><?= e($L['photo_missing']) ?></span></div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
          <b aria-hidden="true"><?= e($c['num']) ?></b>
        </figure>

        <div class="chapter__inner">
          <p class="chapter__kicker"><?= e($c['num']) ?> / <?= $pad($total) ?></p>
          <h2 class="chapter__title"><?= e($c['t1']) ?><small><?= e($c['t2']) ?></small></h2>
          <p class="chapter__lead reveal" style="--d:.05s"><?= e($c['lead']) ?></p>

          <ul class="chapter__list reveal" style="--d:.12s">
            <?php foreach ($c['items'] as $item): ?>
              <li><?= e($item) ?></li>
            <?php endforeach; ?>
          </ul>

          <div class="chapter__foot reveal" style="--d:.18s">
            <div class="chapter__price"><b><?= e($L['price']) ?></b><small><?= e($L['vat']) ?></small></div>
            <a class="btn" href="#kontakt" data-service="<?= e($c['service']) ?>"><?= e($t['cta']) ?> <?= icon('arrow', 20) ?></a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<!-- ============ BAND: das Versprechen läuft durchs Bild ============ -->
<div class="band" aria-hidden="true">
  <div class="band__track">
    <?php for ($half = 0; $half < 2; $half++): ?>
      <?php for ($i = 0; $i < 3; $i++): ?>
        <div class="band__item"><span class="fill"><?= e($t['footer']['slogan']) ?></span><svg width="34" height="34" viewBox="0 0 30 30"><polygon points="15,2 28,15 15,28 2,15" fill="#C99B5C"/></svg><span class="out"><?= e($t['footer']['slogan']) ?></span><svg width="34" height="34" viewBox="0 0 30 30"><polygon points="15,2 28,15 15,28 2,15" fill="#C99B5C"/></svg></div>
      <?php endfor; ?>
    <?php endfor; ?>
  </div>
</div>

<!-- ============ ABSCHLUSS in Gold ============ -->
<section class="closing">
  <div class="wrap closing__grid">
    <h2 class="reveal"><?= e($L['closing']['title']) ?></h2>
    <div class="reveal" style="--d:.12s">
      <p><?= e($L['closing']['text']) ?></p>
      <div class="closing__actions">
        <a class="btn btn--dark" href="tel:<?= e($site['phone_href']) ?>"><?= icon('phone', 20) ?> <?= e($L['closing']['call']) ?></a>
        <a class="btn btn--outline-dark" href="https://wa.me/<?= e($site['whatsapp_href']) ?>" rel="noopener"><?= icon('chat', 20) ?> <?= e($L['closing']['wa']) ?></a>
        <a class="btn btn--outline-dark" href="#kontakt"><?= e($L['closing']['form']) ?> <?= icon('arrow', 20) ?></a>
      </div>
    </div>
  </div>
</section>

<?php if (isset($_GET['fotos'])): ?>
<!-- Foto-Übersicht: nur sichtbar, wenn ?fotos an die Adresse angehängt wird (zum Arbeiten, nicht für Besucher) -->
<aside class="photo-check">
  <strong>Foto-Übersicht (Dateien in assets/img/leistungen/)</strong>
  <ul>
    <?php foreach ($chapters as $c): ?>
      <li class="photo-check__area"><?= e($c['num']) ?> <?= e($c['rail']) ?> – <?= has_asset('img/leistungen/' . $c['img'] . '.jpg') ? '<span class="ok">✓</span>' : '<span class="no">✗</span>' ?> <?= e($c['img']) ?>.jpg (Titelfoto)</li>
      <?php foreach ($c['items'] as $si => $item): $name = $c['num'] . '-' . ($si + 1); ?>
        <li><?= has_asset('img/leistungen/' . $name . '.jpg') ? '<span class="ok">✓</span>' : '<span class="no">✗</span>' ?> <?= e($name) ?>.jpg – <?= e($item) ?></li>
      <?php endforeach; ?>
    <?php endforeach; ?>
  </ul>
</aside>
<?php endif; ?>

<?php $backPage = 'leistungen.php'; require __DIR__ . '/partials/contact.php'; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>

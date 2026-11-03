<?php
declare(strict_types=1);

$base = '';                                   // '' auf Hauptseiten, '../' in Unterordnern (z. B. en/)
$site = require __DIR__ . '/data/site.php';   // Firmendaten
$t    = require __DIR__ . '/lang/de.php';     // Texte
require __DIR__ . '/partials/functions.php';

$page = [
    'title' => $t['meta']['title'],
    'desc'  => $t['meta']['description'],
    'home'  => true,
];

$slides  = $t['hero']['slides'];
$total   = count($slides);
$showBA  = has_asset('img/referenzen/vorher-1.jpg') && has_asset('img/referenzen/nachher-1.jpg');

require __DIR__ . '/partials/header.php';
?>

<!-- ============ HERO: Fotos blenden automatisch ineinander über ============ -->
<section class="hero" id="hero" aria-roledescription="carousel" aria-label="<?= e($t['hero']['label']) ?>" style="--hero-dur:6.5s">
  <h1 class="sr-only"><?= e($t['hero']['h1']) ?></h1>

  <div class="hero__slides">
    <?php foreach ($slides as $i => $s): ?>
      <div class="hero__slide<?= $i === 0 ? ' is-active' : '' ?>" role="group" aria-roledescription="<?= e($t['hero']['slide']) ?>" aria-label="<?= $i + 1 ?> <?= e($t['hero']['of']) ?> <?= $total ?>" style="--shade:<?= e((string) $s['shade']) ?>">
        <img
          src="<?= e(asset('img/hero/' . $s['img'] . '.jpg')) ?>"
          srcset="<?= e(asset('img/hero/' . $s['img'] . '-1200.jpg')) ?> 1200w, <?= e(asset('img/hero/' . $s['img'] . '.jpg')) ?> 1920w"
          sizes="100vw" alt="<?= e($s['alt']) ?>" width="1920" height="1280"
          style="object-position:<?= e($s['pos']) ?>"
          <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="hero__shade" aria-hidden="true"></div>

  <div class="wrap hero__content">
    <?php foreach ($slides as $i => $s): ?>
      <div class="hero__text<?= $i === 0 ? ' is-active' : '' ?>"<?= $i === 0 ? '' : ' inert aria-hidden="true"' ?>>
        <p class="hero__title">
          <span class="line"><?= e($s['line1']) ?></span>
          <span class="line line--gold"><?= e($s['line2']) ?></span>
        </p>
        <p class="hero__sub"><?= e($s['sub']) ?></p>
        <div class="hero__actions">
          <a class="btn" href="#kontakt"><?= e($t['cta']) ?> <?= icon('arrow', 20) ?></a>
          <a class="btn btn--ghost" href="#leistungen"><?= e($t['hero']['secondary']) ?></a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <button class="hero__nav hero__nav--prev" type="button" aria-label="<?= e($t['hero']['prev']) ?>"><?= icon('left', 26) ?></button>
  <button class="hero__nav hero__nav--next" type="button" aria-label="<?= e($t['hero']['next']) ?>"><?= icon('right', 26) ?></button>

  <div class="hero__bottom">
    <div class="wrap hero__bottom-inner">
      <div class="hero__counter" aria-hidden="true">
        <span class="hero__current">01</span><span class="hero__total">/ <?= str_pad((string) $total, 2, '0', STR_PAD_LEFT) ?></span>
      </div>
      <button class="hero__play" type="button" aria-label="<?= e($t['hero']['pause']) ?>"
              data-label-pause="<?= e($t['hero']['pause']) ?>" data-label-play="<?= e($t['hero']['play']) ?>">
        <span class="hero__play-pause"><?= icon('pause', 20) ?></span>
        <span class="hero__play-play"><?= icon('play', 20) ?></span>
      </button>
      <a class="hero__scroll" href="#ueber-uns"><span><?= e($t['hero']['scroll']) ?></span> <?= icon('down', 20) ?></a>
    </div>
  </div>
  <div class="hero__progress" aria-hidden="true"><span></span></div>
</section>

<!-- ============ ÜBER BADEN ============ -->
<section class="section intro" id="ueber-uns">
  <div class="wrap intro__grid">
    <div class="reveal">
      <span class="eyebrow"><?= e($t['intro']['eyebrow']) ?></span>
      <h2 class="display h2"><?= e($t['intro']['title']) ?></h2>
      <p class="lead"><?= e($t['intro']['text']) ?></p>
      <p><?= e($t['intro']['text2']) ?></p>
    </div>
    <div class="stat reveal" style="--d:.15s">
      <div class="stat__num"><?= e($t['intro']['stat_num']) ?></div>
      <div class="stat__text"><?= e($t['intro']['stat_text']) ?></div>
    </div>
  </div>
</section>

<!-- ============ LEISTUNGEN ============ -->
<section class="section services" id="leistungen">
  <div class="wrap">
    <div class="section-head reveal">
      <div>
        <span class="eyebrow"><?= e($t['services']['eyebrow']) ?></span>
        <h2 class="display h2"><?= e($t['services']['title']) ?></h2>
      </div>
      <p class="lead section-head__lead"><?= e($t['services']['lead']) ?></p>
    </div>

    <ul class="cards">
      <?php foreach ($t['services']['cards'] as $n => $c): ?>
        <li class="card reveal" style="--d:<?= ($n % 3) * 0.1 ?>s">
          <div class="card__media">
            <?php if (has_asset('img/cards/' . $c['img'] . '.jpg')): ?>
              <img src="<?= e(asset('img/cards/' . $c['img'] . '.jpg')) ?>" alt="<?= e($c['alt']) ?>" width="1200" height="800" loading="lazy">
            <?php else: ?>
              <div class="card__placeholder"><?= icon('camera', 40) ?><span><?= e($t['services']['photo_missing']) ?></span></div>
            <?php endif; ?>
            <span class="card__num" aria-hidden="true"><?= str_pad((string) ($n + 1), 2, '0', STR_PAD_LEFT) ?></span>
          </div>
          <div class="card__body">
            <h3 class="card__title"><?= e($c['title']) ?></h3>
            <p class="card__text"><?= e($c['text']) ?></p>
            <?php
              $lp = $site['pages']['leistungen'] ?? '#leistungen';
              $cardHref = ($lp !== '' && $lp[0] !== '#') ? $lp . '#bereich-' . ($n + 1) : '#kontakt';
              $cardText = ($lp !== '' && $lp[0] !== '#') ? ($t['services']['more'] ?? 'Mehr erfahren') : $t['services']['link'];
            ?>
            <a class="card__link" href="<?= e($cardHref) ?>"><span><?= e($cardText) ?></span> <?= icon('arrow', 20) ?></a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

    <details class="all reveal">
      <summary><?= e($t['services']['all_title']) ?></summary>
      <div class="all__grid">
        <?php foreach ($t['services']['all'] as [$group, $items]): ?>
          <div>
            <h3><?= e($group) ?></h3>
            <ul>
              <?php foreach ($items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </details>
  </div>
</section>

<?php if ($showBA): ?>
<!-- ============ VORHER / NACHHER (erscheint, sobald echte Fotos vorhanden sind) ============ -->
<section class="section beforeafter" id="referenzen">
  <div class="wrap beforeafter__grid">
    <div class="reveal">
      <span class="eyebrow"><?= e($t['beforeafter']['eyebrow']) ?></span>
      <h2 class="display h2"><?= e($t['beforeafter']['title']) ?></h2>
      <p class="lead"><?= e($t['beforeafter']['text']) ?></p>
      <a class="btn btn--dark" href="#kontakt"><?= e($t['cta']) ?> <?= icon('arrow', 20) ?></a>
    </div>
    <div class="ba reveal" style="--pos:50%; --d:.15s">
      <img class="ba__img" src="<?= e(asset('img/referenzen/vorher-1.jpg')) ?>" alt="<?= e($t['beforeafter']['alt_before']) ?>" loading="lazy">
      <img class="ba__img ba__img--after" src="<?= e(asset('img/referenzen/nachher-1.jpg')) ?>" alt="<?= e($t['beforeafter']['alt_after']) ?>" loading="lazy">
      <span class="ba__tag ba__tag--before"><?= e($t['beforeafter']['before']) ?></span>
      <span class="ba__tag ba__tag--after"><?= e($t['beforeafter']['after']) ?></span>
      <div class="ba__handle" aria-hidden="true"><span><?= icon('swap', 24) ?></span></div>
      <input class="ba__range" type="range" min="0" max="100" value="50" aria-label="<?= e($t['beforeafter']['label']) ?>">
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ WARUM BADEN ============ -->
<section class="section why" id="warum">
  <div class="wrap">
    <div class="reveal">
      <span class="eyebrow eyebrow--gold"><?= e($t['why']['eyebrow']) ?></span>
      <h2 class="display h2"><?= e($t['why']['title']) ?></h2>
    </div>
    <div class="why__grid">
      <?php foreach ($t['why']['items'] as $n => [$title, $text]): ?>
        <div class="why__item reveal" style="--d:<?= $n * 0.08 ?>s">
          <div class="why__num"><?= str_pad((string) ($n + 1), 2, '0', STR_PAD_LEFT) ?></div>
          <h3 class="why__title"><?= e($title) ?></h3>
          <p class="why__text"><?= e($text) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ ABLAUF ============ -->
<section class="section steps" id="ablauf">
  <div class="wrap">
    <div class="reveal">
      <span class="eyebrow"><?= e($t['steps']['eyebrow']) ?></span>
      <h2 class="display h2"><?= e($t['steps']['title']) ?></h2>
    </div>
    <ol class="steps__list">
      <?php foreach ($t['steps']['items'] as $n => [$title, $text]): ?>
        <li class="step reveal" style="--d:<?= $n * 0.08 ?>s">
          <div class="step__no" aria-hidden="true"><?= $n + 1 ?></div>
          <h3 class="step__title"><?= e($title) ?></h3>
          <p><?= e($text) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<?php $backPage = 'index.php'; require __DIR__ . '/partials/contact.php'; ?>

<?php require __DIR__ . '/partials/footer.php'; ?>

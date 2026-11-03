<?php
/** Erwartet: $site, $t, $page ['title','desc','home'], $base */
$homePage = !empty($page['home']);
$hasHero  = $homePage || !empty($page['hero']);                 // Seiten mit großem Bild oben: Header startet durchsichtig
$current  = $page['current'] ?? ($homePage ? 'home' : '');      // markierter Menüpunkt
$phoneHeader = $site['phone_header'] ?? $site['phone_display']; // im Header nur eine Nummer
?><!doctype html>
<html lang="<?= e($t['lang']) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page['title']) ?></title>
  <meta name="description" content="<?= e($page['desc']) ?>">
  <?php if (!empty($page['noindex'])): ?><meta name="robots" content="noindex, follow"><?php endif; ?>
  <meta name="theme-color" content="#24332C">
  <meta property="og:title" content="<?= e($page['title']) ?>">
  <meta property="og:description" content="<?= e($page['desc']) ?>">
  <meta property="og:type" content="website">
  <link rel="icon" type="image/png" href="<?= e(asset('img/logo/favicon.png')) ?>">
  <link rel="preload" href="<?= e(asset('fonts/barlow-condensed-latin-800-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?= e(asset('fonts/manrope-latin-400-normal.woff2')) ?>" as="font" type="font/woff2" crossorigin>
  <?php if ($homePage): ?>
  <link rel="preload" as="image" href="<?= e(asset('img/hero/hero-1.jpg')) ?>" imagesrcset="<?= e(asset('img/hero/hero-1-1200.jpg')) ?> 1200w, <?= e(asset('img/hero/hero-1.jpg')) ?> 1920w" imagesizes="100vw" fetchpriority="high">
  <?php endif; ?>
  <link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
  <?php foreach (($page['css'] ?? []) as $extraCss): ?>
  <link rel="stylesheet" href="<?= e(asset($extraCss)) ?>">
  <?php endforeach; ?>
  <script>document.documentElement.classList.add('js');</script>
</head>
<body class="<?= $hasHero ? 'is-home' : 'no-hero' ?>">
<a class="skip-link" href="#main"><?= e($t['skip']) ?></a>

<header class="site-header<?= $hasHero ? '' : ' is-solid' ?>" id="top">
  <div class="wrap header-inner">
    <a class="brand" href="<?= e(page_href('home')) ?>" aria-label="<?= e($site['name']) ?>">
      <img class="brand__mark" src="<?= e(asset('img/logo/logo-mark.png')) ?>" alt="" width="397" height="264">
      <span class="brand__text">
        <span class="brand__name">Baden</span>
        <span class="brand__sub">Hausmeisterservice</span>
      </span>
    </a>

    <nav class="main-nav" aria-label="Hauptmenü">
      <ul>
        <?php foreach ($t['nav'] as [$label, $key]): ?>
          <li><a href="<?= e(page_href($key)) ?>"<?= ($key === $current) ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="header-actions">
      <a class="header-phone" href="tel:<?= e($site['phone_href']) ?>"><?= e($phoneHeader) ?></a>
      <a class="btn btn--sm" href="<?= e(page_href('kontakt')) ?>"><?= e($t['cta']) ?></a>
      <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="mobile-menu">
        <span class="sr-only"><?= e($t['menu']) ?></span>
        <span class="nav-toggle__bars" aria-hidden="true"></span>
      </button>
    </div>
  </div>
</header>

<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <ul>
    <?php foreach ($t['nav'] as [$label, $key]): ?>
      <li><a href="<?= e(page_href($key)) ?>"><?= e($label) ?></a></li>
    <?php endforeach; ?>
  </ul>
  <div class="mobile-menu__foot">
    <a class="mobile-menu__phone" href="tel:<?= e($site['phone_href']) ?>"><?= icon('phone', 26) ?> <?= e($phoneHeader) ?></a>
    <a class="btn" href="<?= e(page_href('kontakt')) ?>"><?= e($t['cta']) ?> <?= icon('arrow', 20) ?></a>
  </div>
</div>

<main id="main">

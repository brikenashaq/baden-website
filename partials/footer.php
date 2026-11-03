</main>

<footer class="site-footer">
  <div class="wrap">
    <div class="footer__grid">
      <div class="footer__brand">
        <img class="footer__logo" src="<?= e(asset('img/logo/logo-full.png')) ?>" alt="<?= e($site['name']) ?>" width="435" height="445" loading="lazy">
        <p class="footer__slogan"><?= e($t['footer']['slogan']) ?></p>
      </div>

      <div>
        <h2 class="footer__h"><?= e($t['footer']['services']) ?></h2>
        <ul class="footer__list">
          <?php foreach ($t['footer']['links'] as $label): ?>
            <li><a href="<?= e(page_href('leistungen')) ?>"><?= e($label) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="footer__h"><?= e($t['footer']['contact']) ?></h2>
        <ul class="footer__list">
          <li><a href="tel:<?= e($site['phone_href']) ?>"><?= e($site['phone_display']) ?></a></li>
          <li><a href="mailto:<?= e($site['email_href']) ?>"><?= e($site['email_display']) ?></a></li>
          <li><?= e($site['address']) ?></li>
          <li><?= e($site['hours']) ?></li>
        </ul>
      </div>

      <div>
        <h2 class="footer__h"><?= e($t['footer']['legal']) ?></h2>
        <ul class="footer__list">
          <li><a href="<?= e(page_href('impressum')) ?>"><?= e($t['footer']['imprint']) ?></a></li>
          <li><a href="<?= e(page_href('datenschutz')) ?>"><?= e($t['footer']['privacy']) ?></a></li>
        </ul>
      </div>
    </div>

    <div class="footer__bottom">
      <span>© <?= date('Y') ?> <?= e($site['name']) ?></span>
      <span><?= e($t['footer']['vat']) ?></span>
    </div>
  </div>
</footer>

<div class="mobile-bar">
  <a href="tel:<?= e($site['phone_href']) ?>"><?= icon('phone', 22) ?> <?= e($t['mobilebar']['call']) ?></a>
  <a href="https://wa.me/<?= e($site['whatsapp_href']) ?>" rel="noopener"><?= icon('chat', 22) ?> <?= e($t['mobilebar']['wa']) ?></a>
</div>

<script src="<?= e(asset('js/main.js')) ?>" defer></script>
<?php foreach (($page['js'] ?? []) as $extraJs): ?>
<script src="<?= e(asset($extraJs)) ?>" defer></script>
<?php endforeach; ?>
</body>
</html>

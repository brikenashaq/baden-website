<?php
/**
 * Kontakt-Abschnitt mit Formular – wird auf der Startseite und auf der Leistungen-Seite verwendet.
 * Erwartet: $site, $t. Optional: $backPage (Seite, auf die nach dem Senden zurückgeleitet wird).
 */
$status   = isset($_GET['gesendet']) ? 'ok' : (isset($_GET['fehler']) ? 'error' : '');
$backPage = $backPage ?? 'index.php';
?>
<!-- ============ KONTAKT ============ -->
<section class="section contact" id="kontakt">
  <div class="wrap">
    <div class="contact__panel reveal">
      <div class="contact__info">
        <span class="eyebrow eyebrow--gold"><?= e($t['contact']['eyebrow']) ?></span>
        <h2 class="display h2"><?= e($t['contact']['title']) ?></h2>
        <p class="contact__text"><?= e($t['contact']['text']) ?></p>
        <ul class="contact__list">
          <li class="contact__item">
            <span class="contact__icon"><?= icon('phone', 24) ?></span>
            <span><span class="contact__label"><?= e($t['contact']['phone']) ?></span><a class="contact__value" href="tel:<?= e($site['phone_href']) ?>"><?= e($site['phone_display']) ?></a></span>
          </li>
          <li class="contact__item">
            <span class="contact__icon"><?= icon('chat', 24) ?></span>
            <span><span class="contact__label"><?= e($t['contact']['whatsapp']) ?></span><a class="contact__value" href="https://wa.me/<?= e($site['whatsapp_href']) ?>" rel="noopener"><?= e($site['whatsapp_display']) ?></a></span>
          </li>
          <li class="contact__item">
            <span class="contact__icon"><?= icon('mail', 24) ?></span>
            <span><span class="contact__label"><?= e($t['contact']['email']) ?></span><a class="contact__value" href="mailto:<?= e($site['email_href']) ?>"><?= e($site['email_display']) ?></a></span>
          </li>
          <li class="contact__item">
            <span class="contact__icon"><?= icon('pin', 24) ?></span>
            <span><span class="contact__label"><?= e($t['contact']['area']) ?></span><span class="contact__value"><?= e($site['region']) ?></span></span>
          </li>
          <li class="contact__item">
            <span class="contact__icon"><?= icon('clock', 24) ?></span>
            <span><span class="contact__label"><?= e($t['contact']['hours']) ?></span><span class="contact__value"><?= e($site['hours']) ?></span></span>
          </li>
        </ul>
      </div>

      <form class="form" action="send.php" method="post" novalidate>
        <h3><?= e($t['contact']['form_title']) ?></h3>

        <?php if ($status === 'ok'): ?>
          <p class="notice notice--ok" role="status"><?= e($t['contact']['ok']) ?></p>
        <?php elseif ($status === 'error'): ?>
          <p class="notice notice--error" role="alert"><?= e($t['contact']['error']) ?></p>
        <?php endif; ?>

        <div class="form__grid">
          <div class="field">
            <label for="f-name"><?= e($t['contact']['name']) ?> *</label>
            <input id="f-name" name="name" type="text" autocomplete="name" placeholder="<?= e($t['contact']['name_ph']) ?>" required maxlength="120">
          </div>
          <div class="field">
            <label for="f-tel"><?= e($t['contact']['tel']) ?></label>
            <input id="f-tel" name="phone" type="tel" autocomplete="tel" placeholder="<?= e($t['contact']['tel_ph']) ?>" maxlength="40">
          </div>
          <div class="field">
            <label for="f-mail"><?= e($t['contact']['mail']) ?></label>
            <input id="f-mail" name="email" type="email" autocomplete="email" placeholder="<?= e($t['contact']['mail_ph']) ?>" maxlength="160">
          </div>
          <div class="field">
            <label for="f-place"><?= e($t['contact']['place']) ?></label>
            <input id="f-place" name="place" type="text" autocomplete="postal-code" placeholder="<?= e($t['contact']['place_ph']) ?>" maxlength="120">
          </div>
          <div class="field field--full">
            <label for="f-service"><?= e($t['contact']['service']) ?></label>
            <select id="f-service" name="service">
              <option value=""><?= e($t['contact']['service_ph']) ?></option>
              <?php foreach ($t['contact']['services'] as $opt): ?>
                <option value="<?= e($opt) ?>"><?= e($opt) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="field field--full">
            <label for="f-msg"><?= e($t['contact']['message']) ?></label>
            <textarea id="f-msg" name="message" placeholder="<?= e($t['contact']['message_ph']) ?>" maxlength="3000"></textarea>
          </div>
          <div class="field field--full hp" aria-hidden="true">
            <label for="f-web">Website</label>
            <input id="f-web" name="website" type="text" tabindex="-1" autocomplete="off">
          </div>
          <input type="hidden" name="ts" value="<?= time() ?>">
          <input type="hidden" name="back" value="<?= e($backPage) ?>">
          <div class="field field--full check">
            <input id="f-privacy" name="privacy" type="checkbox" value="1" required>
            <label for="f-privacy"><?= e($t['contact']['privacy_pre']) ?><a href="<?= e(page_href('datenschutz')) ?>"><?= e($t['contact']['privacy_link']) ?></a><?= e($t['contact']['privacy_post']) ?></label>
          </div>
        </div>
        <button class="btn btn--block" type="submit"><?= e($t['contact']['submit']) ?> <?= icon('arrow', 20) ?></button>
      </form>
    </div>
  </div>
</section>

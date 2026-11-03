/* =====================================================================
   BADEN Hausmeisterservice – Scripts (ohne Bibliotheken, ohne externe Dienste)
   ===================================================================== */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var body = document.body;

  /* ---------- Header: wird beim Scrollen dunkelgrün ---------- */
  var header = document.querySelector('.site-header');
  if (header && !header.classList.contains('is-solid')) {
    var onScroll = function () {
      header.classList.toggle('is-solid', window.scrollY > 40);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ---------- Mobiles Menü ---------- */
  var toggle = document.querySelector('.nav-toggle');
  var menu = document.getElementById('mobile-menu');
  if (toggle && menu) {
    var setMenu = function (open) {
      body.classList.toggle('menu-open', open);
      toggle.setAttribute('aria-expanded', String(open));
      menu.setAttribute('aria-hidden', String(!open));
      if (open) { var first = menu.querySelector('a'); if (first) first.focus(); }
    };
    toggle.addEventListener('click', function () {
      setMenu(!body.classList.contains('menu-open'));
    });
    menu.addEventListener('click', function (e) {
      if (e.target.closest('a')) setMenu(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && body.classList.contains('menu-open')) { setMenu(false); toggle.focus(); }
    });
    window.addEventListener('resize', function () {
      if (window.innerWidth > 1020 && body.classList.contains('menu-open')) setMenu(false);
    });
  }

  /* ---------- Hero-Slideshow ---------- */
  var hero = document.getElementById('hero');
  if (hero) {
    var slides = Array.prototype.slice.call(hero.querySelectorAll('.hero__slide'));
    var texts = Array.prototype.slice.call(hero.querySelectorAll('.hero__text'));
    var current = hero.querySelector('.hero__current');
    var bar = hero.querySelector('.hero__progress span');
    var prev = hero.querySelector('.hero__nav--prev');
    var next = hero.querySelector('.hero__nav--next');
    var playBtn = hero.querySelector('.hero__play');
    var idx = 0;
    var userStopped = reduceMotion;   // wer weniger Bewegung wünscht, bekommt keine Automatik

    var restartBar = function () {
      if (!bar) return;
      bar.style.animation = 'none';
      void bar.offsetWidth;           // Neustart der Animation erzwingen
      bar.style.animation = '';
    };

    var go = function (n) {
      idx = (n + slides.length) % slides.length;
      slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); });
      texts.forEach(function (t, i) {
        var active = i === idx;
        t.classList.toggle('is-active', active);
        if (active) { t.removeAttribute('inert'); t.removeAttribute('aria-hidden'); }
        else { t.setAttribute('inert', ''); t.setAttribute('aria-hidden', 'true'); }
      });
      if (current) current.textContent = (idx + 1 < 10 ? '0' : '') + (idx + 1);
      restartBar();
    };

    var setPlaying = function (play) {
      userStopped = !play;
      hero.classList.toggle('is-stopped', userStopped);
      if (playBtn) {
        playBtn.setAttribute('aria-label', playBtn.getAttribute(play ? 'data-label-pause' : 'data-label-play'));
      }
      if (play) restartBar();
    };

    // Die Fortschrittsleiste steuert den Wechsel: ist sie voll, kommt das nächste Foto.
    if (bar) {
      bar.addEventListener('animationend', function () {
        if (!userStopped) go(idx + 1);
      });
    }

    if (prev) prev.addEventListener('click', function () { go(idx - 1); });
    if (next) next.addEventListener('click', function () { go(idx + 1); });
    if (playBtn) playBtn.addEventListener('click', function () { setPlaying(userStopped); });

    // Anhalten bei Mauszeiger, Tastaturfokus oder wenn der Tab nicht sichtbar ist
    var pause = function (on) { hero.classList.toggle('is-paused', on); };
    hero.addEventListener('mouseenter', function () { pause(true); });
    hero.addEventListener('mouseleave', function () { pause(false); });
    hero.addEventListener('focusin', function () { pause(true); });
    hero.addEventListener('focusout', function () { pause(false); });
    document.addEventListener('visibilitychange', function () { pause(document.hidden); });

    // Pfeiltasten
    hero.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') { go(idx - 1); }
      if (e.key === 'ArrowRight') { go(idx + 1); }
    });

    // Wischen auf dem Handy
    var startX = null;
    hero.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    hero.addEventListener('touchend', function (e) {
      if (startX === null) return;
      var dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 50) go(idx + (dx < 0 ? 1 : -1));
      startX = null;
    }, { passive: true });

    setPlaying(!userStopped);
  }

  /* ---------- Elemente blenden beim Scrollen ein ---------- */
  var reveals = Array.prototype.slice.call(document.querySelectorAll('.reveal'));
  if (reveals.length) {
    var settle = function (el) {
      // Nach dem Einblenden die Klassen entfernen, damit Hover-Effekte (z. B. bei Karten) wieder normal laufen
      setTimeout(function () { el.classList.remove('reveal', 'is-in'); }, 1300);
    };
    if ('IntersectionObserver' in window && !reduceMotion) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { en.target.classList.add('is-in'); settle(en.target); io.unobserve(en.target); }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
      reveals.forEach(function (el) { io.observe(el); });
    } else {
      reveals.forEach(function (el) { el.classList.add('is-in'); });
    }
  }

  /* ---------- Vorher/Nachher-Regler ---------- */
  Array.prototype.forEach.call(document.querySelectorAll('.ba'), function (ba) {
    var range = ba.querySelector('.ba__range');
    if (!range) return;
    var update = function () { ba.style.setProperty('--pos', range.value + '%'); };
    range.addEventListener('input', update);
    update();
  });
})();

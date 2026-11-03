/* =====================================================================
   Seite "Leistungen" – Scripts (ohne Bibliotheken)
   - Fotos wechseln innerhalb eines Bereichs, die passende Leistung leuchtet auf
   - Mauszeiger (oder Tippen) auf eine Leistung zeigt deren Foto
   - Beim Scrollen wischt das Foto des nächsten Bereichs über das alte
   ===================================================================== */
(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var phone  = window.matchMedia && window.matchMedia('(max-width: 900px)');
  var AUTO   = 4200;   // Millisekunden, bis das nächste Foto kommt

  var toArray = function (list) { return Array.prototype.slice.call(list); };

  /* ---------- Fortschrittslinie oben ---------- */
  var line = document.querySelector('.scroll-progress span');
  if (line) {
    var update = function () {
      var max = document.documentElement.scrollHeight - window.innerHeight;
      var p = max > 0 ? window.scrollY / max : 0;
      line.style.transform = 'scaleX(' + Math.min(1, Math.max(0, p)) + ')';
    };
    update();
    window.addEventListener('scroll', update, { passive: true });
    window.addEventListener('resize', update);
  }

  /* ---------- Zahlen zählen hoch (16, 6) ---------- */
  toArray(document.querySelectorAll('[data-count]')).forEach(function (el) {
    var end = parseInt(el.getAttribute('data-count'), 10);
    if (isNaN(end) || reduce) return;
    el.textContent = '0';
    var start = null;
    var step = function (ts) {
      if (start === null) start = ts;
      var p = Math.min(1, (ts - start) / 1400);
      el.textContent = String(Math.round(end * (1 - Math.pow(1 - p, 3))));
      if (p < 1) requestAnimationFrame(step);
    };
    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        if (entries[0].isIntersecting) { requestAnimationFrame(step); io.disconnect(); }
      });
      io.observe(el);
    } else {
      requestAnimationFrame(step);
    }
  });

  /* ---------- Gemeinsames ---------- */
  var chapters = toArray(document.querySelectorAll('.chapter'));

  // Leuchtet die Leistung auf, deren Foto gerade zu sehen ist (service = -1: keine)
  var lit = function (chapterIndex, service) {
    var items = chapters[chapterIndex].querySelectorAll('.chapter__list li');
    toArray(items).forEach(function (li, i) { li.classList.toggle('is-lit', i === service); });
  };
  var serviceOf = function (el) { return parseInt(el.getAttribute('data-service'), 10); };

  /* ---------- "Angebot anfragen" wählt die passende Leistung im Formular vor ---------- */
  toArray(document.querySelectorAll('a[data-service]')).forEach(function (link) {
    link.addEventListener('click', function () {
      var select = document.getElementById('f-service');
      if (select) select.value = link.getAttribute('data-service');
    });
  });

  /* Wechsel zwischen Computer- und Handy-Ansicht: Seite neu aufbauen */
  if (phone && phone.addEventListener) {
    phone.addEventListener('change', function () { window.location.reload(); });
  }

  /* =====================================================================
     COMPUTER: Foto-Bühne links
     ===================================================================== */
  if (!(phone && phone.matches)) {
    var allSlides = toArray(document.querySelectorAll('.stage__img'));
    var byChapter = chapters.map(function (_, n) {
      return allSlides.filter(function (s) { return parseInt(s.getAttribute('data-chapter'), 10) === n; });
    });
    var rail   = toArray(document.querySelectorAll('.rail__btn'));
    var numBox = document.querySelector('.stage__num');
    var cap    = document.querySelector('.stage__cap');
    var dots   = document.querySelector('.stage__dots');

    var ch = 0, idx = 0, timer = null, hoverLock = false;
    var lastEl = allSlides[0] || null;

    // Bilder werden erst geladen, wenn sie gebraucht werden (spart Datenvolumen)
    var loadImg = function (el) {
      var img = el.querySelector('img');
      if (img && !img.getAttribute('src') && img.getAttribute('data-src')) {
        img.setAttribute('src', img.getAttribute('data-src'));
      }
    };

    var renderDots = function (n, k) {
      if (!dots) return;
      var list = byChapter[n];
      if (dots.getAttribute('data-chapter') !== String(n)) {
        dots.innerHTML = '';
        dots.setAttribute('data-chapter', String(n));
        if (list.length > 1) {
          list.forEach(function () { dots.appendChild(document.createElement('span')); });
        }
      }
      toArray(dots.children).forEach(function (d, i) { d.classList.toggle('is-on', i === k); });
    };

    var show;   // wird unten definiert (schedule und show rufen sich gegenseitig auf)

    var schedule = function () {
      clearTimeout(timer);
      var list = byChapter[ch];
      if (reduce || hoverLock || document.hidden || !list || list.length < 2) return;
      timer = setTimeout(function () { show(ch, idx + 1); }, AUTO);
    };

    show = function (n, k) {
      var list = byChapter[n];
      if (!list || !list.length) return;
      k = ((k % list.length) + list.length) % list.length;
      var el = list[k];
      loadImg(el);

      if (lastEl !== el) {
        allSlides.forEach(function (s) {
          s.classList.remove('is-prev');
          if (s !== el && s !== lastEl) s.classList.remove('is-active');
        });
        if (lastEl) { lastEl.classList.remove('is-active'); lastEl.classList.add('is-prev'); }
        el.classList.add('is-active');
        lastEl = el;
      }
      ch = n; idx = k;

      chapters.forEach(function (_, i) { lit(i, i === n ? serviceOf(el) : -1); });
      if (cap) cap.textContent = el.getAttribute('data-label') || '';
      renderDots(n, k);

      var upcoming = list[(k + 1) % list.length];   // nächstes Foto schon vorladen
      if (upcoming) loadImg(upcoming);
      schedule();
    };

    // Neuer Bereich in der Mitte des Bildschirms
    var setChapter = function (n, k) {
      if (n < 0) return;
      if (n !== ch) {
        rail.forEach(function (b, i) {
          if (i === n) b.setAttribute('aria-current', 'true'); else b.removeAttribute('aria-current');
        });
        if (numBox) {
          var fresh = document.createElement('span');
          fresh.textContent = chapters[n].getAttribute('data-num');
          var old = numBox.querySelector('span');
          if (old) numBox.replaceChild(fresh, old); else numBox.appendChild(fresh);
        }
      }
      if (n !== ch || typeof k === 'number') show(n, k || 0);
    };

    if (chapters.length && 'IntersectionObserver' in window) {
      var watcher = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) setChapter(chapters.indexOf(en.target));
        });
      }, { rootMargin: '-45% 0px -45% 0px', threshold: 0 });
      chapters.forEach(function (c) { watcher.observe(c); });
    }

    // Seitenleiste: Klick springt zum Bereich
    rail.forEach(function (btn, k) {
      btn.addEventListener('click', function () {
        if (chapters[k]) chapters[k].scrollIntoView({ behavior: reduce ? 'auto' : 'smooth', block: 'center' });
      });
    });

    // Mauszeiger oder Klick auf eine Leistung: deren Foto erscheint sofort
    chapters.forEach(function (chapterEl, n) {
      toArray(chapterEl.querySelectorAll('.chapter__list li')).forEach(function (li, si) {
        var showService = function () {
          var k = -1;
          byChapter[n].forEach(function (s, j) { if (k < 0 && serviceOf(s) === si) k = j; });
          if (k >= 0) setChapter(n, k);
        };
        li.addEventListener('pointerenter', function (e) {
          if (e.pointerType === 'mouse') { hoverLock = true; showService(); }
        });
        li.addEventListener('pointerleave', function (e) {
          if (e.pointerType === 'mouse') { hoverLock = false; schedule(); }
        });
        li.addEventListener('click', showService);
      });
    });

    document.addEventListener('visibilitychange', schedule);

    // Startzustand
    show(0, 0);
  }

  /* =====================================================================
     HANDY: Fotos im Bild über jedem Bereich
     ===================================================================== */
  if (phone && phone.matches) {
    toArray(document.querySelectorAll('.chapter__photo')).forEach(function (fig) {
      var n = parseInt(fig.getAttribute('data-chapter'), 10);
      var slides = toArray(fig.querySelectorAll('.cp__slide'));
      if (slides.length < 2) return;

      var i = 0, t = null, visible = false;
      var set = function (k) {
        i = (k + slides.length) % slides.length;
        slides.forEach(function (s, j) { s.classList.toggle('is-active', j === i); });
        lit(n, serviceOf(slides[i]));
      };
      var tick = function () {
        clearTimeout(t);
        if (reduce || !visible) return;
        t = setTimeout(function () { set(i + 1); tick(); }, AUTO);
      };

      if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (entries) {
          visible = entries[0].isIntersecting;
          if (visible) tick(); else clearTimeout(t);
        }).observe(fig);
      }

      // Tippen auf eine Leistung zeigt deren Foto
      toArray(chapters[n].querySelectorAll('.chapter__list li')).forEach(function (li, si) {
        li.addEventListener('click', function () {
          slides.forEach(function (s, j) { if (serviceOf(s) === si) set(j); });
          tick();
        });
      });
    });
  }
})();

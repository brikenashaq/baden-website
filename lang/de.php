<?php
/**
 * Deutsche Texte der Startseite.
 * Für Englisch später eine Kopie dieser Datei als lang/en.php anlegen und die Texte übersetzen.
 */
return [
    'lang' => 'de',

    'meta' => [
        'title'       => 'BADEN Hausmeisterservice – Haus, Garten & Gebäude | [ORT]',
        'description' => 'BADEN Hausmeisterservice kümmert sich um Haus, Garten und Gebäude: Reinigung, Gartenpflege, Winterdienst, Reparaturen, Entrümpelung und mehr. Jetzt Angebot anfragen.',
    ],

    'skip'   => 'Zum Inhalt springen',
    'cta'    => 'Angebot anfragen',
    'menu'   => 'Menü',
    'close'  => 'Schließen',

    // Menüpunkte: [Beschriftung, Schlüssel aus data/site.php → pages]
    'nav' => [
        ['Startseite', 'home'],
        ['Leistungen', 'leistungen'],
        ['Ablauf', 'ablauf'],
        ['Kontakt', 'kontakt'],
    ],

    // Hero-Slideshow: Bild, Bildausschnitt, Abdunklung (0–1), zwei Überschriftzeilen, Untertext
    'hero' => [
        'label'     => 'Unsere Leistungen im Bild',
        'h1'        => 'BADEN Hausmeisterservice – Wir kümmern uns. Versprochen.',
        'secondary' => 'Unsere Leistungen',
        'scroll'    => 'Nach unten scrollen',
        'prev'      => 'Vorheriges Bild',
        'next'      => 'Nächstes Bild',
        'pause'     => 'Slideshow anhalten',
        'play'      => 'Slideshow starten',
        'slide'     => 'Bild',
        'of'        => 'von',
        'slides' => [
            [
                'img' => 'hero-1', 'pos' => '30% 50%', 'shade' => 0.52,
                'alt' => 'Backsteinhaus mit Gartenwagen auf gepflegtem Rasen',
                'line1' => 'Wir kümmern uns.', 'line2' => 'Versprochen.',
                'sub' => 'Hausmeisterservice für Haus, Garten und Gebäude in [ORT / REGION].',
            ],
            [
                'img' => 'hero-2', 'pos' => '40% 50%', 'shade' => 0.58,
                'alt' => 'Hauseingang mit Leiter, Besen und Wischeimer',
                'line1' => 'Saubere Treppenhäuser.', 'line2' => 'Gepflegte Gebäude.',
                'sub' => 'Gebäude-, Treppenhaus-, Büro- und Praxisreinigung sowie Fensterreinigung.',
            ],
            [
                'img' => 'hero-3', 'pos' => '55% 50%', 'shade' => 0.40,
                'alt' => 'Heckenschere beim Schneiden einer Hecke',
                'line1' => 'Gepflegte Gärten.', 'line2' => 'Saubere Außenflächen.',
                'sub' => 'Gartenpflege, Rasenmähen, Heckenschneiden sowie Baum- und Strauchschnitt.',
            ],
            [
                'img' => 'hero-4', 'pos' => '40% 50%', 'shade' => 0.68,
                'alt' => 'Schneeschaufel beim Räumen von Schnee',
                'line1' => 'Sichere Wege.', 'line2' => 'Auch im Winter.',
                'sub' => 'Winterdienst für Gehwege, Zufahrten und Eingänge.',
            ],
        ],
    ],

    'intro' => [
        'eyebrow' => 'Über BADEN',
        'title'   => 'Ihr Hausmeisterservice für Haus, Garten und Gebäude',
        'text'    => 'Wir kümmern uns um Objekte, Gärten und Wege – vom Treppenhaus bis zum Winterdienst. Alles aus einer Hand, mit klaren Absprachen.',
        'text2'   => '[KURZE VORSTELLUNG: Wer steckt hinter BADEN, seit wann gibt es den Betrieb und wo sind Sie tätig?]',
        'stat_num'  => '16',
        'stat_text' => 'Leistungen aus einer Hand',
    ],

    'services' => [
        'eyebrow' => 'Leistungen',
        'title'   => 'Alles aus einer Hand',
        'lead'    => 'Von der Reinigung bis zum Winterdienst: Das sind unsere wichtigsten Leistungen. Darunter finden Sie alle 16 im Überblick.',
        'link'    => 'Anfragen',
        'photo_missing' => 'Foto folgt',
        // Bild: Dateiname ohne .jpg in assets/img/cards/ – fehlt die Datei, erscheint automatisch ein Platzhalter
        'cards' => [
            ['img' => 'hausmeisterservice', 'alt' => 'Gartenwagen vor einer gepflegten Hecke',
             'title' => 'Hausmeisterservice',
             'text'  => 'Objektbetreuung und Hausmeisterservice sowie Mülltonnenservice – wir kümmern uns um das, was im Alltag anfällt.'],
            ['img' => 'reinigung', 'alt' => 'Wischeimer und Besen vor einem Hauseingang',
             'title' => 'Reinigung',
             'text'  => 'Gebäude-, Treppenhaus-, Büro- und Praxisreinigung sowie Fensterreinigung.'],
            ['img' => 'garten', 'alt' => 'Rasenmähen vor einem Wohnhaus',
             'title' => 'Garten & Außenanlagen',
             'text'  => 'Gartenpflege, Rasenmähen, Heckenschneiden, Baum- und Strauchschnitt sowie Unkrautentfernung.'],
            ['img' => 'winterdienst', 'alt' => 'Schneeschaufel beim Schneeräumen',
             'title' => 'Winterdienst',
             'text'  => 'Schneeräumung und Streuen für sichere Wege und Zufahrten.'],
            ['img' => 'reparaturen', 'alt' => 'Werkzeug auf einer Holzplatte',
             'title' => 'Reparaturen & Montage',
             'text'  => 'Kleinere Reparatur- und Instandhaltungsarbeiten, Möbelmontage und Bodenverlegung (Laminat, Vinyl usw.).'],
            ['img' => 'entruempelung', 'alt' => 'Umzugskartons',
             'title' => 'Entrümpelung & Umzug',
             'text'  => 'Entrümpelung, Haushaltsauflösung sowie Umzugs- und Transporthilfe.'],
        ],
        'all_title' => 'Alle 16 Leistungen im Überblick',
        'all' => [
            ['Hausmeisterservice & Objektbetreuung', ['Objektbetreuung und Hausmeisterservice', 'Mülltonnenservice']],
            ['Reinigung', ['Gebäudereinigung', 'Treppenhausreinigung', 'Büro- und Praxisreinigung', 'Fensterreinigung']],
            ['Garten & Außenanlagen', ['Gartenpflege und Gartenarbeit', 'Rasenmähen und Heckenschneiden', 'Baum- und Strauchschnitt', 'Unkrautentfernung']],
            ['Winterdienst', ['Winterdienst']],
            ['Reparaturen & Montage', ['Kleinere Reparatur- und Instandhaltungsarbeiten', 'Möbelmontage und Möbelaufbau', 'Bodenverlegung (Laminat, Vinyl usw.)']],
            ['Entrümpelung & Umzug', ['Entrümpelung und Haushaltsauflösung', 'Umzugs- und Transporthilfe']],
        ],
    ],

    // Wird nur angezeigt, wenn assets/img/referenzen/vorher-1.jpg und nachher-1.jpg existieren
    'beforeafter' => [
        'eyebrow' => 'Vorher / Nachher',
        'title'   => 'Der Unterschied ist sichtbar',
        'text'    => 'Ziehen Sie den Regler und sehen Sie, was ein gepflegtes Objekt ausmacht.',
        'before'  => 'Vorher',
        'after'   => 'Nachher',
        'alt_before' => 'Zustand vor der Arbeit',
        'alt_after'  => 'Zustand nach der Arbeit',
        'label'   => 'Vorher-Nachher-Vergleich: Regler ziehen',
    ],

    'why' => [
        'eyebrow' => 'Warum BADEN',
        'title'   => 'Darauf können Sie sich verlassen',
        'items' => [
            ['Fester Ansprechpartner', 'Von der Anfrage bis zur Erledigung kümmert sich eine Person um Ihr Anliegen.'],
            ['Klare Preise', 'Sie wissen vorher, was es kostet – alle Preise inklusive gesetzlicher MwSt.'],
            ['Termine nach Absprache', 'Wir stimmen Termine mit Ihnen ab und halten uns daran.'],
            ['Saubere Arbeit', 'Wir hinterlassen Ihr Objekt so, wie wir es selbst gern vorfinden würden: ordentlich.'],
        ],
    ],

    'steps' => [
        'eyebrow' => 'Ablauf',
        'title'   => 'In vier Schritten zum Ergebnis',
        'items' => [
            ['Anfrage', 'Sie schildern uns kurz, was zu tun ist – per Formular, Telefon oder WhatsApp.'],
            ['Besichtigung', 'Wir sehen uns Ihr Objekt an und klären Umfang und Termin direkt vor Ort.'],
            ['Angebot', 'Sie erhalten ein klares Angebot mit Preis inkl. MwSt. – ohne versteckte Posten.'],
            ['Erledigt', 'Wir führen die Arbeit zuverlässig aus. Wir kümmern uns – versprochen.'],
        ],
    ],

    'contact' => [
        'eyebrow' => 'Kontakt',
        'title'   => 'Erzählen Sie uns, was zu tun ist',
        'text'    => 'Schreiben Sie uns kurz, worum es geht. Wir melden uns bei Ihnen und besprechen alles Weitere.',
        'phone' => 'Telefon', 'whatsapp' => 'WhatsApp', 'email' => 'E-Mail', 'area' => 'Einsatzgebiet', 'hours' => 'Öffnungszeiten',
        'form_title' => 'Angebot anfragen',
        'name' => 'Name', 'name_ph' => 'Vor- und Nachname',
        'tel' => 'Telefon', 'tel_ph' => 'Für Rückfragen',
        'mail' => 'E-Mail', 'mail_ph' => 'name@beispiel.de',
        'place' => 'PLZ / Ort', 'place_ph' => 'Wo sollen wir tätig werden?',
        'service' => 'Worum geht es?', 'service_ph' => 'Bitte wählen',
        'services' => ['Hausmeisterservice & Objektbetreuung', 'Reinigung', 'Garten & Außenanlagen', 'Winterdienst', 'Reparaturen & Montage', 'Entrümpelung & Umzug', 'Sonstiges'],
        'message' => 'Ihre Nachricht', 'message_ph' => 'Kurze Beschreibung, gern mit Wunschtermin',
        'privacy_pre' => 'Ich habe die ', 'privacy_link' => 'Datenschutzerklärung', 'privacy_post' => ' gelesen. Meine Angaben werden nur zur Bearbeitung meiner Anfrage verwendet.',
        'submit' => 'Anfrage senden',
        'required' => 'Pflichtfeld',
        'ok'    => 'Vielen Dank! Wir haben Ihre Anfrage erhalten und melden uns bei Ihnen.',
        'error' => 'Das hat leider nicht geklappt. Bitte prüfen Sie Ihre Angaben oder rufen Sie uns an.',
    ],

    'footer' => [
        'slogan'   => 'Wir kümmern uns. Versprochen.',
        'services' => 'Leistungen',
        'contact'  => 'Kontakt',
        'legal'    => 'Rechtliches',
        'imprint'  => 'Impressum',
        'privacy'  => 'Datenschutzerklärung',
        'vat'      => 'Alle Preise inkl. gesetzlicher MwSt.',
        'links' => ['Hausmeisterservice', 'Reinigung', 'Garten & Außenanlagen', 'Winterdienst', 'Reparaturen & Montage', 'Entrümpelung & Umzug'],
    ],

    'mobilebar' => ['call' => 'Anrufen', 'wa' => 'WhatsApp'],
];

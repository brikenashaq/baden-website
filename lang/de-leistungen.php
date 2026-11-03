<?php
/**
 * Texte der Seite "Leistungen".
 * Die Bereiche entsprechen den 16 Leistungen des Kunden, gruppiert in 6 Bereiche.
 * Das Zeichen \u{00AD} ist ein unsichtbarer Trennstrich: Lange Wörter dürfen dort umbrechen.
 * 'service' muss genau einem Eintrag aus lang/de.php → contact → services entsprechen (Vorauswahl im Formular).
 * 'img' = Dateiname in assets/img/leistungen/ ohne .jpg. Fehlt die Datei, erscheint ein Platzhalter.
 */
return [
    'meta' => [
        'title'       => 'Leistungen – Hausmeisterservice, Reinigung, Garten & mehr | BADEN',
        'description' => 'Alle 16 Leistungen von BADEN Hausmeisterservice im Überblick: Objektbetreuung, Reinigung, Gartenpflege, Winterdienst, Reparaturen, Bodenverlegung, Entrümpelung und Umzugshilfe.',
    ],

    'hero' => [
        'eyebrow' => 'Unsere Leistungen',
        'word'    => 'Leistungen',
        'sub'     => 'Sechzehn Leistungen in sechs Bereichen – vom Treppenhaus bis zum Winterdienst. Alles aus einer Hand.',
        'stats'   => [[16, 'Leistungen'], [6, 'Bereiche']],
        'tag'     => 'Haus · Garten · Gebäude',
        'scroll'  => 'Bereiche entdecken',
    ],

    'rail_label'    => 'Bereiche',
    'goto'          => 'Zu Bereich',
    'photo_missing' => 'Foto folgt',
    'price'         => 'ab [PREIS] €',
    'vat'           => 'inkl. MwSt.',

    'chapters' => [
        [
            'num' => '01', 'rail' => 'Hausmeisterservice',
            't1' => "Hausmeister\u{00AD}service", 't2' => '& Objektbetreuung',
            'service' => 'Hausmeisterservice & Objektbetreuung',
            'lead'  => 'Wir kümmern uns um Ihr Objekt und um das, was im Alltag anfällt.',
            'items' => ['Objektbetreuung und Hausmeisterservice', 'Mülltonnenservice'],
            'img' => 'stage-1', 'alt' => 'Gartenwagen vor einer gepflegten Hecke',
        ],
        [
            'num' => '02', 'rail' => 'Reinigung',
            't1' => 'Reinigung', 't2' => 'Gebäude, Treppenhaus, Büro & Fenster',
            'service' => 'Reinigung',
            'lead'  => 'Saubere Räume und Flächen – für Wohnhäuser, Büros und Praxen.',
            'items' => ['Gebäudereinigung', 'Treppenhausreinigung', 'Büro- und Praxisreinigung', 'Fensterreinigung'],
            'img' => 'stage-2', 'alt' => 'Wischeimer und Besen vor einem Hauseingang',
        ],
        [
            'num' => '03', 'rail' => 'Garten',
            't1' => 'Garten', 't2' => '& Außenanlagen',
            'service' => 'Garten & Außenanlagen',
            'lead'  => 'Gepflegte Außenflächen rund um Haus und Gebäude.',
            'items' => ['Gartenpflege und Gartenarbeit', 'Rasenmähen und Heckenschneiden', 'Baum- und Strauchschnitt', 'Unkrautentfernung'],
            'img' => 'stage-3', 'alt' => 'Rasenmähen vor einem Wohnhaus',
        ],
        [
            'num' => '04', 'rail' => 'Winterdienst',
            't1' => "Winter\u{00AD}dienst", 't2' => 'Sichere Wege',
            'service' => 'Winterdienst',
            'lead'  => 'Schneeräumung und Streuen für sichere Wege und Zufahrten, auch bei Schnee und Glätte.',
            'items' => ['Winterdienst'],
            'img' => 'stage-4', 'alt' => 'Schneeschaufel beim Schneeräumen',
        ],
        [
            'num' => '05', 'rail' => 'Reparaturen',
            't1' => 'Reparaturen', 't2' => '& Montage',
            'service' => 'Reparaturen & Montage',
            'lead'  => 'Kleine Arbeiten rund ums Haus, die erledigt werden müssen.',
            'items' => ['Kleinere Reparatur- und Instandhaltungsarbeiten', 'Möbelmontage und Möbelaufbau', 'Bodenverlegung (Laminat, Vinyl usw.)'],
            'img' => 'stage-5', 'alt' => 'Schraubendreher und Schrauben auf einer Holzplatte',
        ],
        [
            'num' => '06', 'rail' => 'Entrümpelung',
            't1' => "Entrümpelung", 't2' => '& Umzug',
            'service' => 'Entrümpelung & Umzug',
            'lead'  => 'Platz schaffen und den Umzug erleichtern.',
            'items' => ['Entrümpelung und Haushaltsauflösung', 'Umzugs- und Transporthilfe'],
            'img' => 'stage-6', 'alt' => 'Umzugskartons',
        ],
    ],

    'closing' => [
        'title' => 'Ihr Anliegen ist nicht dabei?',
        'text'  => 'Fragen Sie uns einfach an. Wir melden uns bei Ihnen und sagen Ihnen ehrlich, ob und wie wir helfen können.',
        'call'  => 'Jetzt anrufen',
        'wa'    => 'WhatsApp schreiben',
        'form'  => 'Zum Formular',
    ],
];

<?php
/**
 * BADEN Hausmeisterservice – Firmendaten
 * Hier ändern Sie Telefonnummer, E-Mail, Adresse und Öffnungszeiten an EINER Stelle.
 * Alles in [ECKIGEN KLAMMERN] ist ein Platzhalter und muss vor dem Start ersetzt werden.
 */
return [
    'name'   => 'BADEN Hausmeisterservice',
    'region' => 'Baden-Baden',

    // Telefon: "display" wird angezeigt, "href" ist die Nummer für den Anruf-Link (mit Ländervorwahl, ohne Leerzeichen)
    'phone_display' => '+49 176 20549488 / +49 176 20560333',
    'phone_href'    => '+4917620549488',
    'phone_header'  => '+49 176 20549488',   // im Header nur EINE Nummer zeigen

    // WhatsApp: nur Ziffern, mit Ländervorwahl, ohne + (z. B. 4917612345678)
    'whatsapp_display' => '+49 176 20549488 / +49 176 20560333',
    'whatsapp_href'    => '4917620549488',

    'email_display' => 'info@hausmaisterservice-baden.com',
    'email_href'    => 'info@hausmaisterservice-baden.com',

    'address' => '76547 Engelbert-Kleiser-Straße 13',
    'hours'   => 'Mo–Sun 00-24',

    // Kontaktformular (send.php)
    'mail_to'  => 'info@hausmaisterservice-baden.com',   // Empfänger der Anfragen
    'mail_from' => 'website@example.com', // Absender (muss zur eigenen Domain gehören)
    'dev_mode' => true,                 // true = Anfragen nur in data/outbox.txt speichern (zum Testen). Auf dem Server: false

    // Ziele der Menüpunkte. Später durch eigene Seiten ersetzen, z. B. 'leistungen' => 'leistungen.php'
    'pages' => [
        'home'       => 'index.php',
        'leistungen' => 'leistungen.php',
        'ablauf'     => '#ablauf',
        'kontakt'    => '#kontakt',
        'impressum'  => 'impressum.php',
        'datenschutz' => 'datenschutz.php',
    ],
];

# Two Click Embeds

**Beschreibung:**  
Datenschutzfreundliche Einbettungen von externen Inhalten (YouTube, Vimeo, SoundCloud, Twitter/X, TikTok, Facebook) mit 2-Click-Placeholder.

---

## Installation

1. Plugin-Ordner in dein `wp-content/plugins` Verzeichnis kopieren
2. WordPress-Admin öffnen → Plugins → „Two Click Embeds“ aktivieren
3. Optional: eigene Provider über den Filter `two_click_embeds_providers` hinzufügen

---

## Features

- Einbettungen von externen Inhalten standardmäßig blocken
- Platzhalter mit Text und Button zum nachträglichen Laden
- Opt-Out-Link für Nutzer
- Unterstützung für mehrere Provider (YouTube, Vimeo, SoundCloud, Twitter/X, TikTok, Facebook)
- Provider-spezifische Handler
- Einfach erweiterbar via `Provider_Handler_Factory` und Filter

---

## Beispiel: eigenen Provider hinzufügen

```php
add_filter('two_click_embeds_providers', function($providers){
    $providers['myprovider'] = [
        'slug' => 'myprovider',
        'label' => 'MyProvider',
        'xpath' => '//iframe[contains(@src,"myprovider.com")]',
        'text' => 'Beim Laden des Inhalts werden Daten an MyProvider übertragen.',
        'handler' => MyProvider_Handler::class,
    ];
    return $providers;
});

---

## Developer Notes

- Plugin ist PHP 7.4+ kompatibel
- Provider werden als Array registriert, Renderer erwartet ProviderDefinition-Objekte
- Hauptlogik: Embed_Renderer (DOM-Manipulation)
- Filter the_content wird benutzt, Admin-Ansicht wird ausgelassen
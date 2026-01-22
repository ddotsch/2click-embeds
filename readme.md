# Two Click Embeds

**Descripton:**  
Privacy-friendly Embeds of 3rd Party Content (YouTube, Vimeo, SoundCloud, Twitter/X, TikTok, Facebook) with a 2-click placeholder.

---

## Installation

1. Copy the plugin-folder into your `wp-content/plugins` directory
2. Log into Wordpress → Plugins → activate „Two Click Embeds“
3. Optional: add your own provider with the `two_click_embeds_providers` filter and/or add your own Provider_Handler's

---

## Features

- Replaces 3rd party embeds with a placeholder
- placeholder with text and button to confirm
- user can later revoke the consent with an additonal link
- currently supports different providers (YouTube, Vimeo, SoundCloud, Twitter/X, TikTok, Facebook)
- specific handlers based on provider
- can be extended via `Provider_Handler_Factory` and a filter

---

## Example: add provider with a filter

```php
add_filter('two_click_embeds_providers', function($providers){
    $providers['myprovider'] = [
        'slug' => 'myprovider',
        'label' => 'MyProvider',
        'xpath' => '//iframe[contains(@src,"myprovider.com")]',
        'text' => 'Loading this content sends data to "myprovider.com"',
        'handler' => MyProvider_Handler::class,
    ];
    return $providers;
});
```

---

## Developer Notes

- PHP 7.4+ kompatibel
- Provider registered as Array in class-embed-providers.php, the renderer uses the Provider_Definition class
- main logic: Embed_Renderer (DOM-Manipulation)
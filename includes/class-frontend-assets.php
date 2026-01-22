<?php

namespace Two_Click_Embeds\includes;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\provider\Embed_Provider;

class Frontend_Assets {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueueAssets' ] );
    }

    public function enqueueAssets() {
        // Prepare provider_scripts for localization
        $provider_scripts = [];
        foreach ( Embed_Provider::all() as $provider ) {
            if (!empty($provider['script']) && !empty($provider['slug'])) {
                $provider_scripts[$provider['slug']] = esc_url($provider['script']);
            }
        }

        // Enqueue frontend JS
        wp_enqueue_script(
            'two-click-embeds-frontend',
            TCE_PLUGIN_URL . 'assets/js/frontend.js',
            [],
            TCE_VERSION,
            true
        );
        
        // Pass provider_scripts to JS via localization
        wp_localize_script(
            'two-click-embeds-frontend',
            'TwoClickEmbeds',
            [
                'cookieName' => '2click_embed_consent',
                'providerScripts' => $provider_scripts,
            ]
        );

        wp_enqueue_style(
            'two-click-embeds-frontend',
            TCE_PLUGIN_URL . 'assets/css/frontend.css',
            [],
            TCE_VERSION
        );
    }
}
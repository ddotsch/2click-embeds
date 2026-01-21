<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

class Tiktok_Provider_Handler extends Script_After_Embed_Handler {

    /**
     * Get the script URL to be added after the embed
     *
     * @return string The script URL.
     */
    protected function getScriptUrl(): string {
        return 'www.tiktok.com/embed.js';
    }
    
}
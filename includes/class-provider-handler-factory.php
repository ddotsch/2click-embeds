<?php

namespace Two_Click_Embeds\includes;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\provider\Provider_Handler_Interface;
use Two_Click_Embeds\includes\provider\Embed_Provider;

/**
 * Factory class to get provider handlers
 */

class Provider_Handler_Factory {

    /**
     * Get the appropriate provider handler based on the provider slug
     *
     * @param string $providerSlug The slug of the embed provider.
     * @return Provider_Handler_Interface|null The provider handler instance or null if not found.
     */
    public static function getHandler( string $providerSlug ): ?Provider_Handler_Interface {
        $providers = Embed_Provider::all();

        $handlerClass = $providers[ $providerSlug ]['handler'] ?? null;

        if ( ! $handlerClass || ! class_exists( $handlerClass ) ) {
            return null;
        }

        return new $handlerClass();
    }
}
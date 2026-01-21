<?php

namespace Two_Click_Embeds\includes;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\provider\Embed_Provider;
use Two_Click_Embeds\includes\provider\Provider_Definition;

/**
 * Class ContentFilter
 * Filters the content to wrap embeds with 2click placeholders
 * Central Class to handle content filtering
 */

class ContentFilter {

    /**
     * Constructor - add filters
     */
    public function __construct() {
        add_filter( 'the_content', [ $this, 'filter' ], 20 );
    }

    /**
     * Filter the content to wrap embeds with 2click placeholders
     * The Content will be parsed as DOM, each provider will be processed.
     * Generic wrapping will be applied and then provider specific handling will be done via provider handlers.
     * @param string $content The original content.
     * @return string The filtered content.
     */
    public static function filter(
        string $content
    ): string {

        //dont do it if there is no content
        if ( empty( $content ) ) {
            return $content;
        };

        //dont do it if im in the admin view
        if ( is_admin() ) {
            return $content;
        }; 

        //load the content into a DOM document
        $renderer = new Embed_Renderer($content);

        //process each provider
        foreach ( Embed_Provider::all() as $providerArray ) {
            
            $provider = Provider_Definition::fromArray($providerArray);

            // only render the placeholder if there is a provider handler
            if ( Provider_Handler_Factory::getHandler( $provider->slug ) ) {
                $renderer->process( $provider );
            } else {
                // no handler found
                error_log( '2click-embeds: No handler found for provider ' . $provider->slug );
            }
        }

        return $renderer->returnHTML();
    }
}
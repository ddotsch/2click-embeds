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

        if ( empty( $content ) ) return $content;

        if ( is_admin() ) return $content; 

        //create renderer - loads the content into a DOMDocument and generates an XPath object
        $renderer = new Embed_Renderer($content);

        //process the content with each provider
        foreach ( Embed_Provider::all() as $providerArray ) {
            // create provider definition from array for easier handling
            $provider = Provider_Definition::fromArray($providerArray);

            // skip if no handler is defined and log "error"
            if ( !$provider->handler ) {
                error_log( '2click-embeds: No handler found for provider ' . $provider->slug );
                continue;
            }
            
            $renderer->process( $provider );
        }

        return $renderer->returnHTML();
    }
}
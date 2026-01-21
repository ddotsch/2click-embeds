<?php

namespace Two_Click_Embeds\includes;

defined( 'ABSPATH' ) || exit;

/**
 * Class Domloader
 * Utility class to load HTML into a DOMDocument
 */

class Domloader {

    /**
     * Load HTML into a DOMDocument
     *
     * @param string $html The HTML content to load.
     * @return \DOMDocument The loaded DOMDocument.
     */
    public static function fromHTML(
        string $html
    ): \DOMDocument {
        $dom = new \DOMDocument();
        libxml_use_internal_errors( true );
        $dom->loadHTML(
            mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        return $dom;
    }
}
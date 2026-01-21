<?php

namespace Two_Click_Embeds\includes\Provider;

defined( 'ABSPATH' ) || exit;

/**
 * Interface Provider_Handler_Interface
 * Interface for provider handlers to implement provider specific handling logic
 */

interface Provider_Handler_Interface {

    /**
     * Handle provider specific adjustments to the given DOM element
     *
     * @param \DOMElement $element The DOM element to process.
     * @return void
     */
    public function handle( \DOMElement $element ): void;
}
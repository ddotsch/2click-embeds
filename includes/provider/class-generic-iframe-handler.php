<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

class Generic_Iframe_Handler implements Provider_Handler_Interface {

    /**
     * Handle the given DOM element by modifying its attributes to disable automatic loading.
     *
     * @param \DOMElement $element The DOM element to be handled.
     * @return void
     */
    public function handle( \DOMElement $element ): void {
        $src = $element->getAttribute('src');
        $element->setAttribute('data-src', $src);
        $element->setAttribute('src', '');
    }
}
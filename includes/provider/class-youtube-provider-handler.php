<?php

namespace Two_Click_Embeds\includes\Provider;

defined( 'ABSPATH' ) || exit;

class YouTube_Provider_Handler implements Provider_Handler_Interface {

    public function handle(
        \DOMElement $element
    ): void {
        $src = $element->getAttribute('src');
        $element->setAttribute('data-src', $src);
        $element->setAttribute('src', '');
    }
}
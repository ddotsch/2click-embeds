<?php

namespace Two_Click_Embeds\includes\Provider;

defined( 'ABSPATH' ) || exit;

class Twitter_Provider_Handler implements Provider_Handler_Interface {

    public function handle( \DOMElement $element ): void {
        
        /** @var DOMElement $parent */
        $parent = $element->parentNode->parentNode;
        $scripts = $parent->getElementsByTagName('script');
        for ($i = $scripts->length - 1; $i >= 0; $i--) {
            $script = $scripts->item($i);
            $src = $script->getAttribute('src');
            if ( str_contains( $src, 'platform.twitter.com/widgets.js' ) ) {
                $script->parentNode->removeChild($script);;
            }
        }
    }
}
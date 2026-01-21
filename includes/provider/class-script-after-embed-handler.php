<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

abstract class Script_After_Embed_Handler implements Provider_Handler_Interface {

    abstract protected function getScriptUrl(): string;

    public function handle( \DOMElement $element ): void {
        
        /** @var DOMElement $parent */
        $parent = $element->parentNode->parentNode;

        if ( ! $parent ) {
            return;
        }

        $scripts = $parent->getElementsByTagName('script');
        for ($i = $scripts->length - 1; $i >= 0; $i--) {
            $script = $scripts->item($i);
            $src = $script->getAttribute('src');
            if ( str_contains( $src, $this->getScriptUrl() ) ) {
                $script->parentNode->removeChild($script);;
            }
        }
    }
}
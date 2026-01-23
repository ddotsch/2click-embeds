<?php

namespace Two_Click_Embeds\includes\handler;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\provider\Provider_Definition;

class Script_After_Embed_Handler implements Provider_Handler_Interface
{

    protected Provider_Definition $provider;

    public function __construct( Provider_Definition $provider )
    {
        $this->provider = $provider;
    }

    public function getLabel( \DOMElement $element ): string
    {
        return $this->provider->label;
    }

    public function getText( \DOMElement $element ): string
    {
        return $this->provider->text;
    }

    public function getSlug( \DOMElement $element ): string
    {
        return $this->provider->slug;
    }

    public function handle( \DOMElement $element ): void
    {
        /** @var DOMElement $parent */
        $parent = $element->parentNode->parentNode;

        if ( ! $parent ) {
            return;
        }

        $scripts = $parent->getElementsByTagName('script');
        for ($i = $scripts->length - 1; $i >= 0; $i--) {
            $script = $scripts->item($i);
            $src = $script->getAttribute('src');
            if ( !str_contains( $src, $this->provider->script ) ) continue;
            $script->parentNode->removeChild($script);
        }
    }
}
<?php

namespace Two_Click_Embeds\includes;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\provider\Provider_Definition;

class Embed_Context {

    public \DOMElement $element;
    public Provider_Definition $provider;
    public string $label;
    public string $text;
    public string $slug;

    public function __construct(
        \DOMElement $element,
        Provider_Definition $provider,
        string $label,
        string $text,
        string $slug
    ) {
        $this->element = $element;
        $this->provider = $provider;
        $this->label = $label;
        $this->text = $text;
        $this->slug = $slug;
    }
}
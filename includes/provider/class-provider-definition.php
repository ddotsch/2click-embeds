<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

/**
 * Class Provider_Definition
 *
 * Represents the definition of an embed provider. Merely a data container, registering new Providers is done in Embed_Provider.
 * Enables typed access to provider properties.
 */

final class Provider_Definition {

    public string $slug;
    public ?string $label;
    public string $xpath;
    public ?string $text;
    public ?string $script = null;
    public string $handler;

    public function __construct(
        string $slug,
        ?string $label,
        string $xpath,
        ?string $text,
        ?string $script = null,
        string $handler
    )
    {
        $this->slug = $slug;
        $this->label = $label;
        $this->xpath = $xpath;
        $this->text = $text;
        $this->script = $script;
        $this->handler = $handler;
    }

    public static function fromArray(array $provider): Provider_Definition {
        return new self(
            $provider['slug'],
            $provider['label'] ?? null,
            $provider['xpath'],
            $provider['text'] ?? null,
            $provider['script'] ?? null,
            $provider['handler']
        );
    }

    public function getHandler(): Provider_Handler_Interface {
        return new $this->handler($this);
    }
}
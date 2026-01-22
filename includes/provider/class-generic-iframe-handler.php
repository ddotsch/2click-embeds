<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

class Generic_Iframe_Handler implements Provider_Handler_Interface {

    protected Provider_Definition $provider;

    public function __construct(
        Provider_Definition $provider
    ) {
        $this->provider = $provider;
    }

    /**
    * Get the label for the provider based on the given DOM element
    * @param \DOMElement $element The DOM element to extract the label from.
    * @return string|null The label of the provider.
    */
    public function getLabel( \DOMElement $element ): ?string {
        if($this->provider->label) return $this->provider->label;
        
        $src = esc_url_raw($element->getAttribute('src'));
        $host = parse_url($src, PHP_URL_HOST);
        $domain = preg_replace('/^www\./i', '', $host);

        return $domain ?: __('Unbekannter Provider', 'two-click-embeds');
    }

    /**
     * Get the text for the provider based on the given DOM element
     * @param \DOMElement $element The DOM element to extract the text from.
     * @return string|null The text of the provider.
     */
    public function getText( \DOMElement $element ): ?string {
        if($this->provider->text) return $this->provider->text;

        return sprintf(
            __('Beim Laden des Inhalts werden Daten an %s übertragen.', 'two-click-embeds'),
            $this->getLabel($element)
        );
    }

    /**
     * Get the slug for the provider based on the given DOM element
     * @param \DOMElement $element The DOM element to extract the slug from.
     * @return string The slug of the provider.
     */
    public function getSlug( \DOMElement $element ): string {
        if ($this->provider->slug) return $this->provider->slug;
        $nicename = strtolower( preg_replace( '/[^a-zA-Z0-9]+/', '-', $this->getLabel( $element ) ) );
        return $nicename;
    }

    /**
     * Handle the given DOM element by modifying its attributes to disable automatic loading.
     *
     * @param \DOMElement $element The DOM element to be handled.
     * @return void
     */
    public function handle( \DOMElement $element ): void {
        $src = esc_url_raw($element->getAttribute('src'));
        $element->setAttribute('data-src', $src);
        $element->setAttribute('src', '');
    }
}
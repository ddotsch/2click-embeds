<?php

namespace Two_Click_Embeds\includes\handler;

defined( 'ABSPATH' ) || exit;

/**
 * Interface Provider_Handler_Interface
 * Interface for provider handlers to implement provider specific handling logic
 */

interface Provider_Handler_Interface
{

    /**
     * Get the label for the provider based on the given DOM element
     * @param \DOMElement $element The DOM element to extract the label from.
     * @return string The label of the provider.
     */
    public function getLabel( \DOMElement $element ): string;

    /**
     * Get the text for the provider based on the given DOM element
     * @param \DOMElement $element The DOM element to extract the text from.
     * @return string The text of the provider.
     */
    public function getText( \DOMElement $element ): string;

    /**
     * Get the slug for the provider based on the given DOM element
     * @param \DOMElement $element The DOM element to extract the slug from.
     * @return string The slug of the provider.
     */

    public function getSlug( \DOMElement $element ): string;

    /**
     * Handle provider specific adjustments to the given DOM element
     *
     * @param \DOMElement $element The DOM element to process.
     * @return void
     */
    public function handle( \DOMElement $element ): void;
}
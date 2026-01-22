<?php

namespace Two_Click_Embeds\includes;

use Two_Click_Embeds\includes\provider\Provider_Definition;

defined( 'ABSPATH' ) || exit;

/**
 * Class to render embeds with 2click placeholders
 * Builds a DOM from the content, processes each provider, generates placeholders and provider specific handling
 */

class Embed_Renderer {
 
    private \DOMXPath $xpath;
    private \DOMDocument $dom;

    public function __construct(
        string $content
    )
    {
        $this->dom = Domloader::fromHTML( $content );
        $this->xpath = new \DOMXPath($this->dom);
    }

    /**
     * Process the DOM-Element -> wrap it in a classed div and add a placeholder -> process provider specifics
     *
     * @param Provider_Definition $provider The embed provider details.
     * @return void
     */
    public function process(
        Provider_Definition $provider
    ): void {
       $elements = $this->xpath->query( $provider->xpath );
       if ( $elements === false || $elements->length === 0 ) return;

       foreach ( $elements as $element ) {
           $this->wrap($element, $provider);
           $provider->getHandler()->handle($element);
       }
    }

    /**
     * Wrap the given element with external-2click div and add placeholder and opt-out link
     * @param \DOMElement $element
     * @param Provider_Definition $provider
     * @return void
     */
    private function wrap(
        \DOMElement $element,
        Provider_Definition $provider
    ): void {
		$elementClasses = $element->getAttribute('class');
		$element->setAttribute('class', 'external-2click-target ' . $elementClasses);

		//add a 2click wrapper
		$wrapper = $this->dom->createElement('div');
		$wrapper->setAttribute('class', 'external-2click');
		$wrapper->setAttribute('data-provider', $provider->label);
		$wrapper->setAttribute('data-provider-slug', $provider->slug);
		
		//add a placeholder inside the wrapper
		$wrapper->appendChild(
			$this->generatePlaceholder( $provider )
		);

        //move the element inside the wrapper
		$elementParent = $element->parentNode;
		$elementParent->replaceChild($wrapper, $element);

		$wrapper->appendChild($element);

		//add an opt-out link
		$wrapper->appendChild(
			$this->generateOptOutLink( $provider )
		);  

        if(!$element->getAttribute('src')) return;

        $wrapper->appendChild(
            $this->generateSourceLink($element)
        );
    }

    /**
     * Generate a placeholder element with provider specific text
     * @param Provider_Definition $provider
     * @return \DOMElement
     */
    private function generatePlaceholder(
        Provider_Definition $provider
    ): \DOMElement {
        $title 	= $this->dom->createElement('strong', __('Externer Inhalt', 'two-click-embeds'));
        $text 	= $this->dom->createElement('p', $provider->text);

        $button = $this->dom->createElement('button', sprintf(__('Inhalt von %s zulassen', 'two-click-embeds'), $provider->label));
        $button->setAttribute('type', 'button');
        $button->setAttribute('class', 'external-load');

        $wrapper = $this->dom->createElement('div');
        $wrapper->setAttribute('class', 'external-placeholder');

        $wrapper->appendChild($title);
        $wrapper->appendChild($text);
        $wrapper->appendChild($button);

        return $wrapper;
    }

    /**
     * Generate an opt-out link element
     * @param Provider_Definition $provider
     * @return \DOMElement
     */
    private function generateOptOutLink(
        Provider_Definition $provider
    ): \DOMElement {
        $wrapper = $this->dom->createElement('p');
        $wrapper->setAttribute('class', 'external-optout');

        $link = $this->dom->createElement('a', sprintf(__('Inhalte von %s nicht mehr zulassen', 'two-click-embeds'), $provider->label));
        $link->setAttribute('href', '#');
        $link->setAttribute('data-revoke', $provider->slug);

        $wrapper->appendChild($link);

        return $wrapper;
    }

    /**
     * Generate a source link element
     * @param \DOMElement $element
     * @return \DOMElement
     */
    public function generateSourceLink(
        \DOMElement $element
    ): \DOMElement {
        $srcLink = $this->dom->createElement('a');
        $srcLink->setAttribute('class', 'external-2click-src');
        $srcLink->setAttribute('href', $element->getAttribute('src'));
        $srcLink->setAttribute('target', '_blank');
        $srcLink->setAttribute('rel', 'noopener noreferrer');
        $textNode = $this->dom->createTextNode('Direktlink: ' . $element->getAttribute('src'));
        $srcLink->appendChild($textNode);

        return $srcLink;
    }

    /**
     * Return the processed HTML content
     * @return string
     */
    public function returnHTML(): string {
        return $this->dom->saveHTML();
    }

}
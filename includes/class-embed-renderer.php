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
        $this->dom      = Domloader::fromHTML( $content );
        $this->xpath    = new \DOMXPath( $this->dom );
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

        //no elements found
        if ( $elements === false || $elements->length === 0 ) return;

        $handler = $provider->getHandler();

        foreach ( $elements as $element ) {

            $embedContext = new Embed_Context(
                $element,
                $provider,
                $handler->getLabel( $element ),
                $handler->getText( $element ),
                $handler->getSlug( $element )
            );

            $this->wrap( $embedContext);
            $handler->handle( $element );
        }
    }

    /**
     * Wrap the given element with external-2click div and add placeholder and opt-out link
     * @param \DOMElement $element
     * @param Provider_Definition $provider
     * @return void
     */
    private function wrap(
        Embed_Context $context
    ): void {
        // add class to the element itself
		$elementClasses = $context->element->getAttribute( 'class' );
		$context->element->setAttribute( 'class', 'external-2click-target ' . $elementClasses );

		//create 2click wrapper
		$wrapper = $this->dom->createElement( 'div' );
		$wrapper->setAttribute( 'class', 'external-2click' );
		$wrapper->setAttribute( 'data-provider', $context->label );
		$wrapper->setAttribute( 'data-provider-slug', $context->slug );
		
		//add a placeholder inside the wrapper
		$wrapper->appendChild(
			$this->generatePlaceholder( $context )
		);

        //move the element inside the wrapper
		$elementParent = $context->element->parentNode;
		$elementParent->replaceChild( $wrapper, $context->element);

		$wrapper->appendChild( $context->element );

		//add an opt-out link
		$wrapper->appendChild(
			$this->generateOptOutLink( $context )
		);  

        if( !$context->element->getAttribute( 'src' ) ) return;
        $wrapper->appendChild(
            $this->generateSourceLink( $context )
        );
    }

    /**
     * Generate a placeholder element with provider specific text
     * @param Embed_Context $context
     * @return \DOMElement
     */
    private function generatePlaceholder(
        Embed_Context $context
    ): \DOMElement {
        $title 	= $this->dom->createElement( 'strong', __( 'Externer Inhalt', 'two-click-embeds' ) );
        $text 	= $this->dom->createElement( 'p', $context->text );

        $button = $this->dom->createElement( 'button', sprintf( __( 'Inhalt von %s zulassen', 'two-click-embeds' ), $context->label ) );
        $button->setAttribute( 'type', 'button' );
        $button->setAttribute( 'class', 'external-load' );

        $wrapper = $this->dom->createElement( 'div' );
        $wrapper->setAttribute( 'class', 'external-placeholder' );

        $wrapper->appendChild( $title );
        $wrapper->appendChild( $text );
        $wrapper->appendChild( $button );

        return $wrapper;
    }

    /**
     * Generate an opt-out link element
     * @param Embed_Context $context
     * @return \DOMElement
     */
    private function generateOptOutLink(
        Embed_Context $context
    ): \DOMElement {
        $wrapper = $this->dom->createElement( 'p' );
        $wrapper->setAttribute( 'class', 'external-optout' );

        $link = $this->dom->createElement( 'a', sprintf( __( 'Inhalte von %s nicht mehr zulassen', 'two-click-embeds' ), $context->label ) );
        $link->setAttribute( 'href', '#' );
        $link->setAttribute( 'data-revoke', $context->slug );

        $wrapper->appendChild( $link );

        return $wrapper;
    }

    /**
     * Generate a source link element
     * @param Embed_Context $context
     * @return \DOMElement
     */
    public function generateSourceLink(
        Embed_Context $context
    ): \DOMElement {
        $srcLink = $this->dom->createElement( 'a' );
        $srcLink->setAttribute( 'class', 'external-2click-src' );
        $srcLink->setAttribute( 'href', $context->element->getAttribute( 'src' ) );
        $srcLink->setAttribute( 'target', '_blank' );
        $srcLink->setAttribute( 'rel', 'noopener noreferrer' );
        $textNode = $this->dom->createTextNode( 'Direktlink: ' . $context->element->getAttribute( 'src' ) );
        $srcLink->appendChild( $textNode );

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
<?php

namespace Two_Click_Embeds\includes;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\provider\Embed_Provider;

class Frontend_Assets {

    public function __construct() {
        add_filter( 'wp_footer', [ $this, 'filterJS' ], 20 );
        add_filter( 'wp_head', [ $this, 'filterCSS' ], 20 );
    }

    public function filterJS() {
        $provider_scripts = [];

        foreach ( Embed_Provider::all() as $provider ) {
            if (!empty($provider['script']) && !empty($provider['slug'])) {
                $provider_scripts[$provider['slug']] = esc_url($provider['script']);
            }
        }
        ?>
        <script type="text/javascript">
            (function() {
                'use strict';

                const COOKIE = '2click_embed_consent';
                const providerScripts = <?php echo wp_json_encode($provider_scripts); ?>;
                const providerState = {};

                function getConsent() {
                    const consent = [];
                    const cookie = document.cookie.split('; ').find(row => row.startsWith(COOKIE + '='));

                    if (cookie) {
                        const value = cookie.split('=')[1];
                        return value.split(',');
                    }
                    
                    return consent;
                }

                function setConsent(consent) {
                    const filtered = consent.filter(Boolean);
                    const date = new Date();
                    date.setTime(date.getTime() + 365*24*60*60*1000);
                    const expires = "expires=" + date.toUTCString();

                    if (filtered.length === 0) {
                        document.cookie = COOKIE + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
                    } else {
                        document.cookie = COOKIE + "=" + filtered.join(',') + ";" + expires + ";path=/";
                    }
                }

                function addConsent(slug) {
                    const consent = getConsent();
                    if (!consent.includes(slug)) {
                        consent.push(slug);
                        setConsent(consent);
                    }
                }

                function removeConsent(slug) {
                    let consent = getConsent();
                    consent = consent.filter(item => item !== slug);
                    setConsent(consent);
                }

                function loadProviderScript(slug) {
                    if (providerScripts[slug]) {
                        const script = document.createElement('script');
                        script.src = providerScripts[slug];
                        script.async = true;
                        document.body.appendChild(script);
                    }
                }

                function loadProviderEmbeds(slug) {
                    document.querySelectorAll(`.external-2click[data-provider-slug="${slug}"]`).forEach(wrapper => {
                        wrapper.classList.add('is-loaded');
                        const target = wrapper.querySelector('.external-2click-target');
                        const placeholder = wrapper.querySelector('.external-placeholder');

                        if (target && target.dataset.src) {
                            target.setAttribute('src', target.dataset.src);
                        }

                        if(placeholder) {
                            placeholder.remove();
                        }
                    });
                    loadProviderScript(slug);
                }

                document.addEventListener('click', function(event) {
                    //load external content
                    if (event.target && event.target.classList.contains('external-load')) {
                        
                        const wrapper = event.target.closest('.external-2click');
                        const slug = wrapper.getAttribute('data-provider-slug');

                        addConsent(slug);
                        loadProviderEmbeds(slug);
                    }

                    //revoke consent
                    if (event.target && event.target.dataset.revoke) {
                        event.preventDefault();
                        const slug = event.target.dataset.revoke;
                        
                        removeConsent(slug);
                        window.location.reload(true);
                    }
                });

                getConsent().forEach(loadProviderEmbeds);
            })();
        </script>
        <?php
    }

    public function filterCSS() {
        ?>
            <style>
                .external-2click {
                    margin: 15px 0;
                    display: flex;
                    flex-direction: column;
                    position: relative;
                    border: 2px black dotted;
                    border-radius: 15px;
                    padding: 2rem;
                    text-align: center;
                    color: black;
                }

                .external-2click .external-2click-target {
                    display: none;
                }

                .external-2click.is-loaded {
                    border: 0 !important;
                }

                .external-2click.is-loaded .external-2click-target {
                    display: block;
                }

                .external-2click .external-optout {
                    display: none;
                    margin-top: 7px !important;
                    font-size: 75% !important;
                    text-align: left;
                }

                .external-2click.is-loaded .external-optout {
                    display: block;
                }

                .external-2click .external-placeholder {
                    margin-bottom: 15px;
                    width: 100%;
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    gap: 1rem;
                    color: #000;
                }

                .external-2click::before {
                    content: attr(data-provider);
                    position: absolute;
                    top: 0.5rem;
                    left: 0.5rem;
                    font-size: 0.75rem;
                    background: #222;
                    color: #fff;
                    padding: 0.2rem 0.5rem;
                    max-width: 90%;
                    overflow: hidden;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                }

                .external-2click iframe {
                    display: none;
                    width: 100%;
                    min-height: 400px;
                    border: 0;
                }

                .external-2click.is-loaded {
                    padding: 0;
                }

                .external-2click.is-loaded::before {
                    display: none;
                }

                .external-2click.is-loaded iframe {
                    display: block;
                    min-height: unset;
                }

                .external-placeholder button {
                    margin-top: 1rem;
                }

                .external-placeholder .external-load {
                    padding: 13px 30px 13px;
                    border-radius: 3px;
                    border: 0;
                    font-family: 'Open Sans', sans-serif;
                    font-size: 13px;
                    font-weight: 500;
                    color: #fff;
                    letter-spacing: 0;
                    text-align: center;
                    background: red;
                    text-decoration: none;
                    text-transform: uppercase;
                }
            </style>
        <?php
    }    
}
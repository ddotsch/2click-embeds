<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

use Two_Click_Embeds\includes\handler\Generic_Iframe_Handler;
use Two_Click_Embeds\includes\handler\Script_After_Embed_Handler;

/**
 * Class Embed_Provider
 * Defines the available embed providers
 * If a new provider is added, it should be added here or via the 'two_click_embeds_providers' filter
 * The definition of a provider can be found in the class-provider-definition.php
 */

final class Embed_Provider
{

    const YOUTUBE       = 'youtube';
    const VIMEO         = 'vimeo';
    const SOUNDCLOUD    = 'soundcloud';
    const TWITTER       = 'twitter';
    const TIKTOK        = 'tiktok';
    const FACEBOOK      = 'facebook';
    const INSTAGRAM     = 'instagram';
    const REDDIT        = 'reddit';
    const PINTEREST     = 'pinterest';
    const SPOTIFY       = 'spotify';
    const WPEMBED       = 'wp-embed';

    /**
     * Get all embed providers
     *
     * @return array An array of all embed providers with their details.
     */
    public static function all(): array
    {
        $providers = [
            self::YOUTUBE => [
                'slug'      => 'youtube',
                'label'     => __('YouTube', 'two-click-embeds' ),
                'xpath'     => '//iframe[contains(@src,"youtube.com") or contains(@src,"youtu.be") or contains(@src,"youtube-nocookie.com")]',
                'text'      => sprintf(
                                __('Beim Laden des Videos werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('YouTube', 'two-click-embeds')
                            ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::VIMEO => [
                'slug'      => 'vimeo',
                'label'     => __('Vimeo', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"vimeo.com")]',
                'text'      => sprintf(
                                __('Beim Laden des Videos werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Vimeo', 'two-click-embeds')
                            ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::SOUNDCLOUD => [
                'slug'      => 'soundcloud',
                'label'     => __('Soundcloud', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"soundcloud.com")]',
                'text'      => sprintf(
                                __('Beim Laden des Audios werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Soundcloud', 'two-click-embeds')
                            ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::TWITTER => [
                'slug'      => 'twitter',
                'label'     => __('X (Twitter)', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"twitter-tweet")]',
                'text'      => sprintf(
                                __('Beim Laden des Tweets werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('X (ehemals Twitter)', 'two-click-embeds')
                            ),
                'script'    => 'https://platform.twitter.com/widgets.js',
                'handler'   => Script_After_Embed_Handler::class,
            ],
            self::TIKTOK => [
                'slug'      => 'tiktok',
                'label'     => __('TikTok', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"tiktok-embed")]',
                'text'      => sprintf(
                                __('Beim Laden des Videos werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('TikTok', 'two-click-embeds')
                            ),
                'script'    => 'https://www.tiktok.com/embed.js',
                'handler'   => Script_After_Embed_Handler::class,
            ],
            self::FACEBOOK => [
                'slug'      => 'facebook',
                'label'     => __('Facebook', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"facebook.com") or contains(@src,"fb.watch")]',
                'text'      => sprintf(
                                __('Beim Laden des Inhalts werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Facebook', 'two-click-embeds')
                            ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::INSTAGRAM => [
                'slug'      => 'instagram',
                'label'     => __('Instagram', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"instagram-media")]',
                'text'      => sprintf(
                                __('Beim Laden des Beitrags werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Instagram', 'two-click-embeds')
                            ),
                'script'    => '//www.instagram.com/embed.js',
                'handler'   => Script_After_Embed_Handler::class,
            ],
            self::REDDIT => [
                'slug'      => 'reddit',
                'label'     => __('Reddit', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"reddit-embed-bq")]',
                'text'      => sprintf(
                                __('Beim Laden des Inhalts werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Reddit', 'two-click-embeds')
                            ),
                'script'    => 'https://embed.reddit.com/widgets.js',
                'handler'   => Script_After_Embed_Handler::class,
            ],
            self::PINTEREST => [
                'slug'      => 'pinterest',
                'label'     => __('Pinterest', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"assets.pinterest.com")]',
                'text'      => sprintf(
                                __('Beim Laden des Pins werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Pinterest', 'two-click-embeds')
                            ),
                'script'    => '',
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::SPOTIFY => [
                'slug'      => 'spotify',
                'label'     => __('Spotify', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"spotify.com")]',
                'text'      => sprintf(
                                __('Beim Laden des Inhalts werden Daten an %s übertragen.', 'two-click-embeds'),
                                __('Spotify', 'two-click-embeds')
                            ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::WPEMBED => [
                'slug'      => '',
                'label'     => '',
                'xpath'     => '//iframe[contains(@class,"wp-embedded-content")]',
                'text'      => '',
                'handler'   => Generic_Iframe_Handler::class,
            ],
        ];
        return apply_filters( 'two_click_embeds_providers', $providers );
    }
}
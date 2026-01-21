<?php

namespace Two_Click_Embeds\includes\provider;

defined( 'ABSPATH' ) || exit;

/**
 * Class Embed_Provider
 * Defines the available embed providers
 * If a new provider is added, it should be added here or via the 'two_click_embeds_providers' filter
 * The definition of a provider can be found in the class-provider-definition.php
 */

final class Embed_Provider {

    const YOUTUBE       = 'youtube';
    const VIMEO         = 'vimeo';
    const SOUNDCLOUD    = 'soundcloud';
    const TWITTER       = 'twitter';
    const TIKTOK        = 'tiktok';
    const FACEBOOK      = 'facebook';
    const INSTAGRAM     = 'instagram';

    /**
     * Get all embed providers
     *
     * @return array An array of all embed providers with their details.
     */
    public static function all(): array {
        $providers = [
            self::YOUTUBE => [
                'slug'      => 'youtube',
                'label'     => __('YouTube', 'two-click-embeds' ),
                'xpath'     => '//iframe[contains(@src,"youtube.com") or contains(@src,"youtu.be") or contains(@src,"youtube-nocookie.com")]',
                'text'      => sprintf( __('Beim Laden des Videos werden Daten an %s übertragen.', 'two-click-embeds'), __('YouTube', 'two-click-embeds') ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::VIMEO => [
                'slug'      => 'vimeo',
                'label'     => __('Vimeo', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"vimeo.com")]',
                'text'      => sprintf( __('Beim Laden des Videos werden Daten an %s übertragen.', 'two-click-embeds'), __('Vimeo', 'two-click-embeds') ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::SOUNDCLOUD => [
                'slug'      => 'soundcloud',
                'label'     => __('Soundcloud', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"soundcloud.com")]',
                'text'      => sprintf( __('Beim Laden des Audios werden Daten an %s übertragen.', 'two-click-embeds'), __('Soundcloud', 'two-click-embeds') ),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::TWITTER => [
                'slug'      => 'twitter',
                'label'     => __('X (Twitter)', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"twitter-tweet")]',
                'text'      => sprintf( __('Beim Laden des Tweets werden Daten an %s übertragen.', 'two-click-embeds'), __('X (ehemals Twitter)', 'two-click-embeds') ),
                'script'    => 'https://platform.twitter.com/widgets.js',
                'handler'   => Twitter_Provider_Handler::class,
            ],
            self::TIKTOK => [
                'slug'      => 'tiktok',
                'label'     => __('TikTok', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"tiktok-embed")]',
                'text'      => sprintf( __('Beim Laden des Videos werden Daten an %s übertragen.', 'two-click-embeds'), __('TikTok', 'two-click-embeds') ),
                'script'    => 'https://www.tiktok.com/embed.js',
                'handler'   => Tiktok_Provider_Handler::class,
            ],
            self::FACEBOOK => [
                'slug'      => 'facebook',
                'label'     => __('Facebook', 'two-click-embeds'),
                'xpath'     => '//iframe[contains(@src,"facebook.com") or contains(@src,"fb.watch")]',
                'text'      => sprintf(__('Beim Laden des Inhalts werden Daten an %s übertragen.', 'two-click-embeds'), __('Facebook', 'two-click-embeds')),
                'handler'   => Generic_Iframe_Handler::class,
            ],
            self::INSTAGRAM => [
                'slug'      => 'instagram',
                'label'     => __('Instagram', 'two-click-embeds'),
                'xpath'     => '//blockquote[contains(@class,"instagram-media")]',
                'text'      => sprintf( __('Beim Laden des Beitrags werden Daten an %s übertragen.', 'two-click-embeds'), __('Instagram', 'two-click-embeds') ),
                'script'    => 'https://www.instagram.com/embed.js',
                'handler'   => Instagram_Provider_Handler::class,
            ],

        ];
        return apply_filters( 'two_click_embeds_providers', $providers );
    }
}
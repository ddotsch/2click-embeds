<?php

/**
 * Plugin Name: 2click Embeds
 * Text Domain: 2click-embeds
 * Domain Path: /languages
 * Description: Datenschutzfreundliche Einbettungen von externen Inhalten
 */

use Two_Click_Embeds\includes\Frontend_Assets;
use Two_Click_Embeds\includes\ContentFilter;

defined( 'ABSPATH' ) || exit;

define( 'TCE_VERSION', '1.0.0' );
define( 'TCE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TCE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

spl_autoload_register(function ($class) {
    $prefix = 'Two_Click_Embeds\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;

    $relative_class = substr($class, $len);

    // explode namespace
    $parts = explode('\\', $relative_class);
    $class_name = array_pop($parts);

    // WP convention: class-{lowercase with dashes}.php
    $file_name = 'class-' . strtolower(str_replace('_', '-', $class_name)) . '.php';
    $parts[] = $file_name;

    $file = $base_dir . implode('/', $parts);

    if (file_exists($file)) {
        require_once $file;
    }
});

add_action('plugins_loaded', function () {
    load_plugin_textdomain('two-click-embeds', false, dirname(plugin_basename(__FILE__)) . '/languages');    
});

add_action('init', function() {
    new Frontend_Assets();
    new ContentFilter();
});
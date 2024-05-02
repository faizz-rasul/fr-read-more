<?php
/*
Plugin Name: FR Read More
Plugin URI: https://downloads.wordpress.org/plugin/fr-read-more
Description: Easily create expandable content sections on your WordPress website with FR Read More. Let your visitors reveal hidden content with a click, perfect for displaying longer text or hiding additional details until needed..
Version: 1.1
Author: Faiz R
Author URI: https://github.com/faizz-rasul
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: fr-read-more
*/
if (!defined("ABSPATH")) exit;

function frrm_read_more_scripts() {
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue fr-read-more JavaScript file
    wp_enqueue_script('fr-read-more', plugins_url('js/fr-read-more.js', __FILE__), array('jquery'), '1.1', true);

    // Pass AJAX URL and nonce to JavaScript
    wp_localize_script('fr-read-more', 'frReadmoreAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('frrm_readmore_nonce'), // Create nonce and pass it to JavaScript
    ));

    // Enqueue fr-read-more CSS file
    wp_enqueue_style('fr-read-more', plugins_url('css/fr-read-more.css', __FILE__), array(), '1.1');
}
add_action('wp_enqueue_scripts', 'frrm_read_more_scripts');


function frrm_readmore_enqueue_color_picker() {
    // Enqueue the color picker JS file
    wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'fr-readmore-color-picker', plugins_url( 'js/fr-readmore-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), '1.1', true );

    // Enqueue the color picker CSS file
	wp_enqueue_style( 'fr-readmore-color-picker-css', plugins_url( 'css/fr-readmore-color-picker.css', __FILE__ ), array(), '1.1' );
	wp_enqueue_style( 'fr-readmore-admin-css', plugins_url( 'css/fr-read-more-admin.css', __FILE__ ), array(), '1.1' );
}
add_action( 'admin_enqueue_scripts', 'frrm_readmore_enqueue_color_picker' );

// load text domain
function frrm_readmore_load_textdomain() {
    load_plugin_textdomain( 'fr-read-more', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'frrm_readmore_load_textdomain' );

// Include the settings file
require_once(plugin_dir_path(__FILE__) . 'includes/fr-read-more-settings.php');

?>
<?php
/*
* Plugin Name: Content Text Editor Plugin
* Description: Plugin for searching posts with the specified text and replacing the text with a new one. The plugin searches by the main fields of posts and meta fields of the popular SEO plugin.
* Version: 1.0
* Author: Viktor Kono
* Author URI: https://codex.wordpress.org/
* Text Domain: content-text-editor-plugin
* Domain Path: /lang
*/

/*
 * Add translate
 */
add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'content-text-editor-plugin', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
} );

if(is_admin()) {

    define( 'DOMAIN', 'content-text-editor-plugin' );
	define('PLUGIN_TEMPLATE_PATH', plugin_dir_path( __FILE__ ));
	define('PLUGIN_TEMPLATE_URI', plugin_dir_url( __FILE__ ));

    // Include class Search_and_replace
    include PLUGIN_TEMPLATE_PATH . 'classes/DataPresenter.php';
	include PLUGIN_TEMPLATE_PATH . 'classes/SearchPosts.php';
	include PLUGIN_TEMPLATE_PATH . 'classes/PostDataReplacer.php';

    // Include actions
    include PLUGIN_TEMPLATE_PATH . 'includes/actions.php';

}
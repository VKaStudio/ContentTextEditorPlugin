<?php

/*
* Add main page of plugin to admin menu
*/
add_action( 'admin_menu', 'test_plugin_admin_page');

function test_plugin_admin_page(): void
{
    add_menu_page(
        __( 'Content Text Editor', DOMAIN ),
        __( 'Content Text Editor', DOMAIN ),
        'manage_options',
        'content-text-editor-plugin',
        'content_text_editor_plugin_main_page',
        'dashicons-schedule',
        20
    );
}

function content_text_editor_plugin_main_page(): void
{
	include PLUGIN_TEMPLATE_PATH . 'templates/main-page.php';
}

add_action( 'wp_ajax_content-text-editor-plugin-search-action', 'test_plugin_search_action_callback' );
add_action( 'wp_ajax_nopriv_content-text-editor-plugin-search-action', 'test_plugin_search_action_callback' );

function test_plugin_search_action_callback(): void
{
	$keyword = $_GET['value'];
	if (empty($keyword)) wp_die('value is empty');

    $posts = new SearchPosts($keyword);
	$postIds = $posts->getPostIds();

	$presenter = new DataPresenter($postIds);
	$dataPosts = $presenter->providePostsData();

	ob_start();
	include PLUGIN_TEMPLATE_PATH . 'templates/table-of-posts.php';
	$output = ob_get_clean();
	echo $output;

    wp_die();
}

add_action( 'wp_ajax_content-text-editor-plugin-replace-action', 'test_plugin_replace_action_callback' );
add_action( 'wp_ajax_nopriv_content-text-editor-plugin-replace-action', 'test_plugin_replace_action_callback' );

function test_plugin_replace_action_callback(): void
{
	$keyword = $_POST['text'];
	$oldKeyword = $_POST['oldText'];
	$fieldKey = $_POST['field'];
	$postIds = $_POST['ids'];
	if (empty($keyword) || empty($oldKeyword)) wp_die('value is empty');
	if (empty($postIds)) wp_die('no posts');

	$replacer = new PostDataReplacer($postIds);
	$replacer->replaceFields($oldKeyword, $keyword, $fieldKey);

	$presenter = new DataPresenter($postIds);
	$dataPosts = $presenter->providePostsData();

	ob_start();
	include PLUGIN_TEMPLATE_PATH . 'templates/table-of-posts.php';
	$output = ob_get_clean();
	echo $output;

    wp_die();
}

/**
 * necessary scripts
 */
function register_db_plugin_scripts(): void
{
    wp_register_script( 'content-text-editor-plugin', plugins_url( 'content-text-editor-plugin/js/script.js' ) );
}

add_action( 'admin_enqueue_scripts', 'register_db_plugin_scripts' );

function load_test_plugin_scripts( $hook ): void
{
    // Load only on ?page=content-text-editor-plugin
    if( $hook != 'toplevel_page_content-text-editor-plugin' ) {
        return;
    }

    // Load style & scripts.
    wp_enqueue_script( 'content-text-editor-plugin' );
	wp_enqueue_style( 'main-style', PLUGIN_TEMPLATE_URI . 'css/style.css' );
}

add_action( 'admin_enqueue_scripts', 'load_test_plugin_scripts' );
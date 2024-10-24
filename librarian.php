<?php
/**
 * Plugin Name: Librarian
 * Version: 1.0
 * Author: Okky Adiansyah
 * Description: Manage book collections, chapter collections, and page collections use for headless book reading application platform
 * Text Domain: librarian 
 */
if( ! defined( 'ABSPATH' ) ){
    exit;
}

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ){
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

if( file_exists( dirname( __FILE__ ) . '/src/hooks/plugin-hook.php') ){
    require_once dirname( __FILE__ ) . '/src/hooks/plugin-hook.php';
}

use Librarian\Plugin;

$plugin = new Plugin();
$plugin->librarian_init();

register_activation_hook( __FILE__, array( $plugin, 'librarian_plugin_activate' ));
register_deactivation_hook( __FILE__, array( $plugin, 'librarian_plugin_deactivate' ) );
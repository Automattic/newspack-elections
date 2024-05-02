<?php
/**
 * Plugin Name:       Govpack
 * Plugin URI:        https://govpack.org/
 * Description:       Govpack
 * Author:            Govpack, poweredbycoffee, thefuturewasnow
 * Text Domain:       govpack
 * Domain Path:       /languages
 * Version:           1.1.0
 * Requires at least: 5.9 
 *
 * @package         Govpack
 */

defined( 'ABSPATH' ) || exit;


// Define GOVPACK_PLUGIN_FILE.
if ( ! defined( 'GOVPACK_PLUGIN_FILE' ) ) {
	define( 'GOVPACK_PLUGIN_FILE', trailingslashit(plugin_dir_path( __FILE__ )) );
	define( 'GOVPACK_PLUGIN_PATH', GOVPACK_PLUGIN_FILE );
}

if ( ! defined( 'GOVPACK_PLUGIN_BUILD_PATH' ) ) {
	define( 'GOVPACK_PLUGIN_BUILD_PATH', trailingslashit(GOVPACK_PLUGIN_PATH . 'build') );
}

if ( ! defined( 'GOVPACK_PLUGIN_URL' ) ) {
	define( 'GOVPACK_PLUGIN_URL', trailingslashit(plugin_dir_url( __FILE__ )));
}


if ( ! defined( 'GOVPACK_PLUGIN_BUILD_URL' ) ) {
	define( 'GOVPACK_PLUGIN_BUILD_URL', trailingslashit(GOVPACK_PLUGIN_URL . 'build') );
}

require_once GOVPACK_PLUGIN_PATH . "autoloader.php";


// Include the main Govpack class.
if ( class_exists( '\Govpack\Core\Govpack' ) ) {
	$GLOBALS['govpack'] = \Govpack\Core\Govpack::instance();
}

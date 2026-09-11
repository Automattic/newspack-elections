<?php
/**
 * Plugin Name:       Newspack Elections
 * Plugin URI:        https://newspack.org/
 * Description:       Newspack Elections
 * Author:            Automattic, poweredbycoffee, thefuturewasnow
 * Author URI:        https://automattic.com/
 * Text Domain:       newspack-elections
 * Domain Path:       /languages
 * Version:           2.0.4
 * Requires at least: 6.7
 * License:           GPL2
 *
 * @package         Newspack_Elections
 */

defined( 'ABSPATH' ) || exit;



// Define GOVPACK_PLUGIN_FILE.
if ( ! defined( 'GOVPACK_PLUGIN_FILE' ) ) {
	define( 'GOVPACK_PLUGIN_FILE', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	define( 'GOVPACK_PLUGIN_PATH', GOVPACK_PLUGIN_FILE );
}

if ( ! defined( 'GOVPACK_PLUGIN_BUILD_PATH' ) ) {
	define( 'GOVPACK_PLUGIN_BUILD_PATH', trailingslashit( GOVPACK_PLUGIN_PATH . 'build' ) );
}

if ( ! defined( 'GOVPACK_PLUGIN_URL' ) ) {
	define( 'GOVPACK_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

if ( ! defined( 'GOVPACK_PLUGIN_BUILD_URL' ) ) {
	define( 'GOVPACK_PLUGIN_BUILD_URL', trailingslashit( GOVPACK_PLUGIN_URL . 'build' ) );
}

if ( ! class_exists( 'Govpack_Bootstrap_Helper' ) ) {
	require_once __DIR__ . '/includes/BootstrapHelper.php';
} elseif ( method_exists( 'Govpack_Bootstrap_Helper', 'notice_double_install' ) ) {
	add_action( 'all_admin_notices', 'Govpack_Bootstrap_Helper::notice_double_install' );
	return;
} else {
	require_once __DIR__ . '/includes/NPEBootstrapHelper.php';
	add_action( 'all_admin_notices', 'NPE_Bootstrap_Helper::notice_double_install' );
	return;
}

if ( ! file_exists( GOVPACK_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	add_action( 'all_admin_notices', 'Govpack_Bootstrap_Helper::notice_vendor_missing' );
	return;
}



if ( ! is_dir( GOVPACK_PLUGIN_PATH . 'build' ) ) {
	add_action( 'all_admin_notices', 'Govpack_Bootstrap_Helper::notice_build_missing' );
	return;
}

require_once GOVPACK_PLUGIN_FILE . 'vendor/autoload.php';
require_once GOVPACK_PLUGIN_FILE . 'vendor-prefixed/autoload.php';



// Include the main Govpack class.
if ( class_exists( '\Govpack\Govpack' ) ) {

	$GLOBALS['govpack'] = ( \Govpack\Govpack::instance() )
		->set_uri( "newspack-elections" )
		->set_path( GOVPACK_PLUGIN_PATH )
		->set_url( GOVPACK_PLUGIN_URL );
	$GLOBALS['govpack']->init();

	register_activation_hook( __FILE__, [ $GLOBALS['govpack'], 'activation' ] );
	register_deactivation_hook( __FILE__, [ $GLOBALS['govpack'], 'deactivation' ] );
}

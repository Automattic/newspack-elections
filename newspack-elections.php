<?php
/**
 * Plugin Name:       Newspack Elections
 * Plugin URI:        https://newspack.org/
 * Description:       Newspack Elections
 * Author:            Automattic, poweredbycoffee, thefuturewasnow
 * Author URI:        https://automattic.com/
 * Text Domain:       newspack-elections
 * Domain Path:       /languages
 * Version:           1.2.0
 * Requires at least: 6.4 
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

require_once __DIR__ . '/includes/class-bootstrap-helper.php';

if ( ! file_exists( GOVPACK_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	add_action( 'all_admin_notices', 'Govpack_Bootstrap_Helper::notice_vendor_missing' );
	return;
}

if ( Govpack_Bootstrap_Helper::is_dir_empty( GOVPACK_PLUGIN_PATH . 'vendor-prefixed' ) ) {
	add_action( 'all_admin_notices', 'Govpack_Bootstrap_Helper::notice_prefixed_vendor_missing' );
	return;
}

if ( ! is_dir( GOVPACK_PLUGIN_PATH . 'build' ) ) {
	add_action( 'all_admin_notices', 'Govpack_Bootstrap_Helper::notice_build_missing' );
	return;
}

require_once GOVPACK_PLUGIN_PATH . 'autoloader.php';


// Include the main Govpack class.
if ( class_exists( '\Govpack\Core\Govpack' ) ) {
	$GLOBALS['govpack'] = \Govpack\Core\Govpack::instance();
	register_activation_hook( __FILE__, [ $GLOBALS['govpack'], 'activation' ] );
}

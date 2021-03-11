<?php
/**
 * Plugin Name:     Govpack
 * Plugin URI:      https://newspack.pub
 * Description:     Govpack TK
 * Author:          Paul Schreiber
 * Author URI:      https://newspack.pub
 * Text Domain:     govpack
 * Domain Path:     /languages
 * Version:         0.0.0
 *
 * @package         Govpack
 */

defined( 'ABSPATH' ) || exit;

// Define GOVPACK_PLUGIN_FILE.
if ( ! defined( 'GOVPACK_PLUGIN_FILE' ) ) {
	define( 'GOVPACK_PLUGIN_FILE', plugin_dir_path( __FILE__ ) );
}

// Include the main Govpack class.
if ( ! class_exists( 'Govpack' ) ) {
	require_once dirname( __FILE__ ) . '/includes/class-govpack.php';
}

/*
// require_once __DIR__ . '/fieldmanager/fieldmanager.php';
// require_once __DIR__ . '/cmb2/init.php';.
*/


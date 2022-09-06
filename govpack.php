<?php
/**
 * Plugin Name:     Govpack
 * Plugin URI:      https://govpack.org/
 * Description:     Govpack
 * Author:          Govpack, poweredbycoffee, thefuturewasnow
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

// Define GOVPACK_PLUGIN_URL.
if ( ! defined( 'GOVPACK_PLUGIN_URL' ) ) {
	define( 'GOVPACK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'GOVPACK_PLUGIN_ASSETS_URL' ) ) {
	define( 'GOVPACK_PLUGIN_ASSETS_URL', GOVPACK_PLUGIN_URL . 'dist/' );
}


require_once GOVPACK_PLUGIN_FILE . 'vendor/autoload.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once GOVPACK_PLUGIN_FILE . 'vendor/woocommerce/action-scheduler/action-scheduler.php';// phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant



use Pablo_Pacheco\WP_Namespace_Autoloader\WP_Namespace_Autoloader;




$autoloader = new WP_Namespace_Autoloader(
	[
		'directory'        => __DIR__,       // Directory of your project. It can be your theme or plugin. Defaults to __DIR__ (probably your best bet).
		'namespace_prefix' => 'Govpack\Core', // Main namespace of your project. E.g My_Project\Admin\Tests should be My_Project. Defaults to the namespace of the instantiating file.
		'classes_dir'      => 'includes',         // (optional). It is where your namespaced classes are located inside your project. If your classes are in the root level, leave this empty. If they are located on 'src' folder, write 'src' here
	]
);
$autoloader->init();

$blocks_autoloader = new WP_Namespace_Autoloader(
	[
		'directory'        => __DIR__,       // Directory of your project. It can be your theme or plugin. Defaults to __DIR__ (probably your best bet).
		'namespace_prefix' => 'Govpack\Blocks', // Main namespace of your project. E.g My_Project\Admin\Tests should be My_Project. Defaults to the namespace of the instantiating file.
		'classes_dir'      => 'src/blocks',         // (optional). It is where your namespaced classes are located inside your project. If your classes are in the root level, leave this empty. If they are located on 'src' folder, write 'src' here
		'debug'            => true,
	]
);
$blocks_autoloader->init();

// Include the main Govpack class.
if ( class_exists( '\Govpack\Core\Govpack' ) ) {
	$GLOBALS['govpack'] = \Govpack\Core\Govpack::instance();
}

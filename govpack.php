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

require_once GOVPACK_PLUGIN_FILE . '/vendor/autoload.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

use Pablo_Pacheco\WP_Namespace_Autoloader\WP_Namespace_Autoloader;
$autoloader = new WP_Namespace_Autoloader(
	[    
		'directory'        => __DIR__,       // Directory of your project. It can be your theme or plugin. Defaults to __DIR__ (probably your best bet). 	
		'namespace_prefix' => 'Newspack\Govpack', // Main namespace of your project. E.g My_Project\Admin\Tests should be My_Project. Defaults to the namespace of the instantiating file.	
		'classes_dir'      => 'includes',         // (optional). It is where your namespaced classes are located inside your project. If your classes are in the root level, leave this empty. If they are located on 'src' folder, write 'src' here 
	] 
);
$autoloader->init();


// Include the main Govpack class.
if ( class_exists( '\Newspack\Govpack\Govpack' ) ) {
	
	\Newspack\Govpack\Govpack::instance();
}

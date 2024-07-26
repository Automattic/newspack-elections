<?php
use Govpack\Vendor\Pablo_Pacheco\WP_Namespace_Autoloader\WP_Namespace_Autoloader;


require_once GOVPACK_PLUGIN_FILE . 'vendor-prefixed/autoload.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once GOVPACK_PLUGIN_FILE . 'vendor/autoload.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
require_once GOVPACK_PLUGIN_FILE . 'vendor/woocommerce/action-scheduler/action-scheduler.php';// phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant


$autoloader = new WP_Namespace_Autoloader(
	[
		'directory'         => __DIR__,       // Directory of your project. It can be your theme or plugin. Defaults to __DIR__ (probably your best bet).
		'namespace_prefix'  => "Govpack\Core", // Main namespace of your project. E.g My_Project\Admin\Tests should be My_Project. Defaults to the namespace of the instantiating file.
		'classes_dir'       => 'includes',         // (optional). It is where your namespaced classes are located inside your project. If your classes are in the root level, leave this empty. If they are located on 'src' folder, write 'src' here
		'debug'             => true,
		'prepend_interface' => false,
		'prepend_trait'     => true,
		'prepend_abstract'  => true,
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

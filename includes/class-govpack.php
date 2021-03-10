<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;

require_once GOVPACK_PLUGIN_FILE . '/vendor/autoload.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant

/**
 * Main Govpack Class.
 */
class Govpack {
	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Govpack', 'hooks' ] );

require_once __DIR__ . '/cpt/class-profile.php';
require_once __DIR__ . '/class-helpers.php';

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

// Helper classes.
require_once __DIR__ . '/class-helpers.php';
require_once __DIR__ . '/class-taxonomy.php';

// Post types.
require_once __DIR__ . '/cpt/class-profile.php';

// Taxonomies.
require_once __DIR__ . '/tax/class-city.php';
require_once __DIR__ . '/tax/class-county.php';
require_once __DIR__ . '/tax/class-installation.php';
require_once __DIR__ . '/tax/class-legislative-body.php';
require_once __DIR__ . '/tax/class-officeholder-status.php';
require_once __DIR__ . '/tax/class-party.php';
require_once __DIR__ . '/tax/class-state.php';

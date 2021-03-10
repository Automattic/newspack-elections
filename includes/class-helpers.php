<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class Helpers {
	/**
	 * List honorific name prefixes.
	 *
	 * @return array
	 */
	public static function prefixes() {
		$data = file_get_contents( GOVPACK_PLUGIN_FILE . 'assets/json/prefixes.json' );
		return json_decode( $data, true );
	}

	/**
	 * List political parties.
	 *
	 * @return array
	 */
	public static function parties() {
		$data = file_get_contents( GOVPACK_PLUGIN_FILE . 'assets/json/parties.json' );
		return json_decode( $data, true );
	}

	/**
	 * List US states and territories.
	 *
	 * @return array
	 */
	public static function states() {
		$data = file_get_contents( GOVPACK_PLUGIN_FILE . 'assets/json/states.json' );
		return json_decode( $data, true );
	}

}

/**
 * Log data to file.
 *
 * @param string $data Data to log.
 */
function gp_log( $data ) {
	if ( defined( 'WP_ENVIRONMENT_TYPE' ) && 'production' === 'WP_ENVIRONMENT_TYPE' ) {
		return;
	}

	file_put_contents( ABSPATH . WP_DEBUG_LOG, $data . "\n", FILE_APPEND ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.file_ops_file_put_contents
}

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

	const CACHE_GROUP = 'govpack';

	/**
	 * List honorific name prefixes.
	 *
	 * @return array
	 */
	public static function prefixes() {
		$cache_key = 'govpack_prefixes';

		$prefixes = wp_cache_get( $cache_key );
		if ( false === $prefixes ) {
			$data     = file_get_contents( GOVPACK_PLUGIN_FILE . 'assets/json/prefix.json' );
			$prefixes = json_decode( $data, true );

			if ( json_last_error() === JSON_ERROR_NONE && $prefixes ) {
				wp_cache_set( $cache_key, $prefixes, self::CACHE_GROUP, 3600 );
			}
		}

		return $prefixes;
	}

	/**
	 * List US states and territories.
	 *
	 * @return array
	 */
	public static function states() {
		$cache_key = 'govpack_states';

		$states = wp_cache_get( $cache_key );
		if ( false === $states ) {
			$data   = file_get_contents( GOVPACK_PLUGIN_FILE . 'assets/json/state.json' );
			$states = json_decode( $data, true );

			if ( json_last_error() === JSON_ERROR_NONE && $states ) {
				wp_cache_set( $cache_key, $states, self::CACHE_GROUP, 3600 );
			}
		}

		return $states;
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

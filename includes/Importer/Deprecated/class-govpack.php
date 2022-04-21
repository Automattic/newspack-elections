<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Newspack\Govpack\Importer;

/**
 * Register and handle the "USIO" Importer
 */
class Govpack extends \Newspack\Govpack\Importer {

	const GOVPACK_ID = 0;

	/**
	 * Parse a line of CSV dara..
	 *
	 * @param array $data   Array of raw profile data.
	 *
	 * @return array Array of profile data.
	 */
	public static function parse( $data ) {
		$profile = [
			'govpack_id' => $data[ self::GOVPACK_ID ],
		];

		return array_filter( $profile );
	}
}

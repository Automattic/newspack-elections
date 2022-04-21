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
class UnitedStatesIO extends \Newspack\Govpack\Importer {

	const LAST_NAME        = 0;
	const FIRST_NAME       = 1;
	const MIDDLE_NAME      = 2;
	const NICKNAME         = 4;
	const TITLE            = 8;
	const STATE            = 9;
	const PARTY            = 12;
	const LEGISLATIVE_BODY = 8;
	const LEG_URL          = 13;
	const LEG_ADDRESS      = 14;
	const LEG_PHONE        = 15;
	const TWITTER          = 18;
	const FACEBOOK         = 19;
	const GOVPACK_ID       = 22;

	/**
	 * Standardize titles.
	 *
	 * @var array
	 */
	public static $title_map = [
		'rep' => 'Representative',
		'sen' => 'Senator',
	];

	/**
	 * Map title abbreviations to legislative body names.
	 *
	 * @var array
	 */
	public static $title_to_leg_body_map = [
		'rep' => 'US House',
		'sen' => 'US Senate',
	];

	/**
	 * Parse a line of CSV dara..
	 *
	 * @param array $data   Array of raw profile data.
	 *
	 * @return array Array of profile data.
	 */
	public static function parse( $data ) {
		$address = [];
		preg_match( '/(?P<address>.+?) (?P<city>Washington) (?P<state>\w{2}) (?P<zip>\d{5}(?:-\d{4})?)/', $data[ self::LEG_ADDRESS ], $address );

		/*
		 * If there is a nickname, use that.
		 * If no nickname, check for first initial only; use a middle name there.
		 * If neither other case occurs, use the first name.
		 */
		if ( $data[ self::NICKNAME ] ) {
			$first_name = $data[ self::NICKNAME ];
		} elseif ( preg_match( '/^\w\.$/', $data[ self::FIRST_NAME ] ) ) {
			$first_name = $data[ self::MIDDLE_NAME ];

			// C. A. Dutch Ruppersberger's middle name is "A. Dutch", and we want "Dutch".
			$matches = [];
			if ( preg_match( '/^\w\. (\w+)$/', $data[ self::MIDDLE_NAME ], $matches ) ) {
				$first_name = $matches[1];
			}
		} else {
			$first_name = $data[ self::FIRST_NAME ];
		}

		$profile = [
			'govpack_id'          => $data[ self::GOVPACK_ID ],
			'last_name'           => $data[ self::LAST_NAME ],
			'first_name'          => $first_name,
			'title'               => self::$title_map[ $data[ self::TITLE ] ],
			'state'               => static::$state_list[ static::$state_abbrevations[ $data[ self::STATE ] ] ],
			'party'               => static::$party_list[ $data[ self::PARTY ] ],
			'legislative_body'    => static::$leg_body_list[ self::$title_to_leg_body_map[ $data[ self::LEGISLATIVE_BODY ] ] ],
			'main_office_address' => $address['address'],
			'main_office_city'    => $address['city'],
			'main_office_state'   => $address['state'],
			'main_office_zip'     => $address['zip'],
			'leg_url'             => $data[ self::LEG_URL ],
			'main_phone'          => $data[ self::LEG_PHONE ],
		];

		if ( $data[ self::TWITTER ] ) {
			$profile['twitter'] = \Newspack\Govpack\Helpers::TWITTER_BASE_URL . $data[ self::TWITTER ];
		}

		if ( $data[ self::FACEBOOK ] ) {
			$profile['facebook'] = \Newspack\Govpack\Helpers::FACEBOOK_BASE_URL . $data[ self::FACEBOOK ];
		}

		return array_filter( $profile );
	}
}

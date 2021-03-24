<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

/**
 * Register and handle the "OpenStates" Importer
 */
class OpenStates extends \Newspack\Govpack\Importer {

	const GOVPACK_ID       = 0;
	const FULL_NAME        = 1;
	const LAST_NAME        = 6;
	const FIRST_NAME       = 5;
	const PARTY            = 2;
	const LEGISLATIVE_BODY = 4;
	const EMAIL            = 8;
	const BIOGRAPHY        = 9;
	const IMAGE_URL        = 12;
	const LEG_URL          = 13;
	const SOURCE           = 14;
	const LEG_ADDRESS      = 15;
	const LEG_PHONE        = 16;
	const DISTRICT_ADDRESS = 18;
	const DISTRICT_PHONE   = 19;
	const TWITTER          = 21;
	const INSTAGRAM        = 23;
	const FACEBOOK         = 24;

	/**
	 * Standardize party names to noun form.
	 *
	 * @var array
	 */
	public static $party_map = [
		'Democratic' => 'Democrat',
		'Republican' => 'Republican',
	];

	/**
	 * Map chambers to title names.
	 *
	 * @var array
	 */
	public static $leg_body_to_title_map = [
		'lower'       => 'State Representative',
		'legislature' => 'State Representative', // Nebraska.
		'upper'       => 'State Senator',
	];

	/**
	 * Map chambers to legislative body names.
	 *
	 * @var array
	 */
	public static $leg_body_map = [
		'lower'       => 'State House',
		'legislature' => 'State House', // Nebraska.
		'upper'       => 'State Senate',
	];

	/**
	 * Parse a line of CSV dara..
	 *
	 * @param array  $data    Array of raw profile data.
	 * @param string $state   State to assign to profile.
	 *
	 * @return array Array of profile data.
	 */
	public static function parse( $data, $state = false ) {
		if ( $state && ! isset( static::$state_abbrevations[ $state ] ) ) {
			\WP_CLI::Error( "$state is not a valid state abbreviation." );
		}

		// Some Open States' legislators don't have first and last names.
		// See https://github.com/openstates/issues/issues/365.
		if ( empty( $data[ self::FIRST_NAME ] ) || empty( $data[ self::LAST_NAME ] ) ) {

			// Remove suffixes from names.
			$full_name = explode( ', ', $data[ self::FULL_NAME ] )[0];

			$name_parts               = explode( ' ', $full_name );
			$first_name               = join( ' ', array_slice( $name_parts, 0, -1 ) );
			$last_name                = join( ' ', array_slice( $name_parts, -1 ) );
			$data[ self::FIRST_NAME ] = $first_name;
			$data[ self::LAST_NAME ]  = $last_name;

			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				\WP_CLI::warning( "No first or last name found for {$data[self::GOVPACK_ID]}. Deriving name [$first_name] [$last_name]." );
			}
		}

		$first_name_parts = explode( ' ', $data[ self::FIRST_NAME ] );
		if ( 2 === count( $first_name_parts ) ) {
			// If of the format "First M.", remove middle initial.
			if ( 2 === strlen( $first_name_parts[1] ) && '.' === $first_name_parts[1][1] ) {
				$data[ self::FIRST_NAME ] = $first_name_parts[0];

				// If of the format "F. Middle", remove first initial.
			} elseif ( 2 === strlen( $first_name_parts[0] ) && '.' === $first_name_parts[0][1] ) {
				$data[ self::FIRST_NAME ] = $first_name_parts[1];
			}
		}

		$leg_address      = [];
		$district_address = [];

		// AR addresses don't have the state specified.
		// See https://github.com/openstates/openstates-scrapers/pull/3635.
		if ( false !== strpos( $data[ self::SOURCE ], 'state.ar.us' ) ) {
			preg_match( '/^(?P<address>.+), (?P<city>[^,]+),? (?P<zip>\d{5}(?:-\d{4})?)$/', $data[ self::DISTRICT_ADDRESS ], $district_address );

			$district_address['state'] = 'AR';

			if ( isset( $district_address['address'] ) ) {
				$district_address['address'] = join( "\n", preg_split( '/; ?/', $district_address['address'], -1, PREG_SPLIT_NO_EMPTY ) );
			}
		} else {
			preg_match( '/^(?P<address>.+)(;|,) ?(?P<city>[^,;]+),? (?P<state>(?:\w{2}|Virginia)),? (?P<zip>\d{5}(?:-\d{4})?)$/', $data[ self::LEG_ADDRESS ], $leg_address );
			preg_match( '/^(?P<address>.+)(;|,) ?(?P<city>[^,;]+),? (?P<state>(?:\w{2}|Virginia)),? (?P<zip>\d{5}(?:-\d{4})?)$/', $data[ self::DISTRICT_ADDRESS ], $district_address );

			// Split address parts in to lines.
			if ( isset( $leg_address['address'] ) ) {
				$leg_address['address'] = join( "\n", preg_split( '/; ?/', $leg_address['address'], -1, PREG_SPLIT_NO_EMPTY ) );
			}

			if ( isset( $district_address['address'] ) ) {
				$district_address['address'] = join( "\n", preg_split( '/; ?/', $district_address['address'], -1, PREG_SPLIT_NO_EMPTY ) );
			}
		}

		// Vermont state reps can belong to multiple parties. Need to split on / and create an array of parties.
		$parties = array_map(
			function( $item ) {
				return isset( self::$party_map[ $item ] ) ? static::$party_list[ self::$party_map[ $item ] ] : static::$party_list[ $item ];
			},
			explode( '/', $data[ self::PARTY ] )
		);

		if ( ! $state ) {
			// Many VA legislators have "Virginia" as state instead of "VA".
			if ( isset( $leg_address['state'] ) && 'Virginia' === $leg_address['state'] ) {
				$leg_address['state'] = 'VA';
			}

			if ( isset( $district_address['state'] ) && 'Virginia' === $district_address['state'] ) {
				$district_address['state'] = 'VA';
			}

			// Some TX legislators' addresses don't parse.
			// Some UT legislators are missing states or have "Utah" instead of "UT".
			// Some VA legislators still lack addresses.
			// Some WA legislators lack addresses.
			if ( empty( $leg_address['state'] ) && empty( $district_address['state'] ) ) {
				if ( preg_match( '/texas\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'TX';
				} elseif ( preg_match( '/utah\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'UT';
				} elseif ( preg_match( '/virginia\.gov|virginiageneralassembly\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'VA';
				} elseif ( preg_match( '/wa\.gov|wastateleg\.org/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'WA';
				} elseif ( preg_match( '/scstatehouse\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'SC';
				} elseif ( preg_match( '/sdlegislature\.gov|legis\.sd\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'SD';
				} elseif ( preg_match( '/rilegislature\.gov|ri\.us/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'RI';
				} elseif ( preg_match( '/tucamarapr\.org|pr\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'PR';
				} elseif ( preg_match( '/legis\.state\.pa\.us/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'PA';
				} elseif ( preg_match( '/oregonlegislature\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'OR';
				} elseif ( preg_match( '/nysenate\.gov/', $data[ self::SOURCE ] ) ) {
					$leg_address['state'] = 'NY';
				}
			}

			$state = $leg_address['state'] ?? $district_address['state'] ?? '';
		}

		if ( ! $state ) {
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				\WP_CLI::warning( "Could not determine state for profile ID {$data[self::GOVPACK_ID]}." );
			}
			return [];
		}

		// When multiple URLs are found, last URL is most recent.
		$leg_urls = explode( ';', $data[ self::LEG_URL ] );
		$leg_url  = end( $leg_urls );

		$profile = [
			'govpack_id'               => $data[ self::GOVPACK_ID ],
			'last_name'                => $data[ self::LAST_NAME ],
			'first_name'               => $data[ self::FIRST_NAME ],
			'title'                    => self::$leg_body_to_title_map[ $data[ self::LEGISLATIVE_BODY ] ],

			'state'                    => $state,
			'party'                    => $parties,
			'legislative_body'         => self::$leg_body_map[ $data[ self::LEGISLATIVE_BODY ] ],

			'email'                    => $data[ self::EMAIL ],
			'biography'                => $data[ self::BIOGRAPHY ],
			'image'                    => $data[ self::IMAGE_URL ],

			'main_office_address'      => $leg_address['address'] ?? '',
			'main_office_city'         => $leg_address['city'] ?? '',
			'main_office_state'        => $leg_address['state'] ?? '',
			'main_office_zip'          => $leg_address['zip'] ?? '',
			'main_phone'               => $data[ self::LEG_PHONE ],
			'secondary_office_address' => $district_address['address'] ?? '',
			'secondary_office_city'    => $district_address['city'] ?? '',
			'secondary_office_state'   => $district_address['state'] ?? '',
			'secondary_office_zip'     => $district_address['zip'] ?? '',
			'secondary_phone'          => $data[ self::DISTRICT_PHONE ],

			'leg_url'                  => $leg_url,
		];

		if ( $data[ self::TWITTER ] ) {
			$profile['twitter'] = \Newspack\Govpack\Helpers::TWITTER_BASE_URL . $data[21];
		}

		if ( $data[24] ) {
			$profile['facebook'] = \Newspack\Govpack\Helpers::FACEBOOK_BASE_URL . $data[24];
		}

		if ( $data[23] ) {
			$profile['instagram'] = \Newspack\Govpack\Helpers::INSTAGRAM_BASE_URL . $data[23];
		}

		return array_filter( $profile );
	}
}

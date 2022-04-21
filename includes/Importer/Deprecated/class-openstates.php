<?php
/**
 * Govpack
 *
 * @package Govpack
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
			$full_name = trim( explode( ', ', $data[ self::FULL_NAME ] )[0] );

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
			if ( preg_match( '/akleg\.gov|w3\.akleg\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'AK';
			} elseif ( preg_match( '/legislature\.state\.al\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'AL';
			} elseif ( preg_match( '/arkleg\.state\.ar\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'AR';
			} elseif ( preg_match( '/azleg\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'AZ';
			} elseif ( preg_match( '/assembly\.ca\.gov|senate\.ca\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'CA';
			} elseif ( preg_match( '/leg\.colorado\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'CO';
			} elseif ( preg_match( '/cga\.ct\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'CT';
			} elseif ( preg_match( '/dccouncil\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'DC';
			} elseif ( preg_match( '/legis\.delaware\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'DE';
			} elseif ( preg_match( '/flsenate\.gov|myfloridahouse\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'FL';
			} elseif ( preg_match( '/house\.ga\.gov|legis\.ga\.gov|senate\.ga\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'GA';
			} elseif ( preg_match( '/capitol\.hawaii\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'HI';
			} elseif ( preg_match( '/legis\.iowa\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'IA';
			} elseif ( preg_match( '/legislature\.idaho\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'ID';
			} elseif ( preg_match( '/ilga\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'IL';
			} elseif ( preg_match( '/iga\.in\.gov|api\.iga\.in\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'IN';
			} elseif ( preg_match( '/kslegislature\.org/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'KS';
			} elseif ( preg_match( '/legislature\.ky\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'KY';
			} elseif ( preg_match( '/house\.louisiana\.gov|senate\.la\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'LA';
			} elseif ( preg_match( '/malegislature\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MA';
			} elseif ( preg_match( '/mgaleg\.maryland\.gov|msa\.maryland\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MD';
			} elseif ( preg_match( '/legislature\.maine\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'ME';
			} elseif ( preg_match( '/housedems\.com|house\.mi\.gov|senatedems\.com|senate\.michigan\.gov|gophouse\.org|senatoraricnesbitt\.com|senatorcurtvanderwall\.com|senatordanlauwers\.com|senatoredmcbroom\.com|senatorjimrunestad\.com|senatorjohnbizon\.com|senatorjonbumstead\.com|senatorkevindaley\.com|statesenatorkimlasata\.com|senatorlanatheis\.com|SenatorMichaelMacDonald\.com|senatorpetelucido\.com|senatorrickoutman\.com|senatorrogervictory\.com|senatorruthjohnson\.com|senatortombarrett\.com/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MI';
			} elseif ( preg_match( '/house\.leg\.state\.mn\.us|senate\.mn/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MN';
			} elseif ( preg_match( '/house\.mo\.gov|senate\.mo\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MO';
			} elseif ( preg_match( '/\.ls\.state\.ms\.us|legislature\.ms\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MS';
			} elseif ( preg_match( '/leg\.mt\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'MT';
			} elseif ( preg_match( '/ncleg\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NC';
			} elseif ( preg_match( '/legis\.nd\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'ND';
			} elseif ( preg_match( '/news\.legislature\.ne\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NE';
			} elseif ( preg_match( '/gencourt\.state\.nh\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NH';
			} elseif ( preg_match( '/njleg\.state\.nj\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NJ';
			} elseif ( preg_match( '/nmlegis\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NM';
			} elseif ( preg_match( '/leg\.state\.nv\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NV';
			} elseif ( preg_match( '/assembly\.state\.ny\.us|nysenate\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'NY';
			} elseif ( preg_match( '/ohiohouse\.gov|ohiosenate\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'OH';
			} elseif ( preg_match( '/oksenate\.gov|okhouse\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'OK';
			} elseif ( preg_match( '/oregonlegislature\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'OR';
			} elseif ( preg_match( '/legis\.state\.pa\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'PA';
			} elseif ( preg_match( '/tucamarapr\.org|senado\.pr\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'PR';
			} elseif ( preg_match( '/rilegislature\.gov|rilin\.state\.ri\.us/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'RI';
			} elseif ( preg_match( '/scstatehouse\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'SC';
			} elseif ( preg_match( '/sdlegislature\.gov|legis\.sd\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'SD';
			} elseif ( preg_match( '/capitol\.tn\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'TN';
			} elseif ( preg_match( '/\.texas\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'TX';
			} elseif ( preg_match( '/le\.utah\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'UT';
			} elseif ( preg_match( '/lis\.virginia\.gov|virginiageneralassembly\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'VA';
			} elseif ( preg_match( '/legislature\.vermont\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'VT';
			} elseif ( preg_match( '/leg\.wa\.gov|chrisgildon\.src\.wastateleg\.org|housedemocrats\.wa\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'WA';
			} elseif ( preg_match( '/docs\.legis\.wisconsin\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'WI';
			} elseif ( preg_match( '/legis\.state\.wv\.us|wvlegislature\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'WV';
			} elseif ( preg_match( '/wyoleg\.gov/', $data[ self::SOURCE ] ) ) {
				$leg_address['state'] = 'WY';
			}

			$state = $leg_address['state'];
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

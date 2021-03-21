<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

use \WP_CLI as WP_CLI;

/**
 * Manges govpack profile and seed data.
 */
class CLI extends \WP_CLI_Command {

	/**
	 * Load default taxonomy data.
	 *
	 * ## EXAMPLES
	 * wp govpack seed
	 *
	 * @subcommand seed
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function seed_taxonomies( $args, $assoc_args ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$count = \Newspack\Govpack\Tax\County::seed();
		if ( $count ) {
			WP_CLI::success( "Inserted {$count} counties" );
		}

		$count = \Newspack\Govpack\Tax\Installation::seed();
		if ( $count ) {
			WP_CLI::success( "Inserted {$count} installation methods" );
		}

		$count = \Newspack\Govpack\Tax\LegislativeBody::seed();
		if ( $count ) {
			WP_CLI::success( "Inserted {$count} legislative bodies" );
		}

		$count = \Newspack\Govpack\Tax\OfficeHolderStatus::seed();
		if ( $count ) {
			WP_CLI::success( "Inserted {$count} officeholder statuses" );
		}

		$count = \Newspack\Govpack\Tax\Party::seed();
		if ( $count ) {
			WP_CLI::success( "Inserted {$count} parties." );
		}

		$count = \Newspack\Govpack\Tax\State::seed();
		if ( $count ) {
			WP_CLI::success( "Inserted {$count} states." );
		}
	}

	/**
	 * Import data from CSV.
	 *
	 * ## OPTIONS
	 * <file>...
	 * : The CSV file.
	 *
	 * [--source=<value>]
	 * : CSV source.
	 * ---
	 * default: govpack
	 * options:
	 *   - openstates
	 *   - usio
	 *   - govpack
	 * ---
	 *
	 * [--dry-run]
	 * : Set to false to actually run the command
	 *
	 * ## EXAMPLES
	 * wp govpack import --source=openstates ak.csv --dry-run
	 * wp govpack import --source=usio usa.csv
	 *
	 * @subcommand import
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function import( $args, $assoc_args ) {
		if ( isset( $assoc_args['dry-run'] ) && 'false' === $assoc_args['dry-run'] ) {
			$dry_run = false;
		} else {
			$dry_run = true;
			WP_CLI::line( '!!! Doing a dry-run, no profiles will be imported.' );
		}

		$source = $assoc_args['source'] ?? 'govpack';

		$usio_title_map = [
			'rep' => 'Representative',
			'sen' => 'Senator',
		];

		$usio_title_to_leg_body_map = [
			'rep' => 'US House',
			'sen' => 'US Senate',
		];

		$openstates_party_map = [
			'Democratic' => 'Democrat',
			'Republican' => 'Republican',
		];

		$openstates_leg_body_to_title_map = [
			'lower'       => 'State Representative',
			'legislature' => 'State Representative', // Nebraska.
			'upper'       => 'State Senator',
		];

		$openstates_leg_body_map = [
			'lower'       => 'State House',
			'legislature' => 'State House', // Nebraska.
			'upper'       => 'State Senate',
		];

		$state_list    = \Newspack\Govpack\Helpers::get_cached_taxonomy( \Newspack\Govpack\Tax\State::TAX_SLUG );
		$party_list    = \Newspack\Govpack\Helpers::get_cached_taxonomy( \Newspack\Govpack\Tax\Party::TAX_SLUG );
		$leg_body_list = \Newspack\Govpack\Helpers::get_cached_taxonomy( \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG );

		$state_abbrevations = \Newspack\Govpack\Helpers::states();

		foreach ( $args as $file ) {
			if ( ! file_exists( $file ) ) {
				WP_CLI::warning( "File $file does not exist." );
				continue;
			}

			$csvfile = fopen( $file, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fopen
			if ( ! $csvfile ) {
				WP_CLI::error( "File $file cannot be opened." );
			}

			fgetcsv( $csvfile ); // Skip header row.
			while ( true ) {
				$data = fgetcsv( $csvfile );
				if ( false === $data ) {
					break;
				}

				$data = array_map( 'trim', $data );

				// USIO.
				if ( 'usio' === $source ) {
					$address = [];
					preg_match( '/(?P<address>.+?) (?P<city>Washington) (?P<state>\w{2}) (?P<zip>\d{5}(?:-\d{4})?)/', $data[14], $address );

					$profile = [
						'govpack_id'          => $data[22],
						'last_name'           => $data[0],
						'first_name'          => $data[1],
						'title'               => $usio_title_map[ $data[8] ],
						'state'               => $state_list[ $state_abbrevations[ $data[9] ] ],
						'party'               => $party_list[ $data[12] ],
						'legislative_body'    => $leg_body_list[ $usio_title_to_leg_body_map[ $data[8] ] ],
						'main_office_address' => $address['address'],
						'main_office_city'    => $address['city'],
						'main_office_state'   => $address['state'],
						'main_office_zip'     => $address['zip'],
						'leg_url'             => $data[13],
						'main_phone'          => $data[15],
					];

					if ( $data[18] ) {
						$profile['twitter'] = \Newspack\Govpack\Helpers::TWITTER_BASE_URL . $data[18];
					}

					if ( $data[19] ) {
						$profile['facebook'] = \Newspack\Govpack\Helpers::FACEBOOK_BASE_URL . $data[19];
					}
				} elseif ( 'openstates' === $source ) {

					// Some Open States' legislators don't have first and last names.
					// See https://github.com/openstates/issues/issues/365.
					if ( empty( $data[5] ) || empty( $data[6] ) ) {
						WP_CLI::warning( "No first or last name found for {$data[0]}. Deriving name." );
						$name_parts = explode( ' ', $data[1] );
						$data[5]    = join( ' ', array_slice( $name_parts, 0, -1 ) );
						$data[6]    = join( ' ', array_slice( $name_parts, -1 ) );
					}

					$leg_address      = [];
					$district_address = [];

					// AR addresses don't have the state specified.
					// See https://github.com/openstates/openstates-scrapers/pull/3635.
					if ( false !== strpos( $data[14], 'state.ar.us' ) ) {
						preg_match( '/^(?P<address>.+), (?P<city>[^,]+),? (?P<zip>\d{5}(?:-\d{4})?)$/', $data[18], $district_address );

						$district_address['state'] = 'AR';

						if ( isset( $district_address['address'] ) ) {
							$district_address['address'] = join( "\n", preg_split( '/; ?/', $district_address['address'], -1, PREG_SPLIT_NO_EMPTY ) );
						}
					} else {
						preg_match( '/^(?P<address>.+)(;|,) ?(?P<city>[^,;]+),? (?P<state>\w{2}),? (?P<zip>\d{5}(?:-\d{4})?)$/', $data[15], $leg_address );
						preg_match( '/^(?P<address>.+)(;|,) ?(?P<city>[^,;]+),? (?P<state>\w{2}),? (?P<zip>\d{5}(?:-\d{4})?)$/', $data[18], $district_address );

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
						function( $item ) use ( $openstates_party_map, $party_list ) {
							return isset( $openstates_party_map[ $item ] ) ? $party_list[ $openstates_party_map[ $item ] ] : $party_list[ $item ];
						},
						explode( '/', $data[2] )
					);

					$leg_urls = explode( ';', $data[13] );
					$leg_url  = end( $leg_urls ); // Last URL is most recent.

					$state = $leg_address['state'] ?? $district_address['state'];
					if ( ! $state ) {
						WP_CLI::warning( "Could not determine state for profile ID {$data[0]}." );
						continue;
					}

					$profile = [
						'govpack_id'               => $data[0],
						'last_name'                => $data[6],
						'first_name'               => $data[5],
						'title'                    => $openstates_leg_body_to_title_map[ $data[4] ],

						'state'                    => $state,
						'party'                    => $parties,
						'legislative_body'         => $openstates_leg_body_map[ $data[4] ],

						'email'                    => $data[8],
						'biography'                => $data[9],
						'image'                    => $data[12],

						'main_office_address'      => $leg_address['address'],
						'main_office_city'         => $leg_address['city'] ?? '',
						'main_office_state'        => $leg_address['state'] ?? '',
						'main_office_zip'          => $leg_address['zip'] ?? '',
						'main_phone'               => $data[16],
						'secondary_office_address' => $district_address['address'] ?? '',
						'secondary_office_city'    => $district_address['city'] ?? '',
						'secondary_office_state'   => $district_address['state'] ?? '',
						'secondary_office_zip'     => $district_address['zip'] ?? '',
						'secondary_phone'          => $data[19],

						'leg_url'                  => $leg_url,
						'instagram'                => $data[23],
						'facebook'                 => $data[24],
					];

					if ( $data[21] ) {
						$profile['twitter'] = \Newspack\Govpack\Helpers::TWITTER_BASE_URL . $data[21];
					}

					if ( $data[24] ) {
						$profile['facebook'] = \Newspack\Govpack\Helpers::FACEBOOK_BASE_URL . $data[24];
					}

					if ( $data[23] ) {
						$profile['instagram'] = \Newspack\Govpack\Helpers::INSTAGRAM_BASE_URL . $data[23];
					}
				} elseif ( 'govpack' === $source ) {
					WP_CLI::warning( 'govpack import support coming soon' );
				} else {
					WP_CLI::error( "Unsupported source type: $source" );
				}

				if ( ! $dry_run && $profile ) {
					// Remove empty fields.
					$profile = array_filter( $profile );

					$result = \Newspack\Govpack\CPT\Profile::create( $profile );
					if ( 0 === $result || is_wp_error( $result ) ) {
						WP_CLI::error( sprintf( 'Failed to insert %s %s.', $profile['first_name'], $profile['last_name'] ) );
					} else {
						WP_CLI::success( sprintf( 'Inserted %s %s as profile ID %d.', $profile['first_name'], $profile['last_name'], $result ) );
					}
				} else {
					WP_CLI::line( sprintf( 'Found data for %s %s.', $profile['first_name'], $profile['last_name'] ) );
				}
			}
			fclose( $csvfile ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
		}
	}
}

WP_CLI::add_command( 'govpack', '\Newspack\Govpack\CLI' );


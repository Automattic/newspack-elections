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
	 * <file>
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

		$file = $args[0];

		if ( ! file_exists( $file ) ) {
			WP_CLI::error( "File $file does not exist. Exiting." );
		}

		$csvfile = fopen( $file, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fopen
		if ( ! $csvfile ) {
			WP_CLI::error( "File $file cannot be opened." );
		}

		$usio_title_map = [
			'rep' => 'Representative',
			'sen' => 'Senator',
		];

		$usio_title_to_leg_body_map = [
			'rep' => 'US House',
			'sen' => 'US Senate',
		];

		$state_list    = \Newspack\Govpack\Helpers::get_cached_taxonomy( \Newspack\Govpack\Tax\State::TAX_SLUG );
		$party_list    = \Newspack\Govpack\Helpers::get_cached_taxonomy( \Newspack\Govpack\Tax\Party::TAX_SLUG );
		$leg_body_list = \Newspack\Govpack\Helpers::get_cached_taxonomy( \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG );

		$state_abbrevations = \Newspack\Govpack\Helpers::states();

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
					$profile['twitter'] = \Newspack\Govpack\Helpers::FACEBOOK_BASE_URL . $data[18];
				}

				if ( $data[19] ) {
					$profile['facebook'] = \Newspack\Govpack\Helpers::TWITTER_BASE_URL . $data[19];
				}
			}

			if ( ! $dry_run && $profile ) {
				$result = \Newspack\Govpack\CPT\Profile::create( $profile );
				if ( 0 === $result || is_wp_error( $result ) ) {
					WP_CLI::error( sprintf( 'Failed to insert %s %s.', $profile['first_name'], $profile['last_name'] ) );
				} else {
					WP_CLI::success( sprintf( 'Inserted %s %s as profile ID %d.', $profile['first_name'], $profile['last_name'], $result ) );
				}
			}
		}
		fclose( $csvfile ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose

		WP_CLI::line( 'Importing...' );
	}
}

WP_CLI::add_command( 'govpack', '\Newspack\Govpack\CLI' );


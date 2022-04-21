<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack;

/**
 * Base class for importers
 */
abstract class Importer {

	/**
	 * State taxonomy name -> id map
	 *
	 * @var array
	 */
	public static $state_list = [];

	/**
	 * Party taxonomy name -> id map
	 *
	 * @var array
	 */
	public static $party_list = [];

	/**
	 * Lesgislative body taxonomy name -> id map.
	 *
	 * @var array
	 */
	public static $leg_body_list = [];

	/**
	 * State abbreviation -> name map.
	 *
	 * @var array
	 */
	public static $state_abbrevations = [];

	/**
	 * Flag to prevent double loading of above data.
	 *
	 * @var boolean
	 */
	public static $loaded = false;


	/**
	 * Create an importer instance.
	 *
	 * @return Importer
	 */
	public static function make() {
		if ( ! self::$loaded ) {
			self::$state_list    = \Govpack\Helpers::get_cached_taxonomy( \Govpack\Tax\State::TAX_SLUG );
			self::$party_list    = \Govpack\Helpers::get_cached_taxonomy( \Govpack\Tax\Party::TAX_SLUG );
			self::$leg_body_list = \Govpack\Helpers::get_cached_taxonomy( \Govpack\Tax\LegislativeBody::TAX_SLUG );

			self::$state_abbrevations = \Govpack\Helpers::states();

			self::$loaded = true;
		}

		return new static();
	}

	/**
	 * Import CSV data. Parsing is done in ::parse(), defined in subclasses.
	 *
	 * @param string  $file     CSV file to import.
	 * @param string  $state    State to assign to profiles.
	 * @param boolean $dry_run  Whether to actually import the data (or just print it out).
	 * @return Importer
	 */
	public static function import( $file, $state = false, $dry_run = true ) {
		if ( ! file_exists( $file ) ) {
			return new \WP_Error( 'import', "File $file does not exist." );
		}

		$csvfile = fopen( $file, 'r' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fopen
		if ( ! $csvfile ) {
			return new \WP_Error( 'import', "File $file cannot be opened." );
		}

		fgetcsv( $csvfile ); // Skip header row.
		while ( true ) {
			$data = fgetcsv( $csvfile );
			if ( false === $data ) {
				break;
			}

			$data    = array_map( 'trim', $data );
			$profile = static::parse( $data, $state );

			if ( ! $profile ) {
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					\WP_CLI::line( sprintf( 'Failed to parse data [%s]', wp_json_encode( $data ) ) );
				}
				continue;
			}

			if ( $dry_run ) {
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					\WP_CLI::line( sprintf( 'Found data for %s %s.', $profile['first_name'], $profile['last_name'] ) );
				}
			} else {
				$result = \Govpack\CPT\Profile::create( $profile );
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					if ( 0 === $result || is_wp_error( $result ) ) {
						\WP_CLI::error( sprintf( 'Failed to insert %s %s.', $profile['first_name'], $profile['last_name'] ) );
					} else {
						\WP_CLI::success( sprintf( 'Inserted %s %s as profile ID %d.', $profile['first_name'], $profile['last_name'], $result ) );
					}
				}
			}
		}
		fclose( $csvfile ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_fclose
	}
}

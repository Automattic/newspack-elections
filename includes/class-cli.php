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

		if ( 'usio' === $source ) {
			$importer = \Newspack\Govpack\Importer\UnitedStatesIO::make();
		} elseif ( 'openstates' === $source ) {
			$importer = \Newspack\Govpack\Importer\OpenStates::make();
		} elseif ( 'govpack' === $source ) {
			$importer = \Newspack\Govpack\Importer\Govpack::make();
		} else {
			WP_CLI::error( "Unsupported source type: $source" );
		}

		foreach ( $args as $file ) {
			$result = $importer::import( $file, $dry_run );
			if ( is_wp_error( $result ) ) {
				foreach ( $result->errors as $error_info ) {
					foreach ( $error_info as $message ) {
						WP_CLI::error( $message );
					}
				}
			}
		}
	}
}

WP_CLI::add_command( 'govpack', '\Newspack\Govpack\CLI' );


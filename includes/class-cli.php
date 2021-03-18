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
}

WP_CLI::add_command( 'govpack', '\Newspack\Govpack\CLI' );


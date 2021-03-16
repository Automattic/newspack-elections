<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

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
		\WP_CLI::line( "Inserted {$count} counties" );

		$count = \Newspack\Govpack\Tax\Installation::seed();
		\WP_CLI::line( "Inserted {$count} installation methods" );

		$count = \Newspack\Govpack\Tax\LegislativeBody::seed();
		\WP_CLI::line( "Inserted {$count} legislative bodies" );

		$count = \Newspack\Govpack\Tax\OfficeHolderStatus::seed();
		\WP_CLI::line( "Inserted {$count} officeholder statuses" );

		$count = \Newspack\Govpack\Tax\Party::seed();
		\WP_CLI::line( "Inserted {$count} parties." );

		$count = \Newspack\Govpack\Tax\State::seed();
		\WP_CLI::line( "Inserted {$count} states." );
	}
}

\WP_CLI::add_command( 'govpack', '\Newspack\Govpack\CLI' );


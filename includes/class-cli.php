<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Newspack\Govpack;

use \WP_CLI as WP_CLI;

/**
 * Manages govpack profile and seed data.
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
	 * [--state=<abbrev>]
	 * : State profiles belong to.
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
	public function import_old( $args, $assoc_args ) {
		if ( isset( $assoc_args['dry-run'] ) && 'false' === $assoc_args['dry-run'] ) {
			$dry_run = false;
		} else {
			$dry_run = true;
			WP_CLI::line( '!!! Doing a dry-run, no profiles will be imported.' );
		}

		$source = $assoc_args['source'] ?? 'govpack';
		$state  = $assoc_args['state'] ?? '';

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
			$result = $importer::import( $file, $state, $dry_run );
			if ( is_wp_error( $result ) ) {
				foreach ( $result->errors as $error_info ) {
					foreach ( $error_info as $message ) {
						WP_CLI::error( $message );
					}
				}
			}
		}
	}

	/**
	 * Import data from WXR.
	 *
	 * ## OPTIONS
	 * <file>...
	 * : The WXR file.
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

		foreach ( $args as $file ) {
			
			try {

				$importer = \Newspack\Govpack\Importer\Importer::make( $file );
				$importer::import( $file, $dry_run );

			} catch ( \Exception $e ) {
				WP_CLI::error( $e->getMessage() );
			}
		}
	}

	/**
	 * Gets Progess from ongoing import
	 * 
	 * @subcommand progress
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function progress( $args, $assoc_args ) {
		$importer = \Newspack\Govpack\Importer\WXR::make();
		WP_CLI::line( $importer::progress() );
	}

	/**
	 * Stops a Currently running import
	 *
	 * @subcommand clear
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function clear( $args, $assoc_args ) {
		WP_CLI::line( \Newspack\Govpack\Importer\Importer::clear() );
	}

	/**
	 * Sideload an Image in a profile
	 * 
	 * ## OPTIONS
	 * <profile_id>...
	 * : The ID of the profile
	 *
	 * @subcommand sideload
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function sideload( $args, $assoc_args ) {

		WP_CLI::line( 'sideload' );

		$id = $args[0];

		try {
			\Newspack\Govpack\Importer\Importer::sideload( $id );
			WP_CLI::line( sprintf( 'Sideloaded Image for profile %s', $id ) );

		} catch ( \Exception $e ) {

			WP_CLI::error( $e->getMessage() );
		}
		
	}

	/**
	 * Add CLI command.
	 */
	public static function init() {
		WP_CLI::add_command( 'govpack import', '\Newspack\Govpack\CLI' );
		WP_CLI::add_command( 'govpack purge', [ '\Newspack\Govpack\CLI', 'purge' ] );
	}

	
	/**
	 * Deletes All Govpack Data
	 *
	 * @subcommand purge
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function purge( $args, $assoc_args ) {

		// turn of term counts when post status changes.
		remove_action( 'transition_post_status', '_update_term_count_on_transition_post_status', 10, 3 );

		// defer term counting.
		wp_defer_term_counting( true );


		WP_CLI::line( 'Purging GovPack Data' );

		$post_types = [
			'govpack_profiles',
			'govpack_issues',
		];

		foreach ( $post_types as $post_type ) {

			WP_CLI::line( sprintf( 'Purging Post Type : %s', $post_type ) );

	   
			$posts = new WP_Query(
				[
					'post_type'      => 'govpack_profiles',
					'post_status'    => 'any',
					'posts_per_page' => '-1',
					'fields'         => 'ids',
				] 
			);
			
			$i     = 0;
			$count = count( $posts->posts );
			
			foreach ( $posts->posts as $id ) {
				WP_CLI::line( sprintf( 'Deleting Post : %s', $id ) );
				wp_delete_post( $id, true );
				$i++;

				if ( ( $i % 1000 ) === 1 ) {
					WP_CLI::line( sprintf( 'Deleting Post : %s of %s', $i, $count ) );
				}
			}       
		}


		$taxonomies = [
			'govpack_city',
			'govpack_county',
			'govpack_state',
			'govpack_installation',
			'govpack_legislative_body',
			'govpack_officeholder_status',
			'govpack_party',
		];

		foreach ( $taxonomies as $taxonomy ) {

			WP_CLI::line( sprintf( 'Purging Taxonomy : %s', $taxonomy ) );

	   
			$terms = get_terms(
				[
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
					'fields'     => 'ids',
					'number'     => 0, // all.
				] 
			);

			foreach ( $terms as $term ) {
				WP_CLI::line( sprintf( 'Deleting Term : %s', $term ) );
				wp_delete_term( $term, $taxonomy );
			}       
		}

	}


	/**
	 * Clean stored data from the import process
	 *
	 * @subcommand clean
	 *
	 * @param array $args        Array of command-line arguments.
	 * @param array $assoc_args  Associative array of arguments.
	 */
	public function clean( $args, $assoc_args ) {
		WP_CLI::line( \Newspack\Govpack\Importer\Importer::clean() );
	}
		
}

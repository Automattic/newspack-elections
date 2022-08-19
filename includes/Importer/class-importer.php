<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Importer;

use Exception;
use Govpack\Core\Govpack;
use Govpack\Core\Capabilities;

/**
 * Register and handle the "USIO" Importer
 */
class Importer {

	/**
	 * Adds Actions to Hooks 
	 */
	public static function hooks() {

		\add_action( 'rest_api_init', [ __class__, 'register_rest_endpoints' ] );
		
		Chunked_Upload::hooks();
		Actions::hooks();

		\add_action( 'admin_enqueue_scripts', [ __class__, 'register_scripts' ] );

	}

	/**
	 * Adds ASSETS used for importing  
	 */
	public static function register_scripts() {

		$file = GOVPACK_PLUGIN_FILE . 'dist/importer.asset.php';
		if ( file_exists( $file ) ) {
			$asset_data = require_once $file; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		}
		
		$script_handle = 'govpack-importer';

		wp_register_script(
			$script_handle,
			plugin_dir_url( GOVPACK_PLUGIN_FILE ) . 'govpack/dist/importer.js',
			$asset_data['dependencies'] ?? [],
			$asset_data['version'] ?? '',
			true
		);

		wp_script_add_data( $script_handle, 'profiles_url', 'aksgdkasjdh' );
	}

	/**
	 * Register the REST Routes 
	 */
	public static function register_rest_endpoints() {

		\register_rest_route(
			Govpack::REST_PREFIX,
			'/import',
			[
				'methods'             => 'GET',
				'callback'            => [
					__class__,
					'import',
				],
				'permission_callback' => function () {
				
					return \current_user_can( Capabilities::CAN_IMPORT );

				},
			] 
		);

		\register_rest_route(
			Govpack::REST_PREFIX,
			'/import/progress',
			[
				'methods'             => 'GET',
				'callback'            => [
					__class__,
					'progress',
				],
				'permission_callback' => function () {
				
					return \current_user_can( Capabilities::CAN_IMPORT );

				},
			] 
		);

		\register_rest_route(
			Govpack::REST_PREFIX,
			'/import/status',
			[
				'methods'             => 'GET',
				'callback'            => [
					__class__,
					'status',
				],
				'permission_callback' => function () {
				
					return \current_user_can( Capabilities::CAN_IMPORT );

				},
			] 
		);

		\register_rest_route(
			Govpack::REST_PREFIX,
			'/import/sources',
			[
				'methods'             => 'GET',
				'callback'            => [ '\Govpack\Core\Importer\OpenStates_Sources', 'urls' ],
				'permission_callback' => function () {
				
					return \current_user_can( Capabilities::CAN_IMPORT );

				},
			] 
		);

		\register_rest_route(
			Govpack::REST_PREFIX,
			'/import/download',
			[
				'methods'             => 'POST',
				'callback'            => [ '\Govpack\Core\Importer\OpenStates_Sources', 'download' ],
				'permission_callback' => function () {
					
					return \current_user_can( Capabilities::CAN_IMPORT );

				},
			] 
		);
	}

	/**
	 * Called By The REST API to Check the status of an ongoing import
	 */
	public static function status() {
		return WXR::status();
	}

	

	/**
	 * Called By The REST API to Check the progress of an ongoing import
	 */
	public static function progress() {
		return self::progress_check();
	}

	/**
	 * Called By The REST API to Kickoff an Import and check its process
	 */
	public static function import() {

		$file  = get_option( 'govpack_import_path', false );
		$extra = get_option( 'govpack_import_extra_args', false );

		if ( ! $file ) {
			return new \WP_Error( '500', 'No File For Import' );
		}
		

		$importer = self::make( $file );

		return $importer::import( $file, false, $extra );


	}

	/**
	 * Checks the file exists in the Govpack uploads folder
	 *
	 * @param string $file  Name of the JSON file.
	 * @throws \Exception File Not Found.
	 */
	public static function check_file( $file ) {

		if ( file_exists( $file ) ) {
			return $file;
		}

		$path = wp_get_upload_dir();
		$path = $path['basedir'] . '/govpack/' . $file;

		if ( file_exists( $path ) ) {
			return $path;
		}

		throw new \Exception( 'File Not Found' );
	} 

	/**
	 * Checks the file exists in the Govpack uploads folder
	 *
	 * @param string $file  Name of the JSON file.
	 * @throws \Exception File Not Found.
	 */
	public static function filetype( $file ) {

	
		if ( file_exists( $file ) ) {
			return pathinfo( $file, PATHINFO_EXTENSION );
		}

		$path = wp_get_upload_dir();
		$path = $path['basedir'] . '/govpack/' . $file;


		if ( file_exists( $path ) ) {

			return pathinfo( $path, PATHINFO_EXTENSION );
		}

		throw new \Exception( 'File Not Found' );
	} 

	/**
	 * Create the importer based on the filetype passed in
	 *
	 * @param string $file Path of the file to import.
	 * @throws \Exception File Not Found.
	 */
	public static function make( $file ) {
		
		try {
			self::check_file( $file );
			$file_type = self::filetype( $file );
			if ( 'csv' === $file_type ) {
				return CSV::make();
			} elseif ( 'xml' === $file_type ) {
				return XML::make();
			} else {
				return false;
			}       
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * Custom function that gets counts of Action Scheduler actions
	 *
	 * @param array $args XML node being processed.
	 */
	public static function as_count_scheduled_actions( $args = [] ) {
		if ( ! \ActionScheduler::is_initialized( __FUNCTION__ ) ) {
			return [];
		}
		$store = \ActionScheduler::store();
		foreach ( [ 'date', 'modified' ] as $key ) {
			if ( isset( $args[ $key ] ) ) {
				$args[ $key ] = as_get_datetime_object( $args[ $key ] );
			}
		}

		return $store->query_actions( $args, 'count' );

	}

	/**
	 * Call the Import/Action Scheduler backend and see progress
	 */
	public static function progress_check() {

		$import_group = get_option( 'govpack_import_group', false );

		if ( ! $import_group ) {
			return [];
		}

		return [
			'total'  => self::as_count_scheduled_actions(
				[
					'group' => $import_group,
				]
			),
			'done'   => self::as_count_scheduled_actions(
				[
					'group'  => $import_group,
					'status' => \ActionScheduler_Store::STATUS_COMPLETE,
				]
			),
			'todo'   => self::as_count_scheduled_actions(
				[
					'group'  => $import_group,
					'status' => \ActionScheduler_Store::STATUS_PENDING,
				]
			),
			'failed' => self::as_count_scheduled_actions(
				[
					'group'  => $import_group,
					'status' => \ActionScheduler_Store::STATUS_FAILED,
				]
			),
		];
	}

	/**
	 * Removes stored options from the last import
	 */
	public static function check_for_stuck_import() {

		$progress_check = self::progress_check();

		// no known import on the go.
		if ( empty( $progress_check ) ) {
			return;
		}

		// there are no items left todo, reset the importer.
		if ( 0 === intval( $progress_check['todo'] ) ) {
			self::clean();
			return;
		}

	}

	  



	/**
	 * Reset all Import Funcions to empty
	 */
	public static function clear() {
		WXR::cancel();
		delete_option( 'govpack_import_path' );

		if ( ! \ActionScheduler::is_initialized( __FUNCTION__ ) ) {
			return;
		}

	 
		$store = \ActionScheduler::store();
		$store->cancel_actions_by_group( 'govpack' );
		$store->delete_actions_by_group( 'govpack' );

	}

	/**
	 * Removes stored options from the last import
	 */
	public static function clean() {
		// delete the options cached for the import.
		\delete_option( 'govpack_import_extra_args', null );
		\delete_option( 'govpack_import_path', null );
		\delete_option( 'govpack_import_processing', null );
		\delete_option( 'govpack_import_group', null );
	}


	/**
	 * For a Given Post ID, look for the image meta value, sideload it and save it as the post thumbnail
	 * 
	 * @param integer $id Post ID to lookup and sideload.
	 * @throws \Exception Profile errors.
	 */
	public static function sideload( $id = null ) {

		

		if ( ! $id ) {
			throw new \Exception( 'No Profile ID given' );
		}

		$post = get_post( $id );
		if ( ! $post ) {
			throw new \Exception( sprintf( 'No Entity with ID %s exists', $id ) );
		}

		if ( 'govpack_profiles' !== $post->post_type ) {
			throw new \Exception( sprintf( 'No Profile with ID %s exists', $id ) );
		}

		if ( ! $post->photo ) {
			throw new \Exception( sprintf( 'Profile %s Does not have an `image` meta field', $id ) );
		}

		if ( ! \wp_http_validate_url( $post->photo ) ) {
			throw new \Exception( sprintf( 'Image meta field for profile %s does not contain a valid url', $id ) );
		}


		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		$url = $post->photo;

		try {
			
			$sideload = \media_sideload_image( $url, $id, '', 'id' );
			
			if ( \is_wp_error( $sideload ) ) {
				throw new \Exception( sprintf( 'Side load failed for profile %s', $id ) );
			}

			if ( ! \set_post_thumbnail( $id, $sideload ) ) {
				throw new \Exception( sprintf( 'Side load failed for to side post thumbnail/featured image for profile %s', $id ) );
			}       
		} catch ( Exception $e ) {
			
			return true;
		}

		return true;
	}

}

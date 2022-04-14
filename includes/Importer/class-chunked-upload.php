<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

use Exception;
use WP_Error;
use Newspack\Govpack\Govpack;
use Newspack\Govpack\Capabilities;

/**
 * Handles Chunked Uploading via a REST Endpoint
 */
class Chunked_Upload {

	/**
	 * Instance
	 * 
	 * @var Actions $instance
	 */
	protected static $instance = null;

	/**
	 * Returns static instance of class.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Adds Actions to Hooks 
	 */
	public static function hooks() {
		add_action( 'rest_api_init', [ __class__, 'register_rest_endpoints' ] );
	}

	/**
	 * Adds rest endpoints for Importer Upload a file and combine
	 */
	public static function register_rest_endpoints() {
		\register_rest_route(
			Govpack::REST_PREFIX,
			'/upload/',
			[
				'methods'             => 'POST',
				'callback'            => [
					__class__,
					'upload',
				],
				'permission_callback' => function () {
					return \current_user_can( Capabilities::CAN_IMPORT );

				},
			] 
		);

		
	}

	/**
	 * Get the path we want to use as uploads for GovPack
	 * 
	 * @param string $slug path of the uploads older to create.
	 */
	public static function get_upload_path( $slug ) {
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/' . $slug;
		return $upload_dir;
	} 
	
	/**
	 * Check the uplaods will work and create a govpack specific directory
	 * 
	 * @param string $slug path of the uploads older to create.
	 */
	public static function create_upload_directory( $slug = 'govpack' ) {
		
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/' . $slug;
		if ( ! is_dir( $upload_dir ) ) {
			wp_mkdir_p( $upload_dir );
		}
	}

	/**
	 * Called By The REST API to upload a Chunk of a file and combine it 
	 * 
	 * @param \WP_REST_Request $request REST Request Data.
	 */
	public static function upload( \WP_REST_Request $request ) {

		$file_params = $request->get_file_params();
		
		self::create_upload_directory();
  
		$factory = new \FileUpload\FileUploadFactory(
			new \FileUpload\PathResolver\Simple( self::get_upload_path( 'govpack' ) ), 
			new \FileUpload\FileSystem\Simple(), 
			[
				new \FileUpload\Validator\MimeTypeValidator( [ 'text/csv', 'text/plain' ] ),
			]
		);

		if ( empty( $file_params['blob'] ) ) {
			return new WP_Error( 'No File Uploaded' );
		}
		
		$instance = $factory->create( $file_params['blob'], $_SERVER );

		$resp = $instance->processAll();
		$path = $instance->getFiles()[0]->getPathname();

		\update_option( 'govpack_import_extra_args', [] );
		\update_option( 'govpack_import_path', $path );
		
		return $resp;
		
	}
}

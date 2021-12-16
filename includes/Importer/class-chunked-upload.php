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
					return \current_user_can( 'edit_others_posts' );

				},
			] 
		);

		
	}


	/**
	 * Called By The REST API to upload a Chunk of a file and combine it 
	 * 
	 * @param \WP_REST_Request $request REST Request Data.
	 */
	public static function upload( \WP_REST_Request $request ) {

	  
		$factory = new \FileUpload\FileUploadFactory(
			new \FileUpload\PathResolver\Simple( \Newspack\Govpack\Admin\Pages\Import::get_upload_path( 'govpack' ) ), 
			new \FileUpload\FileSystem\Simple(), 
			[]
		);

		if ( empty( $request->files->blob ) ) {
			return new WP_Error( 'No File Uploaded' );
		}
		
		$instance = $factory->create( $request->files->blob, $_SERVER );

		$resp = $instance->processAll();
		$path = $instance->getFiles()[0]->getPathname();

		\update_option( 'govpack_import_path', $path );
		return $resp;
		
	}
}

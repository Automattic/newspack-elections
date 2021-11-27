<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

//php
use Exception;

// WordPress
use WP_Error;

// Lib
use Newspack\Govpack\Govpack;


/**
 * handles Chunked Uploading via a REST Endpoint
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
        add_action("rest_api_init", [__class__, "register_rest_endpoints"]);
    }

    public static function register_rest_endpoints() {
        \register_rest_route( Govpack::REST_PREFIX, "/upload/", array(
            'methods' => 'POST',
            'callback' => [
                __class__,
                "upload"
            ],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );

		
    }

    public static function upload(\WP_REST_Request $request){

      
        $factory = new \FileUpload\FileUploadFactory(
            new \FileUpload\PathResolver\Simple(\Newspack\Govpack\Admin\Pages\Import::get_upload_path("govpack")), 
            new \FileUpload\FileSystem\Simple(), 
            []
        );
        
        $instance = $factory->create($_FILES['blob'], $_SERVER);

        $resp = $instance->processAll();
        $path = $instance->getFiles()[0]->getPathname();

        \update_option("govpack_import_path", $path);
        return $resp;
        
    }
}
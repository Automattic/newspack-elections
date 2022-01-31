<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

use Exception;
use Newspack\Govpack\Govpack;

/**
 * Register and handle the "USIO" Importer
 */
class Importer {

	/**
	 * Adds Actions to Hooks 
	 */
	public static function hooks() {

		add_action( 'rest_api_init', [ __class__, 'register_rest_endpoints' ] );
		
		Chunked_Upload::hooks();
		Actions::hooks();

    }

	public static function register_rest_endpoints(){

		\register_rest_route( Govpack::REST_PREFIX, "/import", array(
            'methods' => 'GET',
            'callback' => [
                __class__,
                "import"
            ],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );

		\register_rest_route( Govpack::REST_PREFIX, "/import/progress", array(
            'methods' => 'GET',
            'callback' => [
                __class__,
                "progress"
            ],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );

        \register_rest_route( Govpack::REST_PREFIX, "/import/status", array(
            'methods' => 'GET',
            'callback' => [
                __class__,
                "status"
            ],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );

		\register_rest_route( Govpack::REST_PREFIX, "/import/sources", array(
            'methods' => 'GET',
            'callback' => ["\Newspack\Govpack\Importer\OpenStates_Sources", "urls"],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );

        \register_rest_route( Govpack::REST_PREFIX, "/import/download", array(
            'methods' => 'POST',
            'callback' => ["\Newspack\Govpack\Importer\OpenStates_Sources", "download"],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );
	}

    public static function status(\WP_REST_Request $request){
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

		$file = get_option( 'govpack_import_path', false );
        $extra = get_option( 'govpack_import_extra_args', false );

		if ( ! $file ) {
			return new \WP_Error( '500', 'No File For Import' );
		}
		
		
        $importer = self::make($file);
        return $importer::import( $file, false, $extra);

			
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
			return pathinfo($file, PATHINFO_EXTENSION);
		}

		$path = wp_get_upload_dir();
		$path = $path['basedir'] . '/govpack/' . $file;


		if ( file_exists( $path ) ) {

			return pathinfo($path, PATHINFO_EXTENSION);
		}

		throw new \Exception( 'File Not Found' );
	} 

    public static function make($file){
		
        try{
            self::check_file($file);
            $file_type = self::filetype($file);
    
            if($file_type === "csv"){
                return CSV::make();
            } elseif($file_type === "xml"){
                return XML::make();
            } else {
                return false;
           }

        } catch(Exception $e) {
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
		return [
			'total' => self::as_count_scheduled_actions(
				[
					'group' => 'govpack',
				]
			),
			'done'  => self::as_count_scheduled_actions(
				[
					'group'  => 'govpack',
					'status' => \ActionScheduler_Store::STATUS_COMPLETE,
				]
			),
			'todo'  => self::as_count_scheduled_actions(
				[
					'group'  => 'govpack',
					'status' => \ActionScheduler_Store::STATUS_PENDING,
				]
			),
            'failed'  => self::as_count_scheduled_actions(
				[
					'group'  => 'govpack',
					'status' => \ActionScheduler_Store::STATUS_FAILED,
				]
			),
		];
	}

    /**
	 * Reset all Import Funcions to empty
     * 
	 */
	public static function clear() {
        WXR::cancel();
        delete_option("govpack_import_path");

        if ( ! \ActionScheduler::is_initialized( __FUNCTION__ ) ) {
            return;
        }

     
        $store = \ActionScheduler::store();
        $store->cancel_actions_by_group("govpack");
        $store->delete_actions_by_group("govpack");

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


    public static function sideload( $id = null){

        if(!$id){
            throw new \Exception("No Profile ID given");
        }

        if(!$post = get_post($id)){
            throw new \Exception(sprintf("No Entity with ID %s exists", $id));
        }

        if($post->post_type !== "govpack_profiles"){
            throw new \Exception(sprintf("No Profile with ID %s exists", $id));
        }

        if(!$post->image){
            throw new \Exception(sprintf("Profile %s Does not have an `image` meta field", $id));
        }

        if(!\wp_http_validate_url($post->image)){
            throw new \Exception(sprintf("Image meta field for profile %s does not contain a valid url", $id));
        }

        $url = \esc_url_raw($post->image);

        $sideload = \media_sideload_image($url, $id, "", "id");

        if(\is_wp_error($sideload)){
            throw new \Exception(sprintf("Side load failed for profile %s", $id));
        }

        if(!\set_post_thumbnail($id, $sideload)){
            throw new \Exception(sprintf("Side load failed for to side post thumbnail/featured image for profile %s", $id));
        }

        return true;
    }

}

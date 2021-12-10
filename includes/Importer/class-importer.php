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

        add_action("rest_api_init", [__class__, "register_rest_endpoints"]);
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
            'callback' => ["\Newspack\Govpack\Importer\GitHub_Sources", "urls"],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );

        \register_rest_route( Govpack::REST_PREFIX, "/import/download", array(
            'methods' => 'POST',
            'callback' => ["\Newspack\Govpack\Importer\GitHub_Sources", "download"],
            'permission_callback' => function () {
                return true;
                return \current_user_can( 'edit_others_posts' );

            }) 
        );
	}

    public static function status(\WP_REST_Request $request){
		return WXR::status();
	}

	public static function progress(\WP_REST_Request $request){
		return self::progress_check();
	}

	public static function import(\WP_REST_Request $request){

		$file = get_option("govpack_import_path", false);

		if(!$file){
			return new \WP_Error("500", "No File For Import");
		}
		
		return WXR::import($file);
			
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
	public static function create_upload_directory( $slug = "govpack" ) {
        
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/' . $slug;
		if ( ! is_dir( $upload_dir ) ) {
			wp_mkdir_p( $upload_dir );
		}
	}

}
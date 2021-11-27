<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

use Exception;

/**
 * Register and handle the "USIO" Importer
 */
class Importer {

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
	public static function progress() {
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
	 * Check the uplaods will work and create a govpack specific directory
	 * 
	 * @param string $slug path of the uploads older to create.
	 */
	public static function create_upload_directory( $slug ) {
        
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/' . $slug;
		if ( ! is_dir( $upload_dir ) ) {
			wp_mkdir_p( $upload_dir );
		}
	}

}
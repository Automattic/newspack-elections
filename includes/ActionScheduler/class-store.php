<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\ActionScheduler;

/**
 * Extends The normal action scheduler Schema to increase the length of the extended_args allowed
 * Its Limited to 8000 by defaukt buy we needed more
 */
class Store extends \ActionScheduler_DBStore {
	
	/**
	 * Length we want to set the extended_args to
	 * 
	 * @var max_args_length  
	 */
	protected static $max_args_length = 65535;

	/**
	 * Overrides the init from ActionScheduler_DBStore so we can load our own StoreSchema
	 */
	public function init() {
		
		$table_maker = new StoreSchema();
		$table_maker->init();
		$table_maker->register_tables();
	}

    /**
	 * Delete pending actions by hook.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook Hook name.
	 *
	 * @return void
	 */
	public function delete_actions_by_hook( $hook ) {
		$this->bulk_delete_actions( array( 'hook' => $hook ) );
	}

	/**
	 * Delete pending actions by group.
	 *
	 * @param string $group Group slug.
	 *
	 * @return void
	 */
	public function delete_actions_by_group( $group ) {
        
		$this->bulk_delete_actions( array( 
            'group' => $group,
            'status' => ["pending", "canceled", "failed"] 
        ) );
	}

    /**
	 * Bulk cancel actions.
	 *
	 * @since 3.0.0
	 *
	 * @param array $query_args Query parameters.
	 */
	protected function bulk_delete_actions( $query_args ) {
		/** @var \wpdb $wpdb */
		global $wpdb;

		if ( ! is_array( $query_args ) ) {
			return;
		}


		$action_ids = true;
		$query_args = wp_parse_args(

			array(
				'per_page' => 1000,
				'orderby'  => 'action_id',
            ),
            $query_args
		);


		while ( $action_ids ) {
            

			$action_ids = $this->query_actions( $query_args );

			if ( empty( $action_ids ) ) {
				break;
			}

			$format     = array_fill( 0, count( $action_ids ), '%d' );
			$query_in   = '(' . implode( ',', $format ) . ')';
			$parameters = $action_ids;


			$wpdb->query(
				$wpdb->prepare(
					"DELETE FROM {$wpdb->actionscheduler_actions} WHERE action_id IN {$query_in}", // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
					$parameters
				)
			);

			do_action( 'action_scheduler_bulk_delete_actions', $action_ids );
		}
	}
}
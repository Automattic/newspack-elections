<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\ActionScheduler;

class ActionScheduler {
	public static function hooks() {
		add_filter( 'action_scheduler_store_class', [ __class__, 'replace_store' ] );
		add_filter( 'action_scheduler_queue_runner_concurrent_batches', [ __class__, 'as_concurrent_batches' ] );
	}

	public static function as_concurrent_batches( $concurrent_batches ) {
		return 1;
	}

	public static function replace_store( $current_store ) {
		remove_filter( 'action_scheduler_store_class', [ 'ActionScheduler_DataController', 'set_store_class' ], 100 );
		return '\Newspack\Govpack\ActionScheduler\Store';
	}
}

<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\ActionScheduler;

/**
 * GovPack action Scheduler extension that modifies it for our needs
 */
class ActionScheduler {

	/**
	 * Add Hooks for Messing with ActionScheduler Loader
	 */
	public static function hooks() {
		add_filter( 'action_scheduler_store_class', [ __class__, 'replace_store' ] );
		add_filter( 'action_scheduler_queue_runner_concurrent_batches', [ __class__, 'as_concurrent_batches' ] );
	}

	/**
	 * Force Action Scheduler to only use 1 Queue.
	 * 
	 * @param int $concurrent_batches How many Batches/Queues.
	 */  
	public static function as_concurrent_batches( $concurrent_batches = 1 ) { //phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		return 1;
	}

	/**
	 * Action added to replace the defaukt store used by Action Scheduler.
	 * 
	 * @param string $current_store Current Store used By Action Scheduler.
	 */
	public static function replace_store( $current_store ) { //phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		remove_filter( 'action_scheduler_store_class', [ 'ActionScheduler_DataController', 'set_store_class' ], 100 );
		return '\Newspack\Govpack\ActionScheduler\Store';
	}
}

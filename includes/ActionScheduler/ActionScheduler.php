<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\ActionScheduler;

/**
 * GovPack action Scheduler extension that modifies it for our needs
 */
class ActionScheduler {

	/**
	 * Add Hooks for Messing with ActionScheduler Loader
	 */
	public static function hooks(): void {
		add_action( 'action_scheduler_pre_init', [ __CLASS__, 'keep_migration_complete' ] );
		add_filter( 'action_scheduler_store_class', [ __CLASS__, 'replace_store' ] );
		//add_filter( 'action_scheduler_queue_runner_concurrent_batches', [ __CLASS__, 'as_concurrent_batches' ] );
		add_filter( 'action_scheduler_logger_class', [ __CLASS__, 'replace_logger' ] );
	}

	/**
	 * Restore Action Scheduler's migration flag before Action Scheduler reads it.
	 *
	 * Action Scheduler deletes the flag whenever a plugin is deactivated. Without it, our store counts
	 * as a custom store, so the migration callback is never registered but the migration action is
	 * still scheduled, and it fails every minute or two. Our store already uses Action Scheduler's
	 * tables, so there is nothing to migrate.
	 */
	public static function keep_migration_complete(): void {
		if ( ! \ActionScheduler_DataController::is_migration_complete() ) {
			\ActionScheduler_DataController::mark_migration_complete();
		}
	}

	/**
	 * Force Action Scheduler to only use 1 Queue.
	 *
	 * @param int $concurrent_batches How many Batches/Queues.
	 *
	 * @psalm-return 1
	 */
	public static function as_concurrent_batches( $concurrent_batches = 1 ): int { //phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		return 1;
	}

	/**
	 * Action added to replace the defaukt store used by Action Scheduler.
	 *
	 * @param string $current_store Current Store used By Action Scheduler.
	 *
	 * @psalm-return '\Govpack\ActionScheduler\Store'
	 */
	public static function replace_store( $current_store ): string { //phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		remove_filter( 'action_scheduler_store_class', [ 'ActionScheduler_DataController', 'set_store_class' ], 100 );
		return '\Govpack\ActionScheduler\Store';
	}

	/**
	 * Action added to replace the defaukt logger used by Action Scheduler.
	 *
	 * @param string $current_logging_class Current Store used By Action Scheduler.
	 *
	 * @psalm-return 'ActionScheduler_DBLogger'
	 */
	public static function replace_logger( $current_logging_class ): string { //phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		return 'ActionScheduler_DBLogger';
	}
}

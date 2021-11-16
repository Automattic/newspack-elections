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

}

<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\ActionScheduler;

class Store extends \ActionScheduler_DBStore {
	
	protected static $max_args_length = 65535;


	public function init() {
		
		$table_maker = new StoreSchema();
		$table_maker->init();
		$table_maker->register_tables();
	}

}

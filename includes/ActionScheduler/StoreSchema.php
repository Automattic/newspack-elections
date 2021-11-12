<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\ActionScheduler;

class StoreSchema extends \ActionScheduler_StoreSchema {
	
	/**
	 * We Hijack the constructor to modify the version number and trigger a migration to happen
	 */
	public function __construct() {

		$this->schema_version = $this->schema_version + 0.1;
		parent::__construct();

	}

	 /**
	  * When called, get the original schema and modify the extended args column
	  */

	protected function get_table_definition( $table ) {
		$definition = parent::get_table_definition( $table );

		if ( $table !== self::ACTIONS_TABLE ) {
			return $definition;
		}

		return str_replace( 'varchar(8000)', 'text', $definition );
	}

}

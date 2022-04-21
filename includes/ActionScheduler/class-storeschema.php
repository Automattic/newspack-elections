<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\ActionScheduler;

/**
 * Extends the ActionScheduler_StoreSchema so we can reused it for out overrides
 */
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
	 *
	 * @param string $table what table definition to get.
	 */
	protected function get_table_definition( $table ) {
		$definition = parent::get_table_definition( $table );

		if ( self::ACTIONS_TABLE !== $table ) {
			return $definition;
		}

		return str_replace( 'varchar(8000)', 'text', $definition );
	}

}

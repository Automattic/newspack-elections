<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\ActionScheduler;

class InstallExtendedArgs {


	private static $current_version     = 1;
	private static $version_options_key = 'extended_args_version';
	private static $table_name          = 'actionscheduler_actions_extended';

	public static function do() {
		self::register_table();
		if ( self::needsMigration() ) {
			self::runMigrations();
		}
	}


	public static function get_full_table_name( $table ) {
		return $GLOBALS['wpdb']->prefix . $table;
	}

	// make wpdb aware that the extended table exists
	public static function register_table() {
		global $wpdb;
		$table_name        = self::$table_name;
		$wpdb->tables[]    = $table_name;
		$name              = self::get_full_table_name( $table_name );
		$wpdb->$table_name = $name;
	}


	public static function needsMigration() {
		$installed_version = \get_option( self::$version_options_key, 0 );

		if ( $installed_version >= self::$current_version ) {
			return false;
		}

		return true;
	}


	

	public static function runMigrations() {

		$installed_version = \get_option( self::$version_options_key, 0 );

		if ( $installed_version >= self::$current_version ) {
			return;
		}

		$methods_to_execute = [];
	
	
		for ( $i = $installed_version; $i <= self::$current_version; $i++ ) {
			$method_name = 'migrate_v_' . $i;
			if ( method_exists( __CLASS__, $method_name ) ) {
				$methods_to_execute[] = [
					'method'  => $method_name,
					'version' => $i,
				];
			}
		}
	

		foreach ( $methods_to_execute as $method ) {
			call_user_func( __class__ . '::' . $method['method'] );
			// \update_option(self::$version_options_key, $method["version"]);
		}
	}

	public static function migrate_v_1() {

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$table   = self::get_table_definition();
		$updated = dbDelta( $table );
		
	}

	private static function get_table_definition() {    
		global $wpdb;

		$table_name      = self::$table_name;
		$table_name      = $wpdb->$table_name;
		$charset_collate = $wpdb->get_charset_collate();
		
		return "CREATE TABLE {$table_name} (
            extended_action_id bigint(20) unsigned NOT NULL auto_increment,
            action_id bigint(20) unsigned NOT NULL default '0',
            extended_args text DEFAULT NULL,
            PRIMARY KEY  (extended_action_id)
            ) $charset_collate";
		
	}
}

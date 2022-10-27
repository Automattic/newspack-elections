<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

use \Monolog\Logger as MonoLog;
use \Monolog\Handler\StreamHandler;

/**
 * WordPress filters and actions.
 */
class Logger {

   
	private $log;
   
	public function __construct( $logger_name = 'Govpack Logs', $log_file_name = 'govpack.log' ) {
		$this->log = new MonoLog( $logger_name );
		$this->maybe_create_log_path( $log_file_name );
		$this->log->pushHandler( new StreamHandler( self::log_path( $log_file_name ), MonoLog::DEBUG ) );
	}
   
	private function maybe_create_log_path( $log_file_name ) {

		$path = self::log_path( $log_file_name );
		if ( file_exists( $path ) ) {
			return null;
		}

		wp_mkdir_p( dirname( $path ) );
	}
   
	public static function log_path( $log_file_name ) {
		$dir = wp_upload_dir();
		return $dir['basedir'] . '/logs/' . $log_file_name;
	}
   
	public static function maybe_extract_wp_error( $error ) {
		if ( is_wp_error( $error ) ) {
			return $error->get_error_message();
		}
			return $error;
	}
   
	public function emergency( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->emergency( $message, $context );
	}
   
	/**
	 * Action must be taken immediately.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function alert( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->alert( $message, $context );
	}
   
	/**
	 * Critical conditions.
	 *
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function critical( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->critical( $message, $context );
	}

	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function error( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->error( $message, $context );
	}

	/**
	 * Exceptional occurrences that are not errors.
	 *
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function warning( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->warning( $message, $context );
	}

	/**
	 * Normal but significant events.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function notice( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->notice( $message, $context );
	}

	/**
	 * Interesting events.
	 *
	 * Example: User logs in, SQL logs.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function info( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->info( $message, $context );
	}

	/**
	 * Detailed debug information.
	 *
	 * @param string $message
	 * @param array  $context
	 * @return void
	 */
	public function debug( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			return $this->log->debug( $message, $context );
	}
	   

}

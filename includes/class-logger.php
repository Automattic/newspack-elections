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

	/**
	 * Logger Instance
	 * 
	 * @var Monolog $instance
	 */
	private $log;

	/**
	 * Creates a Monolog Instance and the file to log to
	 *
	 * @param string $logger_name Sytsem Name for the logger.
	 * @param string $log_file_name Filename for the logger.
	 * @return void
	 */
	public function __construct( $logger_name = 'Govpack Logs', $log_file_name = 'govpack.log' ) {
		$this->log = new MonoLog( $logger_name );
		$this->maybe_create_log_path( $log_file_name );
		$this->log->pushHandler( new StreamHandler( self::log_path( $log_file_name ), MonoLog::DEBUG ) );
	}

	/**
	 * Creates the log path if it doesn't exist
	 *
	 * @param string $log_file_name Filename for the logger.
	 * @return null
	 */
	private function maybe_create_log_path( $log_file_name ) {

		$path = self::log_path( $log_file_name );
		if ( file_exists( $path ) ) {
			return null;
		}

		wp_mkdir_p( dirname( $path ) );
		return null;
	}
   
	/**
	 * Generate the path for the log file from the uploads directory
	 *
	 * @param string $log_file_name Filename for the logger.
	 * @return string
	 */
	public static function log_path( $log_file_name ) {
		$dir = wp_upload_dir();
		return $dir['basedir'] . '/logs/' . $log_file_name;
	}
   
	/**
	 * Checks if an error object is a WP error or not.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param Object $error Error object to test.
	 * @return string
	 */
	public static function maybe_extract_wp_error( $error ) {
		if ( is_wp_error( $error ) ) {
			return $error->get_error_message();
		}
			return $error;
	}
   
	/**
	 * Action must be taken immediately.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function emergency( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->emergency( $message, $context );
	}
   
	/**
	 * Action must be taken soon.
	 *
	 * Example: Entire website down, database unavailable, etc. This should
	 * trigger the SMS alerts and wake you up.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function alert( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->alert( $message, $context );
	}
   
	/**
	 * Critical conditions.
	 *
	 * Example: Application component unavailable, unexpected exception.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function critical( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->critical( $message, $context );
	}

	/**
	 * Runtime errors that do not require immediate action but should typically
	 * be logged and monitored.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function error( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->error( $message, $context );
	}

	/**
	 * Exceptional occurrences that are not errors.
	 *
	 * Example: Use of deprecated APIs, poor use of an API, undesirable things
	 * that are not necessarily wrong.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function warning( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->warning( $message, $context );
	}

	/**
	 * Normal but significant events.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function notice( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->notice( $message, $context );
	}

	/**
	 * Interesting events.
	 *
	 * Example: User logs in, SQL logs.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function info( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->info( $message, $context );
	}

	/**
	 * Detailed debug information.
	 *
	 * @param string $message Log message.
	 * @param array  $context Log Context.
	 * @return void
	 */
	public function debug( $message, array $context = [] ) {
			$message = self::maybe_extract_wp_error( $message );
			$this->log->debug( $message, $context );
	}
	   

}

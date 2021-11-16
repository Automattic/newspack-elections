<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\Importer;

use Exception;

/**
 * Register and handle the "USIO" Importer
 */
class Actions {

	/**
	 * Instance
	 * 
	 * @var Actions $instance
	 */
	protected static $instance = null;

	/**
	 * Returns static instance of class.
	 *
	 * @return self
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Adds Actions to Hooks 
	 */
	public static function hooks() {
		add_action( 'govpack_import_category', [ self::instance(), 'make_term' ] );
		add_action( 'govpack_import_tag', [ self::instance(), 'make_term' ] );
		add_action( 'govpack_import_term', [ self::instance(), 'make_term' ] );
		add_action( 'govpack_import_post', [ self::instance(), 'make_post' ] );
	}

	/**
	 * Action that fires from the importer to make the terms
	 * 
	 * @param array $args Args passed from Action Scheduler.
	 */
	public function make_term( $args ) {
		$this->process_term( $args, null );
	}

	/**
	 * Does the term exist?
	 *
	 * @param array $data Term data to check against.
	 * @return int|bool Existing term ID if it exists, false otherwise.
	 */
	protected function term_exists( $data ) {

		// Still nothing, try comment_exists, and cache it.
		$exists = term_exists( $data['slug'], $data['taxonomy'] ); //phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.term_exists_term_exists

		if ( is_array( $exists ) ) {

			$exists = $exists['term_id'];
		}

		return $exists;
	}

	/**
	 * Pre-process term data.
	 *
	 * @param array $data Term data. (Return empty to skip.).
	 */
	protected function process_term( $data ) {
		

		if ( empty( $data ) ) {
			return false;
		}

		if ( 'amp_validation_error' === $data['taxonomy'] ) {
			return false;
		}

		$existing = $this->term_exists( $data ); 
		if ( $existing ) {
			return false;
		}


		$termdata = [];
		$allowed  = [
			'slug'        => true,
			'description' => true,
		];



		foreach ( $data as $key => $value ) {
			if ( ! isset( $allowed[ $key ] ) ) {
				continue;
			}

			$termdata[ $key ] = $data[ $key ];
		}

		$result = wp_insert_term( $data['name'], $data['taxonomy'], $termdata );



		$term_id = $result['term_id'];

		do_action( 'wp_import_insert_term', $term_id, $data );


	}
}

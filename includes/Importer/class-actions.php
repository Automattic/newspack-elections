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


	public static function hooks() {
		add_action( 'govpack_import_category', [ self::instance(), 'make_term' ] );
		add_action( 'govpack_import_tag', [ self::instance(), 'make_term' ] );
		add_action( 'govpack_import_term', [ self::instance(), 'make_term' ] );
		// add_action("govpack_import_post", [self::instance(), "make_post"]);
	}

	public function make_term( $args ) {
		error_log( print_r( $args, true ) );
		$this->process_term( $args, null );
	}

	/**
	 * Does the term exist?
	 *
	 * @param array $data Term data to check against.
	 * @return int|bool Existing term ID if it exists, false otherwise.
	 */
	protected function term_exists( $data ) {
		// $exists_key = sha1( $data['taxonomy'] . ':' . $data['slug'] );

		// Constant-time lookup if we prefilled
		// if ( $this->options['prefill_existing_terms'] ) {
		// return isset( $this->exists['term'][ $exists_key ] ) ? $this->exists['term'][ $exists_key ] : false;
		// }

		// No prefilling, but might have already handled it
		// if ( isset( $this->exists['term'][ $exists_key ] ) ) {
		// return $this->exists['term'][ $exists_key ];
		// }

		// Still nothing, try comment_exists, and cache it
		$exists = term_exists( $data['slug'], $data['taxonomy'] );

		if ( is_array( $exists ) ) {

			$exists = $exists['term_id'];
		}

		return $exists;
	}

	protected function process_term( $data, $meta ) {
		/**
		 * Pre-process term data.
		 *
		 * @param array $data Term data. (Return empty to skip.)
		 * @param array $meta Meta data.
		 */

		if ( empty( $data ) ) {
			return false;
		}

		if ( $data['taxonomy'] === 'amp_validation_error' ) {
			return false;
		}

		$original_id = isset( $data['id'] ) ? (int) $data['id'] : 0;
		$parent_id   = isset( $data['parent'] ) ? (int) $data['parent'] : 0;

		$mapping_key = sha1( $data['taxonomy'] . ':' . $data['slug'] );
		$existing    = $this->term_exists( $data );

		if ( $existing ) {
			error_log( 'Exists' );
			return false;
		}


		$termdata = [];
		$allowed  = [
			'slug'        => true,
			'description' => true,
		];

		// Map the parent comment, or mark it as one we need to fix
		// TODO: add parent mapping and remapping
		/*
		$requires_remapping = false;
		if ( $parent_id ) {
			if ( isset( $this->mapping['term'][ $parent_id ] ) ) {
				$data['parent'] = $this->mapping['term'][ $parent_id ];
			} else {
				// Prepare for remapping later
				$meta[] = array( 'key' => '_wxr_import_parent', 'value' => $parent_id );
				$requires_remapping = true;
				// Wipe the parent for now
				$data['parent'] = 0;
			}
		}*/

		foreach ( $data as $key => $value ) {
			if ( ! isset( $allowed[ $key ] ) ) {
				continue;
			}

			$termdata[ $key ] = $data[ $key ];
		}

		$result = wp_insert_term( $data['name'], $data['taxonomy'], $termdata );

		/*
		if ( is_wp_error( $result ) ) {
			$this->logger->warning( sprintf(
				__( 'Failed to import %s %s', 'wordpress-importer' ),
				$data['taxonomy'],
				$data['name']
			) );
			$this->logger->debug( $result->get_error_message() );
			do_action( 'wp_import_insert_term_failed', $result, $data );

			/**
			 * Term processing failed.
			 *
			 * @param WP_Error $result Error object.
			 * @param array $data Raw data imported for the term.
			 * @param array $meta Meta data supplied for the term.
			 */
			// do_action( 'wxr_importer.process_failed.term', $result, $data, $meta );
			// return false;
		// }

		$term_id = $result['term_id'];

		do_action( 'wp_import_insert_term', $term_id, $data );


	}
}

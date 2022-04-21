<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Importer;

use Exception;

/**
 * Register and handle the "USIO" Importer
 */
class Actions_WXR extends Actions {



	/**
	 * Adds Actions to Hooks 
	 */
	public static function hooks() {

		parent::hooks();
		add_action( 'govpack_import_post', [ self::instance(), 'make_post' ] );

	}

	/**
	 * Action that fires from the importer to make the terms
	 * 
	 * @param array $args Args passed from Action Scheduler.
	 */
	public function make_post( $args ) {
		$this->process_post( $args, null );
	}


	/**
	 * Does the post exist?
	 *
	 * @param array $data Post data to check against.
	 * @return int|bool Existing post ID if it exists, false otherwise.
	 */
	protected function post_exists( $data ) {

		// Still nothing, try post_exists, and cache it.
		$exists = post_exists( $data['post_title'], $data['post_content'], $data['post_date'] );

		return $exists;
	}


	/**
	 * Pre-process post data.
	 *
	 * @param array $data Post data. (Return empty to skip.).
	 * @param array $meta Post metadata. (Return empty to skip.).
	 * @param array $comments Comment data. (Return empty to skip.).
	 * @param array $terms Terms data. (Return empty to skip.).
	 */
	protected function process_post( $data, $meta, $comments = null, $terms ) {

	
		if ( empty( $data ) ) {
			return false;
		}

		$original_id = isset( $data['post_id'] ) ? (int) $data['post_id'] : 0;
		$parent_id   = isset( $data['post_parent'] ) ? (int) $data['post_parent'] : 0;

		$post_type_object = get_post_type_object( $data['post_type'] );

		// Is this type even valid?
		if ( ! $post_type_object ) {
			return false;
		}

		$post_exists = $this->post_exists( $data );

		// Map the parent post, or mark it as one we need to fix.
		$requires_remapping = false;
		if ( $parent_id ) {
			if ( isset( $this->mapping['post'][ $parent_id ] ) ) {
				$data['post_parent'] = $this->mapping['post'][ $parent_id ];
			} else {
				$meta[]             = [
					'key'   => '_wxr_import_parent',
					'value' => $parent_id,
				];
				$requires_remapping = true;

				$data['post_parent'] = 0;
			}
		}

		// Map the author, or mark it as one we need to fix.
		$author = sanitize_user( $data['post_author'], true );
		if ( empty( $author ) ) {
			// Missing or invalid author, use default if available.
			$data['post_author'] = $this->options['default_author'];
		} elseif ( isset( $this->mapping['user_slug'][ $author ] ) ) {
			$data['post_author'] = $this->mapping['user_slug'][ $author ];
		} else {
			$meta[]             = [
				'key'   => '_wxr_import_user_slug',
				'value' => $author,
			];
			$requires_remapping = true;

			$data['post_author'] = (int) get_current_user_id();
		}


		// Whitelist to just the keys we allow.
		$postdata = [
			'import_id' => $data['post_id'],
		];
		$allowed  = [
			'post_author'    => true,
			'post_date'      => true,
			'post_date_gmt'  => true,
			'post_content'   => true,
			'post_excerpt'   => true,
			'post_title'     => true,
			'post_status'    => true,
			'post_name'      => true,
			'comment_status' => true,
			'ping_status'    => true,
			'guid'           => true,
			'post_parent'    => true,
			'menu_order'     => true,
			'post_type'      => true,
			'post_password'  => true,
		];
		foreach ( $data as $key => $value ) {
			if ( ! isset( $allowed[ $key ] ) ) {
				continue;
			}

			$postdata[ $key ] = $data[ $key ];
		}

		$postdata = apply_filters( 'wp_import_post_data_processed', $postdata, $data );

		$post_id = wp_insert_post( $postdata, true );
		do_action( 'wp_import_insert_post', $post_id, $original_id, $postdata, $data );

		if ( is_wp_error( $post_id ) ) {
		
			$this->logger->debug( $post_id->get_error_message() );

			/**
			 * Post processing failed.
			 *
			 * @param WP_Error $post_id Error object.
			 * @param array $data Raw data imported for the post.
			 * @param array $meta Raw meta data, already processed by {@see process_post_meta}.
			 * @param array $comments Raw comment data, already processed by {@see process_comments}.
			 * @param array $terms Raw term data, already processed.
			 */
			do_action( 'wxr_importer_process_failed_post', $post_id, $data, $meta, null, $terms );
			return false;
		}

		// Ensure stickiness is handled correctly too.
		if ( '1' === $data['is_sticky'] ) {
			stick_post( $post_id );
		}

		// Handle the terms too.
		$terms = apply_filters( 'wp_import_post_terms', $terms, $post_id, $data );

		if ( ! empty( $terms ) ) {
			$term_ids = [];
			foreach ( $terms as $term ) {
				$taxonomy = $term['taxonomy'];
				$key      = sha1( $taxonomy . ':' . $term['slug'] );

				if ( isset( $this->mapping['term'][ $key ] ) ) {
					$term_ids[ $taxonomy ][] = (int) $this->mapping['term'][ $key ];
				} else {
					$meta[]             = [
						'key'   => '_wxr_import_term',
						'value' => $term,
					];
					$requires_remapping = true;
				}
			}

			foreach ( $term_ids as $tax => $ids ) {
				$tt_ids = wp_set_post_terms( $post_id, $ids, $tax );
				do_action( 'wp_import_set_post_terms', $tt_ids, $ids, $tax, $post_id, $data );
			}
		}

		$this->process_post_meta( $meta, $post_id, $data );

	}

	/**
	 * Process and import post meta items.
	 *
	 * @param array $meta List of meta data arrays.
	 * @param int   $post_id Post to associate with.
	 * @param array $post Post data.
	 * @return int|WP_Error Number of meta items imported on success, error otherwise.
	 */
	protected function process_post_meta( $meta, $post_id, $post ) {
		if ( empty( $meta ) ) {
			return true;
		}

		foreach ( $meta as $meta_item ) {
			/**
			 * Pre-process post meta data.
			 *
			 * @param array $meta_item Meta data. (Return empty to skip.)
			 * @param int $post_id Post the meta is attached to.
			 */
			$meta_item = apply_filters( 'wxr_importer_pre_process_post_meta', $meta_item, $post_id );
			if ( empty( $meta_item ) ) {
				return false;
			}

			$key   = apply_filters( 'import_post_meta_key', $meta_item['key'], $post_id, $post );
			$value = false;

			if ( '_edit_last' === $key ) {
				$value = intval( $meta_item['value'] );
				if ( ! isset( $this->mapping['user'][ $value ] ) ) {
					// Skip!
					continue;
				}

				$value = $this->mapping['user'][ $value ];
			}

			if ( $key ) {
				// export gets meta straight from the DB so could have a serialized string.
				if ( ! $value ) {
					$value = maybe_unserialize( $meta_item['value'] );
				}

				add_post_meta( $post_id, $key, $value );
				do_action( 'import_post_meta', $post_id, $key, $value );

			}
		}

		return true;
	}

}

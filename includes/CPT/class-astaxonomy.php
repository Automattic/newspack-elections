<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\CPT;

/**
 * Enable post types to be used as a taxonomy
 */
class AsTaxonomy {

	/**
	 * Post types.
	 *
	 * @var array
	 */
	public static $post_types = [];

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'init' ], 11 );
		add_action( 'save_post', [ __CLASS__, 'update' ] );
		add_action( 'untrashed_post', [ __CLASS__, 'update' ] );
		add_action( 'trashed_post', [ __CLASS__, 'delete' ] );
	}

	/**
	 * Which post types want to be ordered
	 */
	public static function init() {

		$post_types = get_post_types();
		if ( ! $post_types ) {
			return;
		}

		foreach ( $post_types as $post_type ) {
			$post_type = get_post_type_object( $post_type );

			if ( isset( $post_type->as_taxonomy ) ) {
				self::$post_types[ $post_type->name ] = $post_type->as_taxonomy;
			}
		}
	}

	/**
	 * Add or update a term in our taxonomy
	 *
	 * @param int $post_id The posts ID that has to be linked to our taxonomy.
	 *
	 * @return boolean
	 */
	public static function update( $post_id ) {
		if ( ! is_array( self::$post_types ) ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return;
		}

		if ( 'auto-draft' === $post->post_status ) {
			return;
		}

		if ( ! isset( self::$post_types[ $post->post_type ] ) ) {
			return;
		}

		$taxonomy = self::$post_types[ $post->post_type ];

		$term_id = get_post_meta( $post->ID, 'term_id', true );
		if ( $term_id ) {

			// This post is already linked to a term, let's see if it still exists.
			$term = get_term( $term_id, $taxonomy );

			if ( $term ) {
				// It exists, update optional changes.
				wp_update_term(
					$term_id,
					$taxonomy,
					[
						'name' => $post->post_title,
						'slug' => $post->post_name,
					]
				);
				return;
			}
		}

		// If the code made it here, either the term link didn't exist or still has to be created.
		// Either way, create a new term link!
		$term = wp_insert_term( $post->post_title, $taxonomy, [ 'slug' => $post->post_name ] );

		if ( ! is_wp_error( $term ) ) {
			return update_post_meta( $post->ID, 'term_id', $term['term_id'] );
		} elseif ( isset( $term->error_data['term_exists'] ) ) {
			return update_post_meta( $post->ID, 'term_id', $term->error_data['term_exists'] );
		}
	}

	/**
	 * Delete a term
	 *
	 * @param int $post_id The posts ID which taxonomy term has to be removed.
	 *
	 * @return bool|int|WP_Error
	 */
	public static function delete( $post_id ) {
		if ( ! is_array( self::$post_types ) ) {
			return;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			return;
		}

		if ( ! isset( self::$post_types[ $post->post_type ] ) ) {
			return;
		}

		$term_id = get_post_meta( $post->ID, 'term_id', true );
		if ( ! $term_id ) {
			return;
		}

		$taxonomy = self::$post_types[ $post->post_type ];

		// The post is linked to a term, delete it!
		$term = get_term( $term_id, $taxonomy );

		if ( ! $term ) {
			return;
		}

		// The linked term still exists, now really delete.
		return wp_delete_term( $term_id, $taxonomy );
	}

	/**
	 * Convenience functions
	 *
	 * Retrieve the term or part of it that is linked to a certain post.
	 * This function can be used to easily get the term ID or slug to filter on posts which this post is linked to (using WP_Query).
	 *
	 * @param int    $post_id The ID of the post.
	 * @param string $taxonomy The taxonomy where the term should be in.
	 * @param string $part Optional. The part of the term to return.
	 *
	 * @return WP_Term|string|WP_Error
	 */
	public function get_term( $post_id, $taxonomy, $part = '' ) {
		if ( ! $post_id || ! $taxonomy ) {
			return;
		}

		$term = get_term( get_post_meta( $post_id, 'term_id', true ), $taxonomy );
		if ( is_wp_error( $term ) ) {
			return $term;
		}

		if ( ! $term ) {
			return;
		}

		if ( $part ) {
			return $term->$part;
		}

		return $term;
	}

	/**
	 * Retrieve the terms or part of the terms which are linked to a certain post.
	 * This function can be used to get all terms (or maybe just the ID's) which can be used to filter
	 * and retrieve all posts which are linked to the current post (using WP_Query).
	 *
	 * @param int    $post_id The ID of the post.
	 * @param string $taxonomy The taxonomy of which to collect the.
	 * @param string $part Optional. The part of the terms to return.
	 *
	 * @return null|array
	 */
	public function get_terms( $post_id, $taxonomy, $part = '' ) {
		if ( ! $post_id || ! $taxonomy ) {
			return;
		}

		$terms = wp_get_post_terms( $post_id, $taxonomy );
		if ( ! $terms ) {
			return;
		}

		// Return complete objects.
		if ( ! $part ) {
			return $terms;
		}

		// Return part of the terms.
		$terms_part = [];
		foreach ( $terms as $term ) {
			$terms_part[] = $term->$part;
		}

		return $terms_part;
	}

	/**
	 * Retrieve the post that is linked to a term
	 *
	 * @param object $term The linked term.
	 *
	 * @return WP_Post|null
	 */
	public function get_post( $term ) {
		$query = new WP_Query(
			[
				'post_type'   => 'any',
				'meta_key'    => 'term_id',
				'meta_value'  => $term->term_id, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'numberposts' => 1,
			]
		);

		$posts = $query->posts;
		if ( is_object( $posts[0] ) ) {
			return $posts[0];
		}
	}
}

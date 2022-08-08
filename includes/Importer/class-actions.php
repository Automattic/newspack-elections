<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Importer;

use Exception;
use Govpack\Core\CPT\Profile;

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
		\add_action( 'govpack_import_category', [ self::instance(), 'make_term' ] );
		\add_action( 'govpack_import_tag', [ self::instance(), 'make_term' ] );
		\add_action( 'govpack_import_term', [ self::instance(), 'make_term' ] );
		

		\add_action( 'govpack_import_csv_profile', [ self::instance(), 'make_profile_from_csv' ] );
		\add_action( 'govpack_import_cleanup', [ self::instance(), 'cleanup_import' ] );
		\add_filter( 'govpack_import_openstates_links', [ self::instance(), 'explode_openstates_list' ] );
		\add_filter( 'govpack_import_openstates_sources', [ self::instance(), 'explode_openstates_list' ] );

		\add_filter( 'govpack_import_content', [ self::instance(), 'wrap_content_in_block_grammar' ] );
		\add_filter( 'govpack_import_content', [ self::instance(), 'inject_block_in_content' ] );
		
	}

	/**
	 * Convert a string from openstates into an array
	 * 
	 * @param string $list string of items from openstates.
	 */
	public static function explode_openstates_list( $list ) {
		return explode( ';', $list );
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
	 * Action that fires to inject the default block in the content
	 * 
	 * @param array $content content from the imported.
	 */
	public static function inject_block_in_content( $content = null ) {
		
		var_dump($content);
		
		// phpcs:ignore content is "" false null or nil.
		if ( ! $content ) {
			return \Govpack\Core\CPT\Profile::default_profile_content();
		}

		if(has_block("govpack/profile-self", $content)){
			return $content;
		}
		// inject it at the start.
		return \Govpack\Core\CPT\Profile::default_profile_content() . $content;
	}

	/**
	 * Action that fires to inject the default block in the content
	 * 
	 * @param array $content content from the imported.
	 */
	public static function wrap_content_in_block_grammar( $content = null ) {
		
		// phpcs:ignore content is "" false null or nil.
		if ( ! $content ) {
			return $content;
		}

		// convert all the spaces and new lines to paragraphs.
		$content = \wpautop( $content );

		// use str_replace to replace the <p> and </p> tags.
		$content = str_replace(
			[
				'<p>',
				'</p>',
			],
			[
				"<!-- wp:paragraph --> \r\n <p>",
				"</p> \r\n <!-- /wp:paragraph -->",
			],
			$content
		);

		return $content;
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

	/**
	 * From OpenStates data, split the address up into pieces
	 * 
	 * @param string $address address to be split up.
	 */
	public static function get_address_from_open_states_data( $address ) {
		if ( ! $address ) {
			return [];
		}

		$new_address = [];
		// First we need to split the address string on the ; so we get the street address and the state/zip in the second.
		$re = '/([^;]+)/m';
		preg_match_all( $re, $address, $matches, PREG_SET_ORDER, 0 );

		$new_address['address'] = $matches[0][0];
		$the_rest               = $matches[1][0] ?? null; 

		if ( $the_rest ) {
			preg_match_all( '/([^,]+), ([A-Z]+) ([0-9-]+)/m', $the_rest, $new_matches, PREG_SET_ORDER, 0 );

			if ( $new_matches ) {
			
				$new_address['city']  = $new_matches[0][1] ?? '';
				$new_address['state'] = $new_matches[0][2] ?? '';
				$new_address['zip']   = $new_matches[0][3] ?? '';
			}
		}
	
		return $new_address;

	}

	/**
	 * From CSV data, create a profile
	 * 
	 * @param array $data_input Data passed from Action Scheduler.
	 */
	public static function make_profile_from_csv( $data_input ) {
		

		$data = [];

		foreach ( $data_input as $key => $value ) {
			$data[ trim( strtolower( $key ) ) ] = trim( $value );
		}

		$model = Profile::get_import_model();

		
		$meta = [];
		$tax  = [];
		$post = [
			'post_author'    => 0,
			'post_status'    => 'draft',
			'post_type'      => 'govpack_profiles',
			'comment_status' => 'closed',
		];

		foreach ( $model as $key => $action ) {

			if ( 'meta' === $action['type'] ) {
				$meta[ $key ] = $data_input[ $action['key'] ];
			}

			if ( 'post' === $action['type'] ) {
				$post[ $action['key'] ] = $data_input[ $key ];
			}

			if ( 'taxonomy' === $action['type'] ) {
				$term                       = self::find_or_create_term( $data_input[ $key ], $action['taxonomy'] );
				$tax[ $action['taxonomy'] ] = $term->term_id;
			}

			if ( 'media' === $action['type'] ) {
				// add key to meta to sore it for later processing
				$meta[ $key ] = $data_input[ $key ];
			}
		}

		if(!self::is_profile_update($post)){
			$post['post_content'] = apply_filters("govpack_import_content", $post['post_content']);
		}

		$post['post_title'] = $meta['name'];
		$post['meta_input'] = $meta;
		$post['tax_input']  = $tax;


		$resp = self::create_or_update($post);
	
		if ( \is_wp_error( $resp ) ) {
			return; 
		}

		$created_post_id = $resp;
		
		
		if ( $data['photo'] ) {
			
			try {
				Importer::sideload( $created_post_id );
			} catch ( Exception $e ) {
				return false;
			}
		}
		
		return true;
	}

	public static function create_or_update($post){
		
		if( self::is_profile_update($post) ){
			$resp = wp_update_post($post);
		} else {
			$resp = wp_insert_post($post);
		}

		return $resp;
	}

	public static function is_profile_update($post){
		if(
			($post["ID"]) && 
			(self::post_exists($post["ID"]))
		) {
			return true;
		} 
		
		return false;
		
	}

	/**
	 * Determines if a post, identified by the specified ID, exist
	 * within the WordPress database.
	 * 
	 * Note that this function uses the 'acme_' prefix to serve as an
	 * example for how to use the function within a theme. If this were
	 * to be within a class, then the prefix would not be necessary.
	 *
	 * @param    int    $id    The ID of the post to check
	 * @return   bool          True if the post exists; otherwise, false.
	 * @since    1.0.0
	 */
	public static function post_exists( $id ) {
		return is_string( get_post_status( $id ) );
	}

	/**
	 * Utility to assign a term to an object
	 *
	 * @param string $object_id The ID of the object to which the term gets added.
	 * @param string $term_name The Name of the term to find or create.
	 * @param string $taxonomy the taxonomy to look/create in.
	 */
	public static function assign_term_to_obj( $object_id, $term_name, $taxonomy ) {
		$term = self::find_or_create_term( $term_name, $taxonomy );
		if ( ! \is_wp_error( $term ) ) {
			\wp_set_object_terms( $object_id, [ $term->term_id ], $taxonomy );
		}
	}

	/**
	 * Look For a term in a taxonomy, create it if it doesn't exist
	 * 
	 * @param string $term_name The Name of the term to find or create.
	 * @param string $taxonomy the taxonomy to look/create in.
	 */
	public static function find_or_create_term( $term_name = null, $taxonomy = null ) {

		require_once ABSPATH . 'wp-admin/includes/taxonomy.php';


		if ( ! $term_name ) {
			return new \WP_Error( 'No Term Provided to find or create' );
		}

		if ( ! $taxonomy ) {
			return new \WP_Error( 'No Taxonmy Provided to find or create in' );
		}


		$term = \get_term_by( 'name', $term_name, $taxonomy );

		if ( ! $term ) {
			$term = \wp_create_term( $term_name, $taxonomy );
			$term = \get_term( $term['term_id'], $taxonomy );
		}
		


		return $term;
		
	}

	/**
	 * Run a Cleanup  
	 */
	public static function cleanup_import() {
		\Govpack\Core\Importer\Importer::clean();
	}
}

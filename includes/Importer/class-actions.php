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
		add_action( 'govpack_import_csv_profile', [ self::instance(), 'make_profile_from_csv' ] );

		add_action( 'govpack_import_cleanup', [ self::instance(), 'cleanup_import' ] );

		add_filter( 'govpack\import\openstates\links', [ self::instance(), 'explode_openstates_list' ] );
		add_filter( 'govpack\import\openstates\sources', [ self::instance(), 'explode_openstates_list' ] );
	}


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
	 * Action that fires from the importer to make the terms
	 * 
	 * @param array $args Args passed from Action Scheduler.
	 */
	public function make_post( $args ) {
		$this->process_post( $args, null );
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
	 * Does the post exist?
	 *
	 * @param array $data Post data to check against.
	 * @return int|bool Existing post ID if it exists, false otherwise.
	 */
	protected function post_exists( $data ) {

		// Still nothing, try post_exists, and cache it
		$exists = post_exists( $data['post_title'], $data['post_content'], $data['post_date'] );

		return $exists;
	}


	/**
	 * Pre-process post data.
	 *
	 * @param array $data Post data. (Return empty to skip.).
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
			$this->logger->warning(
				sprintf(
					__( 'Failed to import "%1$s": Invalid post type %2$s', 'wordpress-importer' ),
					$data['post_title'],
					$data['post_type']
				) 
			);
			return false;
		}

		$post_exists = $this->post_exists( $data );

		// Map the parent post, or mark it as one we need to fix
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

		// Map the author, or mark it as one we need to fix
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

		// Does the post look like it contains attachment images?
		// if ( preg_match( self::REGEX_HAS_ATTACHMENT_REFS, $data['post_content'] ) ) {
		// $meta[] = array( 'key' => '_wxr_import_has_attachment_refs', 'value' => true );
		// $requires_remapping = true;
		// }

		// Whitelist to just the keys we allow
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
			$this->logger->error(
				sprintf(
					__( 'Failed to import "%1$s" (%2$s)', 'wordpress-importer' ),
					$data['post_title'],
					$post_type_object->labels->singular_name
				) 
			);
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
			do_action( 'wxr_importer.process_failed.post', $post_id, $data, $meta, null, $terms );
			return false;
		}

		// Ensure stickiness is handled correctly too
		if ( $data['is_sticky'] === '1' ) {
			stick_post( $post_id );
		}

		// Handle the terms too
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
	 * @param array $meta List of meta data arrays
	 * @param int   $post_id Post to associate with
	 * @param array $post Post data
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
			$meta_item = apply_filters( 'wxr_importer.pre_process.post_meta', $meta_item, $post_id );
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
				// export gets meta straight from the DB so could have a serialized string
				if ( ! $value ) {
					$value = maybe_unserialize( $meta_item['value'] );
				}

				add_post_meta( $post_id, $key, $value );
				do_action( 'import_post_meta', $post_id, $key, $value );

			}
		}

		return true;
	}


	public static function get_address_from_open_states_data( $address ) {
		if ( ! $address ) {
			return [];
		}

		$new_address = [];
		// First we need to split the address string on the ; so we get the street address and the state/zip in the second
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

	public static function make_profile_from_csv( $data_input ) {
		
		$data = [];

		foreach($data_input as $key => $value){
			$data[trim(strtolower($key))] = trim($value);
		}

		$main_office      = self::get_address_from_open_states_data( $data['district_address'] );
		$secondary_office = self::get_address_from_open_states_data( $data['capitol_address'] );
  
		$post = [
			'post_author'    => 0,
			'post_content'   => $data['biography'],
			'post_title'     => $data['name'],
			'post_status'    => 'draft',
			'post_type'      => 'govpack_profiles',
			'comment_status' => 'closed',
		  
			'meta_input'     => [
				'open_state_id'            => $data['id'],

				'first_name'               => $data['given_name'],
				'last_name'                => $data['family_name'],
				'name'                     => $data['name'],
				'gender'                   => $data['gender'],
				'biography'                => $data['biography'],
				'birth_date'               => $data['birth_date'],
				'death_date'               => $data['death_date'],

				'current_district'         => $data['current_district'],
				'current_chamber'          => $data['current_chamber'],
			   
				'email'                    => $data['email'],
				'twitter'                  => $data['twitter'],
				'youtube'                  => $data['youtube'],
				'instagram'                => $data['instagram'],
				'facebook'                 => $data['facebook'],
				
				'main_phone'               => $data['district_voice'],
				'secondary_phone'          => $data['capitol_voice'],

				'main_fax'                 => $data['district_fax'],
				'secondary_fax'            => $data['capitol_fax'],

				'main_office_address'      => $main_office['address'] ?? '',
				'main_office_city'         => $main_office['city'] ?? '',
				'main_office_state'        => $main_office['state'] ?? '',
				'main_office_zip'          => $main_office['zip'] ?? '',

				'secondary_office_address' => $secondary_office['address'] ?? '',
				'secondary_office_city'    => $secondary_office['city'] ?? '',
				'secondary_office_state'   => $secondary_office['state'] ?? '',
				'secondary_office_zip'     => $secondary_office['zip'] ?? '',

				'image'                    => $data['image'],
				'links'                    => \apply_filters( 'govpack\import\openstates\links', $data['links'] ),
				'sources'                  => \apply_filters( 'govpack\import\openstates\sources', $data['sources'] ),
				'extra'                    => $data['extra'] ?? '',

			],   
		];
 

		$resp = \wp_insert_post( $post );

		if ( \is_wp_error( $resp ) ) {
			return; 
		}

		$created_post_id = $resp;
	   
		$taxonomy_map = [
			'current_party'   => 'govpack_party',
			'state'           => 'govpack_state',
			'current_chamber' => 'govpack_legislative_body',
			'title'           => 'govpack_officeholder_title',
			'status'          => 'govpack_officeholder_status',
		];

		foreach ( $taxonomy_map as $field => $taxonomy ) {
			
			if ( isset($data[ $field ])) {
				self::assign_term_to_obj( $created_post_id, $data[ $field ], $taxonomy );
				error_log("Attaching Term to Profile");
			}
		}
		
	

		if ( $data['image'] ) {

			error_log("Attempting to sideload Image");
			error_log(print_r($data['image'], true));

			
			try {
				Importer::sideload( $created_post_id );
			} catch ( Exception $e ) {

			}
		}
		
		return true;
	}

	public static function assign_term_to_obj( $object_id, $term_name, $taxonomy ) {
		$term = self::find_or_create_term( $term_name, $taxonomy );
		if ( ! \is_wp_error( $term ) ) {
			\wp_set_object_terms( $object_id, [ $term->term_id ], $taxonomy );
		}
	}

	public static function find_or_create_term( $term_name = null, $taxonomy = null ) {

		require_once(ABSPATH . "wp-admin/includes/taxonomy.php");


		if ( ! $term_name ) {
			return new WP_Error( 'No Term Provided to find or create' );
		}

		if ( ! $taxonomy ) {
			return new WP_Error( 'No Taxonmy Provided to find or create in' );
		}


		$term = \get_term_by( 'name', $term_name, $taxonomy );

		if ( ! $term ) {
			$term = \wp_create_term( $term_name, $taxonomy );
		}

		return $term;
		
	}

	public static function cleanup_import( ) {
		\Newspack\Govpack\Importer\Importer::clean();
	}
}

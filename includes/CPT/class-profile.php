<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\CPT;

use \Newspack\Govpack\Helpers;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class Profile extends \Newspack\Govpack\Post_Type {

	/**
	 * Valid profile formats.
	 *
	 * @var array
	 */
	public static $profile_formats = [ 'full', 'mini', 'wiki' ];

	/**
	 * Default profile format.
	 *
	 * @var string
	 */
	public static $default_profile_format = 'full';

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const CPT_SLUG = 'govpack_profiles';

	/**
	 * Shortcode.
	 */
	const SHORTCODE = 'govpack';

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		parent::hooks();
		//add_action( 'cmb2_init', [ __CLASS__, 'add_profile_boxes' ] );
		add_action( 'init', [ __CLASS__, 'register_post_meta' ] );
		add_filter( 'wp_insert_post_data', [ __CLASS__, 'set_profile_title' ], 10, 3 );
		add_action( 'edit_form_after_editor', [ __CLASS__, 'show_profile_title' ] );
		add_filter( 'manage_edit-' . self::CPT_SLUG . '_sortable_columns', [ __CLASS__, 'sortable_columns' ] );
	}

	/**
	 * Register the Profiles post type
	 *
	 * @return object|WP_Error
	 */
	public static function register_post_type() {
		return register_post_type( // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
			self::CPT_SLUG,
			[
				'labels'       => [
					'name'               => _x( 'Profiles', 'post type general name', 'govpack' ),
					'singular_name'      => _x( 'Profile', 'post type singular name', 'govpack' ),
					'menu_name'          => _x( 'Profiles', 'admin menu', 'govpack' ),
					'name_admin_bar'     => _x( 'Profile', 'add new on admin bar', 'govpack' ),
					'add_new'            => _x( 'Add New', 'popup', 'govpack' ),
					'add_new_item'       => __( 'Add New Profile', 'govpack' ),
					'new_item'           => __( 'New Profile', 'govpack' ),
					'edit_item'          => __( 'Edit Profile', 'govpack' ),
					'view_item'          => __( 'View Profile', 'govpack' ),
					'all_items'          => __( 'Profiles', 'govpack' ),
					'search_items'       => __( 'Search Profiles', 'govpack' ),
					'not_found'          => __( 'No profiles found.', 'govpack' ),
					'not_found_in_trash' => __( 'No profiles found in Trash.', 'govpack' ),
				],
				'has_archive'  => false,
				'public'       => true,
				'show_in_rest' => true,
				'show_ui'      => true,
				'supports'     => [ 'revisions', 'thumbnail', "editor"],
				'taxonomies'   => [ 'post_tag' ],
				'as_taxonomy'  => \Newspack\Govpack\Tax\Profile::TAX_SLUG,
				'menu_icon'    => 'dashicons-groups',
				'rewrite'      => [
					'slug'       => apply_filters( 'govpack_profile_filter_slug', 'profile' ),
					'with_front' => 'false',
				],
			]
		);
	}

	/**
	 * Register Meta data for the post in the REST API 
	 */
	public static function register_post_meta() {

		self::register_meta("prefix");
		self::register_meta("first_name");
		self::register_meta("last_name");

		$address_fields = ["address", "city", "state", "county"];
		$address_types = ["main_office", "secondary_office"];

		foreach($address_types as $type){
			foreach($address_fields as $field){
				$slug = sprintf("%s_%s", $type, $field);
				self::register_meta($slug);
			}
		}

		self::register_meta("position");
		self::register_meta("title");

		self::register_meta("main_phone");
		self::register_meta("secondary_phone");
		self::register_meta("text_email");
		self::register_meta("twitter");
		self::register_meta("instagram");
		self::register_meta("facebook");
		self::register_meta("linkedin");
		self::register_meta("leg_url");
		self::register_meta("campaign_url");
		
	}

	/**
	 * Register single Meta data for the post in the REST API 
	 */
	public static function register_meta(string $slug, array $args = []) {

		$args = array_merge([
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string'
		], $args);

		register_post_meta( self::CPT_SLUG, $slug, $args);
	}

	/**
	 * Print out the post title where the normal title field would be. This post type does not
	 * `supports` the title field; it is constructed from the profile data.
	 */
	public static function show_profile_title() {
		global $typenow, $pagenow;
		if ( self::CPT_SLUG === $typenow && 'post.php' === $pagenow ) {
			echo '<h1>' . esc_html( get_the_title() ) . '</h1>';
		}
	}

	/**
	 * Denote State, Party and Legislative Body columns as sortable.
	 *
	 * @param array $sortable_columns An array of sortable columns.
	 */
	public static function sortable_columns( $sortable_columns ) {
		$sortable_columns[ 'taxonomy-' . \Newspack\Govpack\Tax\State::TAX_SLUG ]           = 'State';
		$sortable_columns[ 'taxonomy-' . \Newspack\Govpack\Tax\Party::TAX_SLUG ]           = 'Party';
		$sortable_columns[ 'taxonomy-' . \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG ] = 'Legislative Body';
		return $sortable_columns;
	}

	/**
	 * Using CMB2, add custom fields to profile.
	 */
	public static function add_profile_boxes() {
		/**
		 * Name metabox.
		 */
		$cmb_name = new_cmb2_box(
			[
				'id'           => 'id',
				'title'        => __( 'Name', 'govpack' ),
				'object_types' => [ self::CPT_SLUG ],
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
				'cmb_styles'   => false,
				'show_in_rest' => \WP_REST_Server::READABLE,
			]
		);

		$cmb_name->add_field(
			[
				'name'             => __( 'Prefix', 'govpack' ),
				'id'               => 'prefix',
				'type'             => 'select',
				'show_option_none' => true,
				'options'          => Helpers::prefixes(),
			]
		);

		$cmb_name->add_field(
			[
				'name' => __( 'First name', 'govpack' ),
				'id'   => 'first_name',
				'type' => 'text',
			]
		);

		$cmb_name->add_field(
			[
				'name' => __( 'Last name', 'govpack' ),
				'id'   => 'last_name',
				'type' => 'text',
			]
		);

		$cmb_name->add_field(
			[
				'name'              => __( 'Party', 'govpack' ),
				'id'                => 'party',
				'type'              => 'taxonomy_multicheck_inline',
				'select_all_button' => false,
				'taxonomy'          => \Newspack\Govpack\Tax\Party::TAX_SLUG,
			]
		);

		$cmb_name->add_field(
			[
				'name' => __( 'Biography', 'govpack' ),
				'id'   => 'biography',
				'type' => 'wysiwyg',
			]
		);

		$cmb_address = new_cmb2_box(
			[
				'id'           => 'main_office',
				'title'        => __( 'Main Office', 'govpack' ),
				'object_types' => [ self::CPT_SLUG ],
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
				'cmb_styles'   => false,
			]
		);

		$cmb_address2 = new_cmb2_box(
			[
				'id'           => 'secondary_office',
				'title'        => __( 'Secondary Office', 'govpack' ),
				'object_types' => [ self::CPT_SLUG ],
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
				'cmb_styles'   => false,
			]
		);

		/**
		 * Office address metaboxes.
		 */
		$address_boxes = [
			'main_office'      => $cmb_address,
			'secondary_office' => $cmb_address2,
		];
		foreach ( $address_boxes as $slug => $box ) {
			$box->add_field(
				[
					'name' => __( 'Address', 'govpack' ),
					'id'   => $slug . '_address',
					'type' => 'textarea_small',
				]
			);

			$box->add_field(
				[
					'name' => __( 'City', 'govpack' ),
					'id'   => $slug . '_city',
					'type' => 'text',
				]
			);

			$box->add_field(
				[
					'name'             => __( 'State', 'govpack' ),
					'id'               => $slug . '_state',
					'type'             => 'select',
					'show_option_none' => true,
					'options'          => Helpers::states(),
				]
			);

			$box->add_field(
				[
					'name'       => __( 'Zip', 'govpack' ),
					'id'         => $slug . '_zip',
					'type'       => 'text',
					'attributes' => [
						'maxlength' => 10,
					],
				]
			);
		}

			/**
			 * Current position metabox.
			 */
			$cmb_position = new_cmb2_box(
				[
					'id'           => 'position',
					'title'        => __( 'Current Position', 'govpack' ),
					'object_types' => [ self::CPT_SLUG ],
					'context'      => 'normal',
					'priority'     => 'high',
					'show_names'   => true,
					'cmb_styles'   => false,
				]
			);

			$cmb_position->add_field(
				[
					'name'             => __( 'Title', 'govpack' ),
					'id'               => 'title',
					'type'             => 'select',
					'show_option_none' => true,
					'options'          => Helpers::titles(),
				]
			);

			$cmb_position->add_field(
				[
					'name'     => __( 'Legislative Body', 'govpack' ),
					'id'       => 'legislative_body',
					'type'     => 'taxonomy_select',
					'taxonomy' => \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG,
				]
			);

			$cmb_position->add_field(
				[
					'name'     => __( 'State', 'govpack' ),
					'id'       => 'state',
					'type'     => 'taxonomy_select',
					'taxonomy' => \Newspack\Govpack\Tax\State::TAX_SLUG,
				]
			);

			$cmb_position->add_field(
				[
					'name'     => __( 'County', 'govpack' ),
					'id'       => 'county',
					'type'     => 'taxonomy_select',
					'taxonomy' => \Newspack\Govpack\Tax\County::TAX_SLUG,
				]
			);

			/**
			 * Communications metabox.
			 */
			$cmb_comms = new_cmb2_box(
				[
					'id'           => 'communication',
					'title'        => __( 'Communication channels', 'govpack' ),
					'object_types' => [ self::CPT_SLUG ],
					'context'      => 'normal',
					'priority'     => 'high',
					'show_names'   => true,
					'cmb_styles'   => false,
				]
			);

			$cmb_comms->add_field(
				[
					'name'       => __( 'Main phone number', 'govpack' ),
					'id'         => 'main_phone',
					'type'       => 'text',
					'attributes' => [
						'maxlength' => 40,
						'type'      => 'tel',
					],
				]
			);

			$cmb_comms->add_field(
				[
					'name'       => __( 'Secondary phone number', 'govpack' ),
					'id'         => 'secondary_phone',
					'type'       => 'text',
					'attributes' => [
						'maxlength' => 40,
						'type'      => 'tel',
					],
				]
			);

			$cmb_comms->add_field(
				[
					'name' => __( 'Email address', 'govpack' ),
					'id'   => 'email',
					'type' => 'text_email',
				]
			);

			$cmb_comms->add_field(
				[
					'name'       => __( 'Twitter', 'govpack' ),
					'id'         => 'twitter',
					'type'       => 'text',
					'attributes' => [
						'maxlength' => 15,
					],
				]
			);

			$cmb_comms->add_field(
				[
					'name'       => __( 'Instagram', 'govpack' ),
					'id'         => 'instagram',
					'type'       => 'text',
					'attributes' => [
						'maxlength' => 30,
					],
				]
			);

			$cmb_comms->add_field(
				[
					'name'       => __( 'Facebook', 'govpack' ),
					'id'         => 'facebook',
					'type'       => 'text',
					'attributes' => [
						'maxlength' => 50,
					],
				]
			);

			$cmb_comms->add_field(
				[
					'name' => __( 'LinkedIn URL', 'govpack' ),
					'id'   => 'linkedin',
					'type' => 'text_url',
				]
			);

			$cmb_comms->add_field(
				[
					'name' => __( 'Lesgislative website', 'govpack' ),
					'id'   => 'leg_url',
					'type' => 'text_url',
				]
			);

			$cmb_comms->add_field(
				[
					'name' => __( 'Campaign website', 'govpack' ),
					'id'   => 'campaign_url',
					'type' => 'text_url',
				]
			);
		
	}

	/**
	 * Set the post title based on the profile data (first and last name);
	 *
	 * @param array $data                An array of slashed, sanitized, and processed post data.
	 * @param array $postarr             An array of sanitized (and slashed) but otherwise unmodified post data.
	 * @param array $unsanitized_postarr An array of slashed yet *unsanitized* and unprocessed post data as
	 *                                   originally passed to wp_insert_post().
	 * @return array
	 */
	public static function set_profile_title( $data, $postarr, $unsanitized_postarr = false ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$title = join( ' ', array_filter( [ $postarr['first_name'] ?? '', $postarr['last_name'] ?? '' ] ) );
		if ( $title ) {
			$data['post_title'] = $title;
			$data['post_name']  = null;
		}
		return $data;
	}

	/**
	 * Fetch profile data into an array. Used for shortcode and block.
	 *
	 * @param int $profile_id    Array of shortcode attributes.
	 *
	 * @return array Profile data
	 */
	public static function get_data( $profile_id ) {
		$profile_id = absint( $profile_id );
		if ( ! $profile_id ) {
			return;
		}

		$profile_raw_data = get_post_meta( $profile_id );
		if ( ! $profile_raw_data ) {
			return;
		}

		if ( empty( $profile_raw_data['first_name'][0] ) || empty( $profile_raw_data['last_name'][0] ) ) {
			return;
		}

		$term_objects = wp_get_post_terms( $profile_id, [ \Newspack\Govpack\Tax\Party::TAX_SLUG, \Newspack\Govpack\Tax\State::TAX_SLUG, \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG ] );
		$term_data    = array_reduce(
			$term_objects,
			function( $carry, $item ) {
				$carry[ $item->taxonomy ] = $item->name;
				return $carry;
			},
			[]
		);

		$profile_data = [ // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
			'id'               => $profile_id,
			'first_name'       => $profile_raw_data['first_name'][0] ?? '',
			'last_name'        => $profile_raw_data['last_name'][0] ?? '',
			'title'            => $profile_raw_data['title'][0] ?? '',
			'phone'            => $profile_raw_data['main_phone'][0] ?? '',
			'twitter'          => $profile_raw_data['twitter'][0] ?? '',
			'instagram'        => $profile_raw_data['instagram'][0] ?? '',
			'email'            => $profile_raw_data['email'][0] ?? '',
			'facebook'         => $profile_raw_data['facebook'][0] ?? '',
			'website'          => $profile_raw_data['leg_url'][0] ?? '',
			'biography'        => $profile_raw_data['biography'][0] ?? '',
			'party'            => $term_data[ \Newspack\Govpack\Tax\Party::TAX_SLUG ] ?? '',
			'state'            => $term_data[ \Newspack\Govpack\Tax\State::TAX_SLUG ] ?? '',
			'legislative_body' => $term_data[ \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG ] ?? '',
		];

		return $profile_data;
	}

	/**
	 * Shortcode handler for [govpack].
	 *
	 * @param array  $atts    Array of shortcode attributes.
	 * @param string $content Post content.
	 *
	 * @return string HTML for recipe shortcode.
	 */
	public static function shortcode_handler( $atts, $content = null ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		if ( ! isset( $atts['id'] ) ) {
			return;
		}

		$profile_data = self::get_data( $atts['id'] );
		if ( ! $profile_data ) {
			return;
		}

		$atts = shortcode_atts(
			[
				'format'    => self::$default_profile_format,
				'className' => '',
			],
			$atts
		);

		if ( ! in_array( $atts['format'], self::$profile_formats, true ) ) {
			$atts['format'] = self::$default_profile_format;
		}

		$profile_data['format'] = $atts['format'];

		ob_start();
		require_once GOVPACK_PLUGIN_FILE . 'template-parts/profile.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Create a profile.
	 *
	 * @param array $data   Array of profile data.
	 *
	 * @return int|WP_Error The post ID on success. 0 or WP_Error on failure.
	 */
	public static function create( $data ) {
		if ( ! $data['first_name'] || ! $data['last_name'] ) {
			return;
		}

		$post_args = [
			'post_type'   => self::CPT_SLUG,
			'post_status' => 'publish',
			'meta_input'  => [
				'first_name' => $data['first_name'],
				'last_name'  => $data['last_name'],
			],
			'tax_input'   => [],
		];

		$meta_keys = [
			'govpack_id',
			'title',
			'main_office_address',
			'main_office_city',
			'main_office_state',
			'main_office_zip',
			'main_phone',
			'secondary_office_address',
			'secondary_office_city',
			'secondary_office_state',
			'secondary_office_zip',
			'secondary_phone',
			'leg_url',
			'email',
			'twitter',
			'facebook',
			'instagram',
			'biography',
		];

		foreach ( $meta_keys as $key ) {
			if ( ! empty( $data[ $key ] ) ) {
				$post_args['meta_input'][ $key ] = $data[ $key ];
			}
		}

		// Set the post title.
		$post_args = self::set_profile_title( $post_args, $data );

		// Insert the post and post metadata.
		$new_post = wp_insert_post( $post_args );
		if ( 0 === $new_post || is_wp_error( $new_post ) ) {
			return $new_post;
		}

		// Fetch the image.
		if ( ! empty( $data['image'] ) ) {
			$description = $data['first_name'] . ' ' . $data['last_name'];
			$image_id    = Helpers::upload_image( $data['image'], $new_post, $description );

			if ( is_wp_error( $image_id ) ) {
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					\WP_CLI::warning( "Failed to upload image [{$data['image']}] for profile $new_post." );
					foreach ( $image_id->errors as $error_info ) {
						foreach ( $error_info as $message ) {
							\WP_CLI::warning( $message );
						}
					}
				}
			} elseif ( $image_id ) {
				$result = set_post_thumbnail( $new_post, $image_id );
				if ( defined( 'WP_CLI' ) && WP_CLI ) {
					if ( $result ) {
						\WP_CLI::success( "Added image for profile $new_post." );
					} else {
						\WP_CLI::warning( "Failed to set post thumnbnail for profile $new_post." );
					}
				}
			}
		}

		// Insert the taxonomy separate. wp_insert_post() woill not insert
		// taxonomy data when run without a logged-in user, i.e. in CLI.
		$tax_map = [
			'state'            => \Newspack\Govpack\Tax\State::TAX_SLUG,
			'party'            => \Newspack\Govpack\Tax\Party::TAX_SLUG,
			'legislative_body' => \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG,
		];

		foreach ( $tax_map as $key => $tax_slug ) {
			if ( ! empty( $data[ $key ] ) ) {
				// If using term ID, need an array of integers; if you pass in an integer,
				// WP will create a new term with the integer as the name and slug.
				//
				// With OpenStates, parties will already be an array.
				$terms = is_array( $data[ $key ] ) ? $data[ $key ] : [ $data[ $key ] ];

				wp_set_post_terms( $new_post, $terms, $tax_slug );

				// If multiple parties exist, i.e. Democratic/Progressive in Vermont,
				// store the order in postmeta.
				if ( 'party' === $key && count( $terms ) > 1 ) {
					update_post_meta( $new_post, 'party_order', join( ',', $terms ) );
				}
			}
		}

		return $new_post;
	}

	/**
	 * Fetch stories related to a profile.
	 *
	 * @param integer $profile_id Profile id.
	 *
	 * @return WP_Query
	 */
	public static function get_stories( $profile_id ) {
		$term_id = get_post_meta( $profile_id, 'term_id', true );
		$args    = [
			'tax_query' => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => \Newspack\Govpack\Tax\Profile::TAX_SLUG,
					'field'    => 'id',
					'terms'    => $term_id,
				],
			],
		];

		return \Newspack\Govpack\Helpers::get_cached_query( $args, 'posts_govpack_profiles_' . $term_id );
	}
}

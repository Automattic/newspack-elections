<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class Profile {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const CPT_SLUG = 'govpack_profile';

	const SHORTCODE = 'govpack';


	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'register_post_type' ] );
		add_action( 'cmb2_admin_init', [ __CLASS__, 'add_profile_boxes' ] );
		add_filter( 'wp_insert_post_data', [ __CLASS__, 'set_profile_title' ], 10, 3 );
		add_action( 'edit_form_after_editor', [ __CLASS__, 'show_profile_title' ] );
		add_filter( 'manage_edit-' . self::CPT_SLUG . '_sortable_columns', [ __CLASS__, 'sortable_columns' ] );
		add_shortcode( self::SHORTCODE, [ __CLASS__, 'shortcode_handler' ] );
	}

	/**
	 * Register the Features post type
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
					'not_found'          => __( 'No people found.', 'govpack' ),
					'not_found_in_trash' => __( 'No people found in Trash.', 'govpack' ),
				],
				'has_archive'  => false,
				'public'       => true,
				'show_in_rest' => true,
				'show_ui'      => true,
				'supports'     => [ 'revisions', 'thumbnail' ],
				'taxonomies'   => [ 'post_tag' ],
				'menu_icon'    => 'dashicons-groups',
				'rewrite'      => [
					'slug'       => 'people',
					'with_front' => 'false',
				],
			]
		);
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
	 * Adds the post_type to array of supported post types.
	 *
	 * @param array $post_types   Array of post types.
	 *
	 * @return array
	 */
	public static function add_post_type( $post_types ) {
		$post_types[] = static::CPT_SLUG;

		return $post_types;
	}


	/**
	 * Denote State, Party and Legislative Body columns as sortable.
	 *
	 * @param array $sortable_columns An array of sortable columns.
	 */
	public static function sortable_columns( $sortable_columns ) {
		$sortable_columns[ 'taxonomy-' . State::TAX_SLUG ]            = 'State';
		$sortable_columns[ 'taxonomy-' . Party::TAX_SLUG ]            = 'Party';
		$sortable_columns[ 'taxonomy-' . Legislative_Body::TAX_SLUG ] = 'Legislative Body';
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
				'name'     => __( 'Party', 'govpack' ),
				'id'       => 'party',
				'type'     => 'taxonomy_select',
				'taxonomy' => Party::TAX_SLUG,
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
					'type' => 'text',
				]
			);

			$box->add_field(
				[
					'name' => __( 'Address Line 2', 'govpack' ),
					'id'   => $slug . '_address2',
					'type' => 'text',
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
						'size'      => 10,
						'maxlength' => 10,
						'type'      => 'number',
					],
				]
			);

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
					'taxonomy' => Legislative_Body::TAX_SLUG,
				]
			);

			$cmb_position->add_field(
				[
					'name'     => __( 'State', 'govpack' ),
					'id'       => 'state',
					'type'     => 'taxonomy_select',
					'taxonomy' => State::TAX_SLUG,
				]
			);

			$cmb_position->add_field(
				[
					'name'     => __( 'County', 'govpack' ),
					'id'       => 'county',
					'type'     => 'taxonomy_select',
					'taxonomy' => County::TAX_SLUG,
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
						'size'      => 30,
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
						'size'      => 30,
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
						'size'      => 15,
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
						'size'      => 30,
						'maxlength' => 30,
					],
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

			$cmb_comms->add_field(
				[
					'name' => __( 'Facebook URL', 'govpack' ),
					'id'   => 'facebook',
					'type' => 'text_url',
				]
			);

			$cmb_comms->add_field(
				[
					'name' => __( 'LinkedIn URL', 'govpack' ),
					'id'   => 'linkedin',
					'type' => 'text_url',
				]
			);
		}
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
	public static function set_profile_title( $data, $postarr, $unsanitized_postarr ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$title = join( ' ', array_filter( [ $postarr['first_name'] ?? '', $postarr['last_name'] ?? '' ] ) );
		if ( $title ) {
			$data['post_title'] = $title;
			$data['post_name']  = null;
		}
		return $data;
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

		$profile_id = $atts['id'];

		$profile_raw_data = get_post_meta( $profile_id );
		if ( ! $profile_raw_data ) {
			return;
		}

		if ( empty( $profile_raw_data['first_name'][0] ) || empty( $profile_raw_data['last_name'][0] ) ) {
			return;
		}

		$term_objects = wp_get_post_terms( $profile_id, [ Party::TAX_SLUG, State::TAX_SLUG, Legislative_Body::TAX_SLUG ] );
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
			'party'            => $term_data[ Party::TAX_SLUG ] ?? '',
			'state'            => $term_data[ State::TAX_SLUG ] ?? '',
			'legislative_body' => $term_data[ Legislative_Body::TAX_SLUG ] ?? '',
		];

		ob_start();
		require_once GOVPACK_PLUGIN_FILE . 'template-parts/profile.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
		$html = ob_get_clean();

		return $html;
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Profile', 'hooks' ] );

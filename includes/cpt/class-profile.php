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


	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ get_called_class(), 'register_post_type' ] );

		add_action( 'cmb2_admin_init', [ __CLASS__, 'add_profile_boxes' ] );
		// add_action( 'fm_post_' . self::CPT_SLUG, [ __CLASS__, 'add_profile_fields' ] );
		add_filter( 'wp_insert_post_data', [ __CLASS__, 'set_profile_title' ], 10, 3 );
		add_action( 'edit_form_after_editor', [ __CLASS__, 'show_profile_title' ] );
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
	 * Using CMB2, add custom fields to profile.
	 */
	public static function add_profile_boxes() {
		/**
		 * Initiate the metabox
		 */
		$cmb = new_cmb2_box(
			[
				'id'           => 'id',
				'title'        => __( 'Name', 'cmb2' ),
				'object_types' => [ self::CPT_SLUG ],
				'context'      => 'normal',
				'priority'     => 'high',
				'show_names'   => true,
				'cmb_styles'   => false,
			] 
		);

		$cmb->add_field(
			[
				'name'             => __( 'Prefix', 'cmb2' ),
				'id'               => 'prefix',
				'type'             => 'select',
				'show_option_none' => true,
				'options'          => Helpers::prefixes(),
			] 
		);

		$cmb->add_field(
			[
				'name' => __( 'First name', 'cmb2' ),
				'id'   => 'first_name',
				'type' => 'text',
			] 
		);

		$cmb->add_field(
			[
				'name' => __( 'Last name', 'cmb2' ),
				'id'   => 'last_name',
				'type' => 'text',
			] 
		);

		$cmb->add_field(
			[
				'name'             => __( 'Party', 'cmb2' ),
				'id'               => 'party',
				'type'             => 'select',
				'show_option_none' => true,
				'options'          => Helpers::parties(),
			] 
		);
	}

	/**
	 * Using FieldManager, add custom fields to profile.
	 */
	public static function add_profile_fields() {
		$fm = new \Fieldmanager_Group(
			[
				'name'     => 'id',
				'children' => [
					'prefix'     => new \Fieldmanager_Select(
						'Prefix',
						[
							'options'     => Helpers::prefixes(),
							'first_empty' => true,
						]
					),
					'first_name' => new \Fieldmanager_Textfield( 'First Name', [ 'required' => true ] ),
					'last_name'  => new \Fieldmanager_Textfield( 'Last Name', [ 'required' => true ] ),
					'party'      => new \Fieldmanager_Select(
						'Party',
						[
							'options'     => Helpers::parties(),
							'first_empty' => true,
						]
					),
				],
			]
		);
		$fm->add_meta_box( 'Name', self::CPT_SLUG );

		$fm = new \Fieldmanager_Group( self::address_fields( 'main_office' ) );
		$fm->add_meta_box( 'Main Office Address', self::CPT_SLUG );

		$fm = new \Fieldmanager_Group( self::address_fields( 'secondary_office' ) );
		$fm->add_meta_box( 'Secondary Office Address', self::CPT_SLUG );
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
		$title = join( ' ', array_filter( [ $postarr['id']['first_name'] ?? '', $postarr['id']['last_name'] ?? '' ] ) );
		if ( $title ) {
				$data['post_title'] = $title;
				$data['post_name']  = null;
		}
		return $data;
	}

	/**
	 * Return an array containing address fields.
	 *
	 * @param string $label  A unique identified for the field group.
	 * @return array
	 */
	public static function address_fields( $label ) {
		return [
			'name'     => $label,
			'children' => [
				'address'  => new \Fieldmanager_Textfield( 'Address' ),
				'address2' => new \Fieldmanager_Textfield( 'Address Line 2' ),
				'city'     => new \Fieldmanager_Textfield( 'City' ),
				'state'    => new \Fieldmanager_Select(
					'State',
					[
						'options'     => Helpers::states(),
						'first_empty' => true,
					]
				),
				'zip'      => new \Fieldmanager_Textfield(
					'Zip',
					[
						'attributes' => [
							'size'      => 10,
							'maxlength' => 10,
						],
					]
				),
			],
		];
	}
}

add_action( 'after_setup_theme', [ '\Newspack\Govpack\Profile', 'hooks' ] );

<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Profile;

use Govpack\Fields\FieldManager;

use Govpack\Fields\Field\PostProperty as PostPropertyField;
use Govpack\Fields\Field\Text as TextField;
use Govpack\Fields\Field\Link as LinkField;
use Govpack\Fields\Field\Email as EmailField;
use Govpack\Fields\Field\Phone as PhoneField;
use Govpack\Fields\Field\Date as DateField;
use Govpack\Fields\Field\Taxonomy as TaxonomyField;
use Govpack\Fields\Field\Service as ServiceField;

use Govpack\ProfileLinks;
use Govpack\ProfileLinkServices;
use WP_Screen;
use WP_Post_Type;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class CPT extends \Govpack\Abstracts\PostType {

	use \Govpack\Instance;

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const CPT_SLUG = 'govpack_profiles';

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TEMPLATE_NAME = 'single-govpack-profiles.php';

	/**
	 * Fields used for the profile
	 */
	public static FieldManager $fields;

	/**
	 * Fields used for the profile
	 */
	//public static FieldTypeRegistry $field_types;

	/**
	 * Groups in which fields may appear;
	 */
	public static $field_groups = [];

	/**
	 * Initalise a Profile Post Type
	 */
	public static function init() {
		$pt = self::instance();
		
		self::hooks();
		self::register_profile_fields();
	}

	/**
	 * WordPress Hooks
	 */
	public static function hooks(): void {
		parent::hooks();
		\add_action( 'init', [ __CLASS__, 'register_post_meta' ] );
		
		\add_action( 'wp_after_insert_post', [ __CLASS__, 'set_profile_title' ], 10, 4 );
		\add_action( 'edit_form_after_editor', [ __CLASS__, 'show_profile_title' ] );
		\add_filter( 'manage_edit-' . self::CPT_SLUG . '_sortable_columns', [ __CLASS__, 'sortable_columns' ] );
		\add_filter( 'manage_' . self::CPT_SLUG . '_posts_columns', [ __CLASS__, 'custom_columns' ] );
		\add_filter( 'manage_' . self::CPT_SLUG . '_posts_custom_column', [ __CLASS__, 'custom_columns_content' ], 10, 2 );
		
		\add_filter( 'default_hidden_columns', [ __CLASS__, 'hidden_columns' ], 10, 2 );
		\add_action( 'restrict_manage_posts', [ __CLASS__, 'post_table_filters' ], 10, 2 );

		add_filter( 'disable_months_dropdown', [ __CLASS__, 'disable_months_dropdown' ], 10, 2 );

		add_filter( 'bulk_actions-edit-' . self::CPT_SLUG, [ __CLASS__, 'filter_bulk_actions' ], 10 );
		add_filter( 'handle_bulk_actions-edit-' . self::CPT_SLUG, [ __CLASS__, 'handle_bulk_publish' ], 10, 3 );

		add_filter( 'govpack_profile_register_meta_field_args', [ __CLASS__, 'filter_meta_registration_for_links' ], 10, 2 );
		
		add_action( 'init', [ __CLASS__, 'add_rest_fields' ] );
		
		
		add_filter( 'default_post_metadata', [ __CLASS__, 'fallback_x_meta_fields_to_twitter' ], 10, 5 );
		add_filter( 'default_post_metadata', [ __CLASS__, 'fallback_ballotpedia_to_balletpedia' ], 10, 5 );
		add_filter( 'default_post_metadata', [ __CLASS__, 'fallback_suffix_official_to_capitol' ], 10, 5 );
		add_filter( 'default_post_metadata', [ __CLASS__, 'fallback_wikipedia_id_to_wikipedia' ], 10, 5 );

		//add_filter( 'get_post_metadata', [ __CLASS__, 'fallback_suffix_official_to_capitol' ], 10, 5 );

		add_action( 'load-post.php', [ __CLASS__, 'initialize_editor_changes' ] );
		add_action( 'load-post-new.php', [ __CLASS__, 'initialize_editor_changes' ] );
	}

	public static function initialize_editor_changes() {
		// globals
		global $typenow;

		if ( $typenow !== self::CPT_SLUG ) {
			return;
		}

		add_action( 'add_meta_boxes', [ __CLASS__, 'modify_meta_boxes' ], 10, 2 );
	}

	public static function fields() {
		if ( empty( self::$fields ) ) {
			self::register_profile_fields();
		}

		return self::$fields;
	}

	public static function register_profile_fields() {
		

		self::$fields = new FieldManager();
		//self::$fields->set_types(self::$field_types);
		

		self::$fields->register_fields(
			[
				( new TextField( 'name', 'Name' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'name_prefix', 'Prefix' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'name_first', 'First Name' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'name_middle', 'Middle Name(s)' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'name_last', 'Last Name' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'name_suffix', 'Suffix' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'nickname', 'Nickname' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'occupation', 'Occupation' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'education', 'Education' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'gender', 'Gender' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'race', 'Race' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'ethnicity', 'Ethnicity' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new DateField( 'date_of_birth', 'Date of Birth' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new DateField( 'date_of_death', 'Date of Death' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'district', 'District' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),
				( new TextField( 'endorsements', 'Endorsements' ) )
					->group( FieldManager::GROUPS['ABOUT'] ),

				( new LinkField( 'contact_form_url', 'Contact Form URL', 'link' ) )->link_text( 'Contact Form' ),
				new DateField( 'date_assumed_office', 'Date Assumed Office' ),
				new TextField( 'appointed_by', 'Appointed By' ),
				new DateField( 'appointed_date', 'Appointed On' ),
				new DateField( 'confirmed_date', 'Confirmed On' ),
				new DateField( 'term_end_date', 'Term Ended/Ends On' ),
				new DateField( 'congress_year', 'Congressional Year' ),

				new EmailField( 'email_other', 'Other Email Address' ),
				new EmailField( 'email_official', 'Official Email Address' ),
				new EmailField( 'email_district', 'District Email Address' ),
				new EmailField( 'email_campaign', 'Campaign Email Address' ),
				
				
				new TextField( 'address_official', 'Official Address' ),
				new TextField( 'address_district', 'District Address' ),
				new TextField( 'address_campaign', 'Campaign Address' ),

				
				new PhoneField( 'phone_official', 'Official Phone Number' ),
				new PhoneField( 'phone_district', 'District Phone Number' ),
				new PhoneField( 'phone_campaign', 'Campaign Phone Number' ),

				
				( new PhoneField( 'fax_official', 'Official Fax Number' ) )->set_display_icon( 'fax' ),
				( new PhoneField( 'fax_district', 'District Fax Number' ) )->set_display_icon( 'fax' ),
				( new PhoneField( 'fax_campaign', 'Campaign Fax Number' ) )->set_display_icon( 'fax' ),

				( new LinkField( 'website_personal', 'Personal Website URL' ) ),
				( new LinkField( 'website_campaign', 'Campaign Website URL' ) )->link_text( 'Campaign Website' ),
				( new LinkField( 'website_district', 'District Website URL' ) )->link_text( 'District Website' ),
				
				( new LinkField( 'website_official', 'Official Website URL' ) )->link_text( 'Official Website' ),
				( new LinkField( 'rss', 'RSS Feed URL' ) )->link_text( 'RSS Feed' ),

				( new ServiceField( 'ballotpedia', 'Ballotpedia' ) )->set_service( \Govpack\Fields\Service\Ballotpedia::class )->meta( 'ballotpedia_id' ),
				( new ServiceField( 'fec_id', 'Federal Election Commission' ) )->set_service( 'fec' ),
				( new ServiceField( 'gab', 'Gab' ) )->set_service( 'gab' ),
				( new ServiceField( 'linkedin', 'LinkedIn' ) )->set_service( 'linkedin' )->link_text( 'LinkedIn' ),
				( new ServiceField( 'rumble', 'Rumble', 'link' ) )->set_service( 'rumble' ),
				( new ServiceField( 'opensecrets_id', 'Open Secrets' ) )->set_service( 'open-secrets' ),
				( new ServiceField( 'openstates_id', 'OpenStates' ) )->set_service( 'open-states' ),
				( new ServiceField( 'wikipedia', 'Wikipedia ID' ) )->set_service( 'wikipedia' ),
				
				// Legacy maybe to  be reincluded later, need updated to services
				//new TextField( 'google_entity_id', 'Google Entity ID' ),
				//new TextField( 'govtrack_id', 'GovTrack ID' ),
				//new TextField( 'votesmart_id', 'VoteSmart ID' ),
				//new TextField( 'usio_id', 'BioGuide' ),
				//new TextField( 'icpsr_id', 'Voteview' ),

				( new PostPropertyField( 'bio', 'Biography' ) )->key( 'post_excerpt' )->block( 'npe/profile-bio' ),
				( new PostPropertyField( 'postname', 'Name' ) )->key( 'post_title' )->block( 'npe/profile-name' ),

				new TaxonomyField( 'party', 'Party', \Govpack\Tax\Party::TAX_SLUG ),
				new TaxonomyField( 'state', 'State', \Govpack\Tax\State::TAX_SLUG ),
				new TaxonomyField( 'legislative_body', 'Office', \Govpack\Tax\LegislativeBody::TAX_SLUG ),
				new TaxonomyField( 'position', 'Office Title', \Govpack\Tax\OfficeHolderTitle::TAX_SLUG ),
				new TaxonomyField( 'status', 'Office Status', \Govpack\Tax\OfficeHolderStatus::TAX_SLUG ),

				
			]
		);

		self::$fields->register_fields(
			[
				( new ServiceField( 'x_official', 'Official X' ) )->set_service( 'x' ),
				( new ServiceField( 'x_campaign', 'Campaign X' ) )->set_service( 'x' ),
				( new ServiceField( 'x_personal', 'Personal X' ) )->set_service( 'x' ),
			]
		);

		self::$fields->register_fields(
			[
				( new ServiceField( 'facebook_official', 'Official Facebook' ) )->set_service( 'facebook' ),
				( new ServiceField( 'facebook_campaign', 'Campaign Facebook' ) )->set_service( 'facebook' ),
				( new ServiceField( 'facebook_personal', 'Personal Facebook' ) )->set_service( 'facebook' ),
			]
		);

		self::$fields->register_fields(
			[
				( new ServiceField( 'instagram_official', 'Official Instagram' ) )->set_service( 'instagram' ),
				( new ServiceField( 'instagram_campaign', 'Campaign Instagram' ) )->set_service( 'instagram' ),
				( new ServiceField( 'instagram_personal', 'Personal Instagram' ) )->set_service( 'instagram' ),
			]
		);

		self::$fields->register_fields(
			[
				( new ServiceField( 'youtube_official', 'Official YouTube' ) )->set_service( 'youtube' ),
				( new ServiceField( 'youtube_campaign', 'Campaign YouTube' ) )->set_service( 'youtube' ),
				( new ServiceField( 'youtube_personal', 'Personal YouTube' ) )->set_service( 'youtube' ),
			]
		);
	}

	//public static function get_field_types(): array {
	//  return self::$fields->get_types();
	//}
	public static function fallback_suffix_official_to_capitol( mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed {

		$fallback_map = [
			'email_official'   => 'email_capitol',
			'address_official' => 'address_capitol',
			'phone_official'   => 'phone_capitol',
			'fax_official'     => 'fax_capitol',
			'website_official' => 'website_capitol',
		];
	

		if ( ! isset( $fallback_map[ $meta_key ] ) ) {
			return $value;
		}

	

		if ( $single && $value !== '' ) {
			return $value;
		}

	

		// check for an empty array if we expect an array, exit otherwise
		if ( ! $single && ! empty( $value ) ) {
			return $value;
		}

		// if we're looking at some other entity type then exit
		if ( $meta_type !== 'post' ) {
			return $value;
		}

		return get_metadata( $meta_type, $object_id, $fallback_map[ $meta_key ], $single );
	}

	
	public static function fallback_ballotpedia_to_balletpedia( mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed {
		
		if ( $meta_key !== 'ballotpedia_id' ) {
			return $value;
		}

		if ( $single && $value !== '' ) {
			return $value;
		}

		// check for an empty array if we expect an array, exit otherwise
		if ( ! $single && ! empty( $value ) ) {
			return $value;
		}

		// if we're looking at some other entity type then exit
		if ( $meta_type !== 'post' ) {
			return $value;
		}

		return get_metadata( $meta_type, $object_id, 'balletpedia_id', $single );
	}

	public static function fallback_wikipedia_id_to_wikipedia( mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed {
		
		if ( $meta_key !== 'wikipedia_id' ) {
			return $value;
		}

		if ( $single && $value !== '' ) {
			return $value;
		}

		// check for an empty array if we expect an array, exit otherwise
		if ( ! $single && ! empty( $value ) ) {
			return $value;
		}

		// if we're looking at some other entity type then exit
		if ( $meta_type !== 'post' ) {
			return $value;
		}

		return get_metadata( $meta_type, $object_id, 'wikipedia', $single );
	}

	public static function fallback_x_meta_fields_to_twitter( mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed {

		// check for an empty string if we expect a string, exit otherwise
		if ( $single && $value !== '' ) {
			return $value;
		}

		// check for an empty array if we expect an array, exit otherwise
		if ( ! $single && ! empty( $value ) ) {
			return $value;
		}
		
		// if we're looking at some other entity type then exit
		if ( $meta_type !== 'post' ) {
			return $value;
		}

		// if not a request for one of our specific keys, exit
		$target_keys = [ 'x_official', 'x_campaign', 'x_personal' ];
		if ( ! in_array( $meta_key, $target_keys, true ) ) {
			return $value;
		}

		$fallback_key = str_replace( 'x_', 'twitter_', $meta_key );
		
		return get_metadata( $meta_type, $object_id, $fallback_key, $single );
	}

	public static function add_rest_fields(): void {
		register_rest_field(
			self::CPT_SLUG,
			'profile_links',
			[
				'get_callback'    => function ( $request ) {
					return self::generate_links_for_profile( $request['id'] );
				},
				'update_callback' => false,
				'schema'          => [
					'description' => 'Links to 3rd party services and pages for this profile',
					'type'        => 'array',
					'items'       => [
						'type'       => 'object',
						'properties' => [
							'meta'   => 'string',
							'target' => 'string',
							'href'   => 'string',
							'id'     => 'string',
							'rel'    => 'string',
							'class'  => 'string',
						],
					],
					'context'     => [ 'view', 'edit' ],
					'readonly'    => true,
				],
			] 
		);

		register_rest_field(
			self::CPT_SLUG,
			'link_services',
			[
				'get_callback'    => function ( $request ) {

					/*
						When a profile is edited, the "enabled" property of a link service  is always set to "undefined" 
						when passed as a boolean. This is something to do with the pre-fetch middleware used to save the 
						http request. There is no use for the disabled link services anyway so just filter them out. 
						For completeness, pass the enabled property as a string "true". False would just become 
						undefined anyway.
					*/
					$links = array_filter(
						self::generate_link_services( $request['id'] ),
						function ( $link ) {
							return $link['enabled'];
						},
						true
					);

					$links = \array_map(
						function ( $link ) {
							$link['enabled'] = $link['enabled'] ? 'true' : false;
							return $link;
						},
						$links
					);

			
					return $links;
				},
				'update_callback' => false,
				'schema'          => [
					'description' => 'Links to 3rd party services and pages for this profile',
					'type'        => 'array',
					'items'       => [
						'type'       => 'object',
						'properties' => [
							'enabled' => [
								'type'     => 'boolean',
								'context'  => 'view',
								'default'  => false,
								'readonly' => true,
							],
						],
					],
					'context'     => [ 'edit', 'view' ],
					'readonly'    => true,
				],
			] 
		);

		register_rest_field(
			self::CPT_SLUG,
			'profile',
			[
				'get_callback'    => function ( $request ) {

					$model = Profile::get( $request['id'] );
					return $model->values_for_rest();
				},
				'update_callback' => false,
				'schema'          => [
					'description' => 'Gets the computed profile model',
					'type'        => 'array',
					
					'context'     => [ 'edit', 'view' ],
					'readonly'    => true,
				],
			] 
		);
	}

	public static function populate_values(): array {

		$data = [];
		foreach ( self::$fields->all() as $field ) {
			$data[ $field->slug() ] = $field->value();
		}

		return $data;
	}

	

	/**
	 * Publishes Posts with ID passed. Handle the bulk actions from List Table
	 * 
	 * @param string $sendback URL to redirect to.
	 * @param string $doaction Bulk action we're doing.
	 * @param array  $post_ids Array fof post IDs to publish.
	 */
	public static function handle_bulk_publish( string $sendback, string $doaction, array $post_ids ): string {

		$published = 0;

		foreach ( (array) $post_ids as $post_id ) {
			
			if ( ! current_user_can( 'publish_posts', $post_id ) ) {
				wp_die( __( 'Sorry, you are not allowed to publish this item.', 'newspack-elections' ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			wp_update_post(
				[
					'ID'          => $post_id,
					'post_status' => 'publish',
				]
			);

			++$published;
		
		}
		return add_query_arg( 'published', $published, $sendback );
	}

	/**
	 * Add Publish to the bulk actions
	 * 
	 * @param array $actions Bulk actions to filter.
	 */
	public static function filter_bulk_actions( array $actions ): array {
		$actions['publish'] = 'Publish';
		return $actions;
	}
	/**
	 * Disabled The Months Dropdown in the WP_List_Table
	 * 
	 * @param boolean $disable Boolean of wether or not its already been disabled  or not, possibly be another filter.
	 * @param string  $post_type Slug of the post type being viewed in the admin.
	 * @return boolean
	 */
	public static function disable_months_dropdown( bool $disable, string $post_type ): bool {

		if ( self::CPT_SLUG === $post_type ) {
			return true;
		}

		return $disable;
	}

	/**
	 * Adds Columns to the List of Columns Hidden by Default, They can be turned on in screen options
	 * 
	 * @param array  $hidden Array of columns available to the list table.
	 * @param object $screen WP_Screen Object of the currently view.
	 * @return array
	 */
	public static function hidden_columns( array $hidden, WP_Screen $screen ): array {

		if ( 'edit-govpack_profiles' === $screen->id ) {
			$hidden[] = 'email';
			$hidden[] = 'phone';
		}

		return $hidden;
	}

	/**
	 * Register the Profiles post type
	 *
	 * @return object|WP_Error
	 */
	public static function register_post_type(): WP_Post_Type {

		$permalinks          = gp_get_permalink_structure();
		$permalink_structure = ( isset( $permalinks['profile_base'] ) ? $permalinks['profile_base'] : 'profile' );
		
		return register_post_type( // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
			self::CPT_SLUG,
			\apply_filters(
				'govpack_register_post_type_profile',
				[
					'labels'       => [
						'name'               => _x( 'Election Profiles', 'post type general name', 'newspack-elections' ),
						'singular_name'      => _x( 'Election Profile', 'post type singular name', 'newspack-elections' ),
						'menu_name'          => _x( 'Election Profiles', 'admin menu', 'newspack-elections' ),
						'name_admin_bar'     => _x( 'Profile', 'add new on admin bar', 'newspack-elections' ),
						'add_new'            => _x( 'Add New', 'popup', 'newspack-elections' ),
						'add_new_item'       => __( 'Add New Profile', 'newspack-elections' ),
						'new_item'           => __( 'New Profile', 'newspack-elections' ),
						'edit_item'          => __( 'Edit Profile', 'newspack-elections' ),
						'view_item'          => __( 'View Profile', 'newspack-elections' ),
						'all_items'          => __( 'Profiles', 'newspack-elections' ),
						'search_items'       => __( 'Search Profiles', 'newspack-elections' ),
						'not_found'          => __( 'No profiles found.', 'newspack-elections' ),
						'not_found_in_trash' => __( 'No profiles found in Trash.', 'newspack-elections' ),
						
						'set_featured_image' => __( 'Set Profile Image', 'newspack-elections' ),
					],
					'has_archive'  => true,
					'public'       => true,
					'show_in_rest' => true,
					'show_ui'      => true,
					'supports'     => [ 'revisions', 'thumbnail', 'editor', 'custom-fields', 'title', 'excerpt' ],
					'menu_icon'    => self::create_menu_svg(),
					'rewrite'      => [
						'slug'       => apply_filters( 'govpack_profile_filter_slug', $permalink_structure ),
						'with_front' => false,
					],
					'template'     => [
						[ self::get_default_profile_block() ],
					],
				]
			)
		);
	}

	public static function get_default_profile_block() {
		return 'govpack/profile-self';
	}

	public static function get_menu_svg() {

		return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24">
			<path
				fillRule="evenodd"
				fill="black"
				d="M7.25 16.437a6.5 6.5 0 1 1 9.5 0V16A2.75 2.75 0 0 0 14 13.25h-4A2.75 2.75 0 0 0 7.25 16v.437Zm1.5 1.193a6.47 6.47 0 0 0 3.25.87 6.47 6.47 0 0 0 3.25-.87V16c0-.69-.56-1.25-1.25-1.25h-4c-.69 0-1.25.56-1.25 1.25v1.63ZM4 12a8 8 0 1 1 16 0 8 8 0 0 1-16 0Zm10-2a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"
				clipRule="evenodd"
			/>
		</svg>';
	}

	public static function create_menu_svg() {
		return sprintf( 'data:image/svg+xml;base64,%s', base64_encode( self::get_menu_svg() ) );
	}

	/**
	 * Returns an array of keys for the data model and how to handle them in import
	 *
	 * @return array
	 */
	public static function get_import_model(): array {

		$model = [];

		foreach ( self::get_meta_keys() as $key ) {
			$model[ $key ] = [
				'type' => 'meta',
				'key'  => $key,
			];
		}

		$taxonomies = [
			'office_status' => 'govpack_officeholder_status',
			'office_state'  => 'govpack_state',
			'office_name'   => 'govpack_legislative_body',
			'party'         => 'govpack_party',
			'office_title'  => 'govpack_officeholder_title',
		];

		foreach ( $taxonomies as $key => $taxonomy ) {
			$model[ $key ] = [
				'type'     => 'taxonomy',
				'key'      => $key,
				'taxonomy' => $taxonomy,
			];
		}
		
		$post_fields = [
			'bio' => 'post_content',
		];

		foreach ( $post_fields as $key => $attr ) {
			$model[ $key ] = [
				'type' => 'post',
				'key'  => $attr,
			];
		}

		$model['image'] = [
			'type' => 'media',
			'key'  => '_thumbnail_id',
		];

		return apply_filters( 'govpack_profile_import_model', $model );
	}

	/**
	 * Returns an array of keys for the data model and how to handle them in export
	 *
	 * @return array
	 */
	public static function get_export_model(): array {

		$model = self::get_import_model();

		$model['post_id'] = [
			'type' => 'post',
			'key'  => 'ID',
		];

		$model['post_status'] = [
			'type' => 'post',
			'key'  => 'post_status',
		];

		$model['thumbnail_id'] = [
			'type' => 'post',
			'key'  => '_thumbnail_id',
		];

		return apply_filters( 'govpack_profile_export_model', $model );
	}

	/**
	 * Get all the meta keys we use 
	 */
	public static function get_meta_keys(): array {

		$fields = self::fields()->get_by_source( 'meta' );

		$meta_keys = wp_list_pluck( $fields, 'meta_key' );

		return apply_filters( 'govpack_profile_meta_keys', $meta_keys );
	}

	/**
	 * Register Meta data for the post in the REST API 
	 */
	public static function register_post_meta(): void {

		
		foreach ( self::get_meta_keys() as $key ) {
			
			self::register_meta( $key );
		}
	}   

	/**
	 * Register single Meta data for the post in the REST API 
	 * 
	 * @param string $slug name of the meta_field to register.
	 * @param array  $args extra arguments the meta_field may take.
	 */
	public static function register_meta( string $slug, array $args = [] ): void {

		

		$args = apply_filters(
			'govpack_profile_register_meta_field_args',
			array_merge(
				[
					'show_in_rest'  => true,
					'single'        => true,
					'type'          => 'string',
					'auth_callback' => function () {
						return current_user_can( 'edit_posts' );
					},
				],
				$args
			),
			$slug 
		);

		register_post_meta( self::CPT_SLUG, $slug, $args );
	}

	public static function filter_meta_registration_for_links( array $args = [], string $slug = '' ): array {
		if ( $slug !== 'links' ) {
			return $args;
		}

		$args['type']    = 'object';
		$args['default'] = [];

		return $args;
	}
	/**
	 * Print out the post title where the normal title field would be. This post type does not
	 * `supports` the title field; it is constructed from the profile data.
	 */
	public static function show_profile_title(): void {
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
	public static function sortable_columns( array $sortable_columns ): array {
		$sortable_columns[ 'taxonomy-' . \Govpack\Tax\State::TAX_SLUG ]              = 'State';
		$sortable_columns[ 'taxonomy-' . \Govpack\Tax\Party::TAX_SLUG ]              = 'Party';
		$sortable_columns[ 'taxonomy-' . \Govpack\Tax\LegislativeBody::TAX_SLUG ]    = 'Legislative Body';
		$sortable_columns[ 'taxonomy-' . \Govpack\Tax\OfficeHolderStatus::TAX_SLUG ] = 'Office Holder Status';
		$sortable_columns[ 'taxonomy-' . \Govpack\Tax\OfficeHolderTitle::TAX_SLUG ]  = 'Office Holder Title';
	
		return $sortable_columns;
	}

	/**
	 * Add The Pfofile Photo to the post Table.
	 *
	 * @param array $columns An array of columns.
	 */
	public static function custom_columns( array $columns ): array {
		

		// I want the image between the checkbox and the title so we have to slice up the columns array.
		// Add the new colum and merge it all back together.
		$before  = array_splice( $columns, 0, 1 );
		$new     = [ 'image' => 'Picture' ];
		$after   = array_splice( $columns, 0 );
		$columns = array_merge( $before, $new, $after );


		// generally I want to add new columns Before Date.
		// splice the array to remove date.
		$date = array_splice( $columns, -1, 1 );
		// add the new columns.
		$columns['phone'] = 'Main Phone';
		$columns['email'] = 'Email';

		// remerge date on the end.
		$columns = array_merge( $columns, $date );

		return $columns;
	}

	/**
	 * Adds Dropdowns to the WP_List_Table for the post_type
	 *
	 * @param string $post_type slug of the post type we want add the dropdowns to.
	 * @param string $which unknown, kept fo it triggers the cirrect function from the filter call.
	 */
	public static function post_table_filters( string $post_type, $which ): void {
		
		self::taxonomy_dropdown( \Govpack\Tax\LegislativeBody::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Tax\State::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Tax\Party::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Tax\OfficeHolderStatus::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Tax\OfficeHolderTitle::TAX_SLUG, $post_type );
	}


	/**
	 * Displays a categories drop-down for filtering on the Posts list table.
	 *
	 * @since 4.6.0
	 *
	 * @global int $cat Currently selected category.
	 *
	 * @param string $taxonomy Taxonomy slug.
	 * @param string $post_type Post type slug.
	 */
	public static function taxonomy_dropdown( string $taxonomy, string $post_type ): void {

		if ( isset( $_REQUEST[ $taxonomy ] ) ) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$current = sanitize_key( wp_unslash( $_REQUEST[ $taxonomy ] ) ); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
		
		} else {
			$current = false;
		}

		
		/**
		 * Filters whether to remove the 'Categories' drop-down from the post list table.
		 *
		 * @since 4.6.0
		 *
		 * @param bool   $disable   Whether to disable the categories drop-down. Default false.
		 * @param string $post_type Post type slug.
		 */
		if ( false !== apply_filters( 'disable_categories_dropdown', false, $post_type ) ) {
			return;
		}

		if ( is_object_in_taxonomy( $post_type, $taxonomy ) ) {
			$dropdown_options = [
				'show_option_all' => get_taxonomy( $taxonomy )->labels->all_items,
				'hide_empty'      => 0,
				'hierarchical'    => 1,
				'show_count'      => 0,
				'orderby'         => 'name',
				'selected'        => $current,
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'value_field'     => 'slug',
				'hide_if_empty'   => true,
			];

			?>
			<label class="screen-reader-text" for="cat">
				<?php echo esc_html( get_taxonomy( $taxonomy )->labels->filter_by_item ); ?>
			</label>
			<?php
			wp_dropdown_categories( $dropdown_options );
		}
	}


	

	/**
	 * Add The Pfofile Photo to the post Table.
	 *
	 * @param string $column_key the key of the column used in WP_List_Table.
	 * @param int    $post_id id of the post being displayed in the row.
	 */
	public static function custom_columns_content( string $column_key, int $post_id ): void {

		if ( 'image' === $column_key ) {
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, [ 90, 90 ] );
			}
		}

		if ( 'phone' === $column_key ) {
			

				$phone = get_post_meta( $post_id, 'main_phone', true );
			if ( $phone ) {
				
				?>
				<a href="tel:<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( $phone ); ?></a>
				<?php
			}
		}

		if ( 'email' === $column_key ) {
			$email = get_post_meta( $post_id, 'email', true );
			if ( $email ) {
				?>
				<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				<?php
			}       
		}
	}

	/**
	 * Set the post title based on the profile data (first and last name);
	 */
	public static function set_profile_title( string|int $post_id, \WP_Post $post, $update, $post_before ): void { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		
		
		if ( $post->post_type !== self::CPT_SLUG ) {
			return;
		}

		if (
			( $post->post_title ) && ( $post->post_title !== '' )
		) {
			return;
		}

		if ( ( $post->name ) && ( $post->name !== '' ) ) {
			$post_title = $post->name;
		} else {
			$post_title = join( ' ', array_filter( [ $post->name_first ?? '', $post->name_last ?? '' ] ) );
		}

		$post_title = trim( $post_title );

		if ( $post_title === '' ) {
			return;
		}

		$post_parent = ! empty( $post->post_parent ) ? $post->post_parent : 0;
		$post_name   = wp_unique_post_slug(
			sanitize_title( $post_title ),
			$post->ID,
			'publish',
			$post->post_type,
			$post_parent
		);

		$postarr               = (array) $post;
		$postarr['post_title'] = $post_title;
		$postarr['post_name']  = $post_name;
		if ( $post->name === '' ) {
			$postarr['meta_input']         = [];
			$postarr['meta_input']['name'] = $post_title;
		}

		wp_update_post( $postarr );
	}

	/**
	 * Formats address for output in a block.
	 * 
	 * Creates an array of the address from profile data, filters that array to remove empty entries then joins them in a string seperated by a ",".
	 * Profile Data can contain multiple addresses with keys in the format {$type}_office_{$part}. you can get different types by modifying the 
	 *
	 * @param array  $profile_data  An array of slashed, sanitized, and processed post data.
	 * @param string $type          The Type key for getting the address type from the post data.
	 * @param string $seperator     String used to seperate the address items returned in the output string.
	 * @return string
	 */
	public static function formatAddress( array $profile_data, string $type = 'main', string $seperator = ',' ): null|string {

		// BUild an arry of address items that we can connect with a join(", ") to get nice formatting.
		$address   = [];
		$address[] = ( $profile_data[ $type . '_office_address' ][0] ?? null );
		$address[] = ( $profile_data[ $type . '_office_city' ][0] ?? null );
		$address[] = ( $profile_data[ $type . '_office_county' ][0] ?? null );
		$address[] = ( $profile_data[ $type . '_office_state' ][0] ?? null );
		$address[] = ( $profile_data[ $type . '_office_zip' ][0] ?? null );

		$phone = $profile_data[ $type . '_phone' ][0] ?? null;

		if (
			( $phone ) && 
			( '' !== $phone )
		) {
			$address[] = ( '(' . $phone . ')' );
		}
	
		$address = array_filter(
			$address,
			function ( $line ) {
				return (
				( '' !== $line ) 
				);
			}
		); 

		// add a space after the seperator.
		$seperator = $seperator . ' ';
		return ( empty( $address ) ? null : join( $seperator, $address ) );
	}

	public static function age_from_epoc( string|int $dob ): string {
		
		if ( $dob === '' ) {
			return '';
		}

		if ( is_int( $dob ) ) {
			$dob = ( $dob / 1000 );
		}
		
		// attempt to convert a string to a date
		if ( is_string( $dob ) ) {
			$dob = strtotime( $dob );
		}

		if ( ! $dob ) {
			return '';
		}

		$today         = new \DateTime();
		$date_of_birth = new \DateTime();
		$date_of_birth->setTimestamp( ( $dob ) ); //js timestime is milliseconds, we just want seconds since epoc
		
		$diff = $date_of_birth->diff( $today );
		return sprintf( '%d years old', $diff->y );
	}

	/**
	 * Fetch profile data into an array. Used for block.
	 *
	 * @param int $profile_id    id of profile to get.
	 *
	 * @return array Profile data
	 */
	public static function get_data( string|int $profile_id ): array|null {
		$profile_id = absint( $profile_id );
		if ( ! $profile_id ) {
			return null;
		}

		$profile_raw_data = get_post( $profile_id );
		if ( ! $profile_raw_data ) {
			return null;
		}


		$profile_raw_meta_data = get_post_meta( $profile_id );
		if ( ! $profile_raw_meta_data ) {
			return null;
		}

		$term_objects = wp_get_post_terms(
			$profile_id,
			[ 
				\Govpack\Tax\Party::TAX_SLUG, 
				\Govpack\Tax\State::TAX_SLUG,
				\Govpack\Tax\LegislativeBody::TAX_SLUG,
				\Govpack\Tax\OfficeHolderTitle::TAX_SLUG,
				\Govpack\Tax\OfficeHolderStatus::TAX_SLUG,
			] 
		);

		
		$term_data = array_reduce(
			is_wp_error( $term_objects ) ? [] : $term_objects,
			function ( $carry, $item ) {
				$carry[ $item->taxonomy ] = $item->name;
				return $carry;
			},
			[]
		);

		$profile_data = [ // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
			'id'               => $profile_id,
			
			'title'            => $profile_raw_meta_data['title'][0] ?? '',
			'phone'            => $profile_raw_meta_data['main_phone'][0] ?? '',
			'twitter'          => $profile_raw_meta_data['twitter'][0] ?? '',
			'instagram'        => $profile_raw_meta_data['instagram'][0] ?? '',
			'linkedin'         => $profile_raw_meta_data['linkedin'][0] ?? '',
			'email'            => $profile_raw_meta_data['email'][0] ?? '',
			'facebook'         => $profile_raw_meta_data['facebook'][0] ?? '',
			'website'          => $profile_raw_meta_data['leg_url'][0] ?? '',
			'biography'        => $profile_raw_meta_data['biography'][0] ?? '',
			'district'         => $profile_raw_meta_data['district'][0] ?? '',
			'endorsements'     => $profile_raw_meta_data['endorsements'][0] ?? '',
			'age'              => self::age_from_epoc( $profile_raw_meta_data['date_of_birth'][0] ?? false ),

			'party'            => $term_data[ \Govpack\Tax\Party::TAX_SLUG ] ?? '',
			'state'            => $term_data[ \Govpack\Tax\State::TAX_SLUG ] ?? '',
			'legislative_body' => $term_data[ \Govpack\Tax\LegislativeBody::TAX_SLUG ] ?? '',
			'position'         => $term_data[ \Govpack\Tax\OfficeHolderTitle::TAX_SLUG ] ?? '',
			'status'           => $term_data[ \Govpack\Tax\OfficeHolderStatus::TAX_SLUG ] ?? '',

			'bio'              => get_the_excerpt( $profile_raw_data ) ?? '',
			'link'             => get_permalink( $profile_id ),
			'websites'         => [
				'campaign'    => $profile_raw_meta_data['campaign_url'][0] ?? '',
				'legislative' => $profile_raw_meta_data['leg_url'][0] ?? '',
			],
			'social'           => [
				'official' => [
					'label'    => 'Official',
					'services' => [
						'x'         => $profile_raw_meta_data['x_official'][0] ?? $profile_raw_meta_data['twitter_official'][0] ?? null,
						'facebook'  => $profile_raw_meta_data['facebook_official'][0] ?? null,
						'twitter'   => $profile_raw_meta_data['twitter_official'][0] ?? null,
						'instagram' => $profile_raw_meta_data['instagram_official'][0] ?? null,
						'youtube'   => $profile_raw_meta_data['youtube_official'][0] ?? null,
					],
				], 
				'personal' => [
					'label'    => 'Personal',
					'services' => [
						'x'         => $profile_raw_meta_data['x_personal'][0] ?? $profile_raw_meta_data['twitter_personal'][0] ?? null,
						'facebook'  => $profile_raw_meta_data['facebook_personal'][0] ?? null,
						'twitter'   => $profile_raw_meta_data['twitter_personal'][0] ?? null,
						'instagram' => $profile_raw_meta_data['instagram_personal'][0] ?? null,
						'youtube'   => $profile_raw_meta_data['youtube_personal'][0] ?? null,
					],
				], 
				'campaign' => [
					'label'    => 'Campaign',
					'services' => [
						'x'         => $profile_raw_meta_data['x_campaign'][0] ?? $profile_raw_meta_data['twitter_campaign'][0] ?? null,
						'facebook'  => $profile_raw_meta_data['facebook_campaign'][0] ?? null,
						'twitter'   => $profile_raw_meta_data['twitter_campaign'][0] ?? null,
						'instagram' => $profile_raw_meta_data['instagram_campaign'][0] ?? null,
						'youtube'   => $profile_raw_meta_data['youtube_campaign'][0] ?? null,
					],
				],
			],
			'contact'          => [
				'official' => [
					'label'    => 'Official',
					'services' => [ 
						'email'   => $profile_raw_meta_data['email_official'][0] ?? null,
						'phone'   => $profile_raw_meta_data['phone_official'][0] ?? null,
						'fax'     => $profile_raw_meta_data['fax_official'][0] ?? null,
						'address' => $profile_raw_meta_data['address_official'][0] ?? null,
						'website' => $profile_raw_meta_data['website_official'][0] ?? null,
					],
				],
				'district' => [
					'label'    => 'District',
					'services' => [ 
						'email'   => $profile_raw_meta_data['email_district'][0] ?? null,
						'phone'   => $profile_raw_meta_data['phone_district'][0] ?? null,
						'fax'     => $profile_raw_meta_data['fax_district'][0] ?? null,
						'address' => $profile_raw_meta_data['address_district'][0] ?? null,
						'website' => $profile_raw_meta_data['website_district'][0] ?? null,
					],
				],
				'campaign' => [
					'label'    => 'Campaign',
					'services' => [ 
						'email'   => $profile_raw_meta_data['email_campaign'][0] ?? null,
						'phone'   => $profile_raw_meta_data['phone_campaign'][0] ?? null,
						'fax'     => $profile_raw_meta_data['fax_campaign'][0] ?? null,
						'address' => $profile_raw_meta_data['address_campaign'][0] ?? null,
						'website' => $profile_raw_meta_data['website_campaign'][0] ?? null,
					],
				],
				'other'    => [
					'label'    => 'Other',
					'services' => [ 
						'website_other'    => [
							'label' => 'Website (Personal)',
							'value' => $profile_raw_meta_data['website_personal'][0] ?? null,
						],
						'email_other'      => [
							'label' => 'Email (Other)',
							'value' => $profile_raw_meta_data['email_other'][0] ?? null,
						],
						'rss'              => [
							'label' => 'RSS Feed URL',
							'value' => trim( $profile_raw_meta_data['rss'][0] ) ?? null,
						], 
						'contact_form_url' => [
							'label' => 'Contact Form URL',
							'value' => $profile_raw_meta_data['contact_form_url'][0] ?? null,
						],
					],
				],
				
			],
			'links'            => self::generate_links_for_profile( $profile_id ),
			'name'             => self::generate_name_for_profile( $profile_id ),
		];

		
		$profile_data['hasWebsites'] = ( $profile_data['websites']['campaign'] ?? $profile_data['websites']['legislative'] ?? false );

		
		// array filter via map to remove the inner empty values, the directly to remove the outer
		$profile_data['social'] = array_map( 'array_filter', $profile_data['social'] );
		$profile_data['social'] = array_filter( $profile_data['social'] );

	
		// force all social media links to have a protocal in the url
		$profile_data['social'] = array_map(
			function ( $social_set ) {
				
				
				$social_set['services'] = array_map(
					function ( $service ) {
						
						if ( ! $service ) {
							return false;
						}

						if ( gp_is_url_valid( $service ) ) {
								return $service;
						}

						if ( str_starts_with( $service, 'http://' ) || str_starts_with( $service, 'https://' ) ) {
							return $service;
						}

						return set_url_scheme( '//' . $service, 'https' );
					},
					$social_set['services'] 
				);

				$social_set['services'] = \array_filter( $social_set['services'] );

				return $social_set;
			},
			$profile_data['social']
		);


		
		$profile_data['hasSocial'] = ! ( empty( $profile_data['social']['official'] ) && empty( $profile_data['social']['personal'] ) && empty( $profile_data['social']['campaign'] ) ?? false );
		
		return apply_filters( 'govpack_profile_data', $profile_data );
	}

	public static function generate_name_for_profile( string|int $profile_id ): array {

		$name_parts = [
			'prefix' => get_post_meta( $profile_id, 'name_prefix', true ) ?? null,
			'first'  => get_post_meta( $profile_id, 'name_first', true ) ?? null,
			'middle' => get_post_meta( $profile_id, 'name_middle', true ) ?? null,
			'last'   => get_post_meta( $profile_id, 'name_last', true ) ?? null,
			'suffix' => get_post_meta( $profile_id, 'name_suffix', true ) ?? null,
		];
		
		$provided_name = get_post_meta( $profile_id, 'name', true ) ?? null;
		$provided_name = ( $provided_name === '' ? null : $provided_name );
		
		$generated_name = trim( implode( ' ', $name_parts ) );
		$generated_name = ( $generated_name === '' ? null : $generated_name );

		$name_data = [
			'name'  => $provided_name ?? \get_the_title( $profile_id ) ?? $generated_name ?? null,
			'full'  => $generated_name ?? \get_the_title( $profile_id ),
			'first' => $name_parts['first'] ?? null,
			'last'  => $name_parts['last'] ?? null,
		];

		return $name_data;
	}

	public static function generate_links_for_profile( string|int $profile_id ): array {
		$pl = new ProfileLinks( $profile_id );
		$pl->generate();
		return $pl->to_array();
	}

	public static function generate_link_services(): array {
		$services = new ProfileLinkServices();
		return $services->to_array();
	}


	/**
	 * Get Default Profile Content.
	 * 
	 * The default block string for a profile.  Usually injected into the profile import before any content 
	 */
	public static function default_profile_content(): string {
		return sprintf( '<!-- wp:%s /-->', self::get_default_profile_block() );
	}

	public static function remove_custom_fields_metabox() {
		remove_meta_box( 'postcustom', false, 'normal' );
	}

	public static function modify_meta_boxes( $post_type, $post ) {
		self::remove_custom_fields_metabox();
	}
}

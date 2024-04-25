<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\CPT;

use Govpack\Core\Capabilities;
use \Govpack\Helpers;

/**
 * Register and handle the "Profile" Custom Post Type
 */
class Profile extends \Govpack\Core\Abstracts\Post_Type {

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
	 * Post Type slug. Used when registering and referencing
	 */
	const TEMPLATE_NAME = 'single-' . self::CPT_SLUG . '.php';

	/**
	 * Shortcode.
	 */
	const SHORTCODE = 'govpack';

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		parent::hooks();
		\add_action( 'init', [ __CLASS__, 'register_post_meta' ] );
		\add_filter( 'wp_insert_post_data', [ __CLASS__, 'set_profile_title' ], 10, 3 );
		\add_action( 'edit_form_after_editor', [ __CLASS__, 'show_profile_title' ] );
		\add_filter( 'manage_edit-' . self::CPT_SLUG . '_sortable_columns', [ __CLASS__, 'sortable_columns' ] );
		\add_filter( 'manage_' . self::CPT_SLUG . '_posts_columns', [ __CLASS__, 'custom_columns' ] );
		\add_filter( 'manage_' . self::CPT_SLUG . '_posts_custom_column', [ __CLASS__, 'custom_columns_content' ], 10, 2 );
		\add_filter( 'manage_taxonomies_for_' . self::CPT_SLUG . '_columns', [ __CLASS__, 'mod_taxonomy_columns' ], 10, 2 );
		\add_filter( 'default_hidden_columns', [ __CLASS__, 'hidden_columns' ], 10, 2 );
		\add_action( 'restrict_manage_posts', [ __CLASS__, 'post_table_filters' ], 10, 2 );

		add_filter( 'disable_months_dropdown', [ __CLASS__, 'disable_months_dropdown' ], 10, 2 );
		//add_filter( 'wpseo_enable_editor_features_' . self::CPT_SLUG, '__return_false' );

		
		add_filter( 'bulk_actions-edit-' . self::CPT_SLUG, [ __CLASS__, 'filter_bulk_actions' ], 10 );
		add_filter( 'handle_bulk_actions-edit-' . self::CPT_SLUG, [ __CLASS__, 'handle_bulk_publish' ], 10, 3 );

	}

	/**
	 * Publishes Posts with ID passed. Handle the bulk actions from List Table
	 * 
	 * @param string $sendback URL to redirect to.
	 * @param string $doaction Bulk action we're doing.
	 * @param array  $post_ids Array fof post IDs to publish.
	 */
	public static function handle_bulk_publish( $sendback, $doaction, $post_ids ) {

		$published = 0;

		foreach ( (array) $post_ids as $post_id ) {
			
			if ( ! current_user_can( 'publish_posts', $post_id ) ) {
				wp_die( __( 'Sorry, you are not allowed to publish this item.' ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			wp_update_post(
				[
					'ID'          => $post_id,
					'post_status' => 'publish',
				]
			);

			$published++;
		
		}
		return add_query_arg( 'published', $published, $sendback );
	}

	/**
	 * Add Publish to the bulk actions
	 * 
	 * @param array $actions Bulk actions to filter.
	 */
	public static function filter_bulk_actions( $actions ) {
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
	public static function disable_months_dropdown( $disable, $post_type ) {

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
	public static function hidden_columns( $hidden, $screen ) {

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
	public static function register_post_type() {

	
		$permalinks = gp_get_permalink_structure();
		
		$permalink_structure = (isset($permalinks['profile_base']) ? $permalinks['profile_base'] : "profile" );
		

		return register_post_type( // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
			self::CPT_SLUG,
			\apply_filters("govpack_register_post_type_profile", [
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
				'has_archive'  => true,
				'public'       => true,
				'show_in_rest' => true,
				'show_ui'      => true,
				'show_in_menu' => 'govpack',
				'supports'     => [ 'revisions', 'thumbnail', 'editor', 'custom-fields', 'title', 'excerpt', 'author'],
				'taxonomies'   => [ 'post_tag' ],
				'as_taxonomy'  => \Govpack\Core\Tax\Profile::TAX_SLUG,
				'menu_icon'    => 'dashicons-groups',
				'rewrite'      => [
					'slug'       => apply_filters( 'govpack_profile_filter_slug', $permalink_structure ),
					'with_front' => false,
				],
				'template'     => [
					[ 'govpack/profile-self' ],
				],
			])
		);
	}

	/**
	 * Returns an array of keys for the data model and how to handle them in import
	 *
	 * @return array
	 */
	public static function get_import_model() {

		$model = [];

		foreach ( self::get_meta_keys() as $key ) {
			$model[ $key ] = [
				'type' => 'meta',
				'key'  => $key,
			];
		}

		$taxonomies = [
			'status' => 'govpack_officeholder_status',
			'state'  => 'govpack_state',
			'office' => 'govpack_legislative_body',
			'party'  => 'govpack_party',
			'title'  => 'govpack_officeholder_title',
		];

		foreach ( $taxonomies as $key => $taxonomy ) {
			$model[ $key ] = [
				'type'     => 'taxonomy',
				'key'      => $key,
				'taxonomy' => $taxonomy,
			];
		}
		
		$post_fields = [
			'bio'          => 'post_content',
			'post_id'      => 'ID',
			'post_status'  => 'post_status',
			'thumbnail_id' => '_thumbnail_id',
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
	public static function get_export_model() {

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
	public static function get_meta_keys() {

		$meta_keys = [
			// About Panel.
			'name',
			'name_prefix',
			'name_first',
			'name_middle',
			'name_last',
			'name_suffix',
			'nickname',
			'occupation',
			'education',
			'gender',
			'race',
			'ethnicity',
			'date_of_birth',
			'date_of_death',
			'district',

			// office panel.
			'contact_form_url',
			'date_assumed_office',
			'appointed_by',
			'appointed_date',
			'confirmed_date',
			'term_end_date',
			'congress_year',

			// communications panel.
			'email_official',
			'email_campaign',
			'email_other',
			'email_district',
			'email_legislative',
			'email_capitol',
			
			'address_capitol',
			'address_district',
			'address_campaign',

			'phone_capitol',
			'phone_district',
			'phone_campaign',

			'fax_capitol',
			'fax_district',
			'fax_campaign',

			'website_personal',
			'website_campaign',
			'website_district',
			'website_capitol',
			'rss',


			'linkedin',
			'rumble',
			'gab',

			// meta and ID's panel.
			'govpack_id',
			'fec_id',
			'usio_id',
			'opensecrets_id',
			'district_ocd_id',
			'openstates_id',
			'thomas_id',
			'lis_id',
			'cspan_id',
			'govtrack_id',
			'votesmart_id',
			'balletpedia_id',
			'washington_post_id',
			'icpsr_id',
			'wikipedia_id',
			'google_entity_id',
			'committee_id',
		];

		// Social Panel.
		$groups = [ 'facebook', 'twitter', 'instagram', 'youtube' ];
		$keys   = [ 'official', 'campaign', 'personal' ];

		foreach ( $groups as $group ) {
			foreach ( $keys as $key ) {
				$slug        = sprintf( '%s_%s', $group, $key );
				$meta_keys[] = $slug;
			}
		}
		
		return apply_filters( 'govpack_profile_meta_keys', $meta_keys );
	}

	/**
	 * Register Meta data for the post in the REST API 
	 */
	public static function register_post_meta() {

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
	public static function register_meta( string $slug, array $args = [] ) {


		$args = array_merge(
			[
				'show_in_rest'  => true,
				'single'        => true,
				'type'          => 'string',
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			],
			$args
		);

		register_post_meta( self::CPT_SLUG, $slug, $args );
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
		$sortable_columns[ 'taxonomy-' . \Govpack\Core\Tax\State::TAX_SLUG ]              = 'State';
		$sortable_columns[ 'taxonomy-' . \Govpack\Core\Tax\Party::TAX_SLUG ]              = 'Party';
		$sortable_columns[ 'taxonomy-' . \Govpack\Core\Tax\LegislativeBody::TAX_SLUG ]    = 'Legislative Body';
		$sortable_columns[ 'taxonomy-' . \Govpack\Core\Tax\OfficeHolderStatus::TAX_SLUG ] = 'Office Holder Status';
		$sortable_columns[ 'taxonomy-' . \Govpack\Core\Tax\OfficeHolderTitle::TAX_SLUG ]  = 'Office Holder Title';
	
		return $sortable_columns;
	}

	/**
	 * Add The Pfofile Photo to the post Table.
	 *
	 * @param array $columns An array of columns.
	 */
	public static function custom_columns( $columns ) {
		

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
	public static function post_table_filters( $post_type, $which ) {
		
		self::taxonomy_dropdown( \Govpack\Core\Tax\LegislativeBody::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Core\Tax\State::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Core\Tax\Party::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Core\Tax\OfficeHolderStatus::TAX_SLUG, $post_type );
		self::taxonomy_dropdown( \Govpack\Core\Tax\OfficeHolderTitle::TAX_SLUG, $post_type );
		
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
	public static function taxonomy_dropdown( $taxonomy, $post_type ) {

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
	 * Modify Taxonomy Columns on Profile Post List
	 *
	 * @param array $columns An array of columns.
	 */
	public static function mod_taxonomy_columns( $columns ) {

		unset( $columns['govpack_profile_tax'] );
		unset( $columns['govpack_issue_tax'] );
		return $columns;

	}

	/**
	 * Add The Pfofile Photo to the post Table.
	 *
	 * @param string $column_key the key of the column used in WP_List_Table.
	 * @param int    $post_id id of the post being displayed in the row.
	 */
	public static function custom_columns_content( $column_key, $post_id ) {

		
		
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
	public static function formatAddress( $profile_data, $type = 'main', $seperator = ',' ) {

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
			function( $line ) {
				return (
				( '' !== $line ) 
				);
			}
		); 

		// add a space after the seperator.
		$seperator = $seperator . ' ';
		return ( empty( $address ) ? null : join( $seperator, $address ) );
	}

	static function age_from_epoc($dob){
		
		if($dob === ""){
			return "";
		}

		$today = new \DateTime();
		$dateOfBirth = new \DateTime();
		$dateOfBirth->setTimestamp(($dob / 1000)); //js timestime is milliseconds, we just want seconds since epoc
		$diff = $dateOfBirth->diff($today);
		return sprintf("%d Years", $diff->y);
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

		$profile_raw_data = get_post( $profile_id );
		if ( ! $profile_raw_data ) {
			return;
		}


		$profile_raw_meta_data = get_post_meta( $profile_id );
		if ( ! $profile_raw_meta_data ) {
			return;
		}

		$term_objects = wp_get_post_terms(
			$profile_id,
			[ 
				\Govpack\Core\Tax\Party::TAX_SLUG, 
				\Govpack\Core\Tax\State::TAX_SLUG,
				\Govpack\Core\Tax\LegislativeBody::TAX_SLUG,
				\Govpack\Core\Tax\OfficeHolderTitle::TAX_SLUG,
				\Govpack\Core\Tax\OfficeHolderStatus::TAX_SLUG,
			] 
		);
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
			'age'              => self::age_from_epoc($profile_raw_meta_data['date_of_birth'][0] ?? false),

			'party'            => $term_data[ \Govpack\Core\Tax\Party::TAX_SLUG ] ?? '',
			'state'            => $term_data[ \Govpack\Core\Tax\State::TAX_SLUG ] ?? '',
			'legislative_body' => $term_data[ \Govpack\Core\Tax\LegislativeBody::TAX_SLUG ] ?? '',
			'position'         => $term_data[ \Govpack\Core\Tax\OfficeHolderTitle::TAX_SLUG ] ?? '',
			'status'           => $term_data[ \Govpack\Core\Tax\OfficeHolderStatus::TAX_SLUG ] ?? '',
			'name'             => $profile_raw_data->post_title ?? '',
			'bio'              => get_the_excerpt( $profile_raw_data ) ?? '',
			'link'             => get_permalink( $profile_id ),
			'websites'         => [
				'campaign'    => $profile_raw_meta_data['campaign_url'][0] ?? '',
				'legislative' => $profile_raw_meta_data['leg_url'][0] ?? '',
			],
			'social'           => [
				'official' => [
					'facebook'  => $profile_raw_meta_data['facebook_official'][0] ?? null,
					'twitter'   => $profile_raw_meta_data['twitter_official'][0] ?? null,
					'instagram' => $profile_raw_meta_data['instagram_official'][0] ?? null,
					'youtube'   => $profile_raw_meta_data['youtube_official'][0] ?? null,
				], 
				'personal' => [
					'facebook'  => $profile_raw_meta_data['facebook_personal'][0] ?? null,
					'twitter'   => $profile_raw_meta_data['twitter_personal'][0] ?? null,
					'instagram' => $profile_raw_meta_data['instagram_personal'][0] ?? null,
					'youtube'   => $profile_raw_meta_data['youtube_personal'][0] ?? null,
				], 
				'campaign' => [
					'facebook'  => $profile_raw_meta_data['facebook_campaign'][0] ?? null,
					'twitter'   => $profile_raw_meta_data['twitter_campaign'][0] ?? null,
					'instagram' => $profile_raw_meta_data['instagram_campaign'][0] ?? null,
					'youtube'   => $profile_raw_meta_data['youtube_campaign'][0] ?? null,
				],
			],
			'comms'            => [
				'capitol'  => [
					'email'   => $profile_raw_meta_data['email_capitol'][0] ?? null,
					'phone'   => $profile_raw_meta_data['phone_capitol'][0] ?? null,
					'fax'     => $profile_raw_meta_data['fax_capitol'][0] ?? null,
					'address' => $profile_raw_meta_data['address_capitol'][0] ?? null,
					'website' => $profile_raw_meta_data['website_capitol'][0] ?? null,
				],
				'district' => [
					'email'   => $profile_raw_meta_data['email_district'][0] ?? null,
					'phone'   => $profile_raw_meta_data['phone_district'][0] ?? null,
					'fax'     => $profile_raw_meta_data['fax_district'][0] ?? null,
					'address' => $profile_raw_meta_data['address_district'][0] ?? null,
					'website' => $profile_raw_meta_data['website_district'][0] ?? null,
				],
				'campaign' => [
					'email'   => $profile_raw_meta_data['email_campaign'][0] ?? null,
					'phone'   => $profile_raw_meta_data['phone_campaign'][0] ?? null,
					'fax'     => $profile_raw_meta_data['fax_campaign'][0] ?? null,
					'address' => $profile_raw_meta_data['address_campaign'][0] ?? null,
					'website' => $profile_raw_meta_data['website_campaign'][0] ?? null,
				],
				'other'    => [
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
						'value' => $profile_raw_meta_data['rss'][0] ?? null,
					], 
					'contact_form_url' => [
						'label' => 'Contact Form URL',
						'value' => $profile_raw_meta_data['contact_form_url'][0] ?? null,
					],
				],
			],
			'name'             => [
				'name'  => $profile_raw_meta_data['name'][0] ?? null,
				'full'  => implode(
					' ',
					[
					$profile_raw_meta_data['name_prefix'][0] ?? null,
					$profile_raw_meta_data['name_first'][0] ?? null,
					$profile_raw_meta_data['name_middle'][0] ?? null,
					$profile_raw_meta_data['name_last'][0] ?? null,
					$profile_raw_meta_data['name_suffix'][0] ?? null,
					]
				),
				'first' => $profile_raw_meta_data['name_first'][0] ?? null ?? null,
				'last'  => $profile_raw_meta_data['name_last'][0] ?? null ?? null,
				],
		];

		
		
		$profile_data['hasWebsites'] = ( $profile_data['websites']['campaign'] ?? $profile_data['websites']['legislative'] ?? false );
		$profile_data['social']      = array_map( 'array_filter', $profile_data['social'] );
		$profile_data['social']      = array_filter( $profile_data['social'] );
		$profile_data['hasSocial']   = ! ( empty( $profile_data['social']['official'] ) && empty( $profile_data['social']['personal'] ) && empty( $profile_data['social']['campaign'] ) ?? false );
			
		return $profile_data;
	}



	/**
	 * Shortcode handler for [govpack].
	 *
	 * @param array  $atts    Array of shortcode attributes.
	 * @param string $content Post content.
	 * @return string HTML for recipe shortcode.
	 */
	public static function shortcode_handler_meta( $atts, $content = null ) {

		global $post;

		if ( self::CPT_SLUG !== $post->post_type ) {
			return;
		}
	  
		$profile_data = self::get_data( $post->ID );
		if ( ! $profile_data ) {
			return;
		}

		ob_start();
		require_once GOVPACK_PLUGIN_FILE . 'template-parts/profile-self.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Get Default Profile Content.
	 * 
	 * The default block string for a profile.  Usually injected into the profile import before any content 
	 */
	public static function default_profile_content() {
		return '<!-- wp:govpack/profile-self {"showName":true} /-->';
	}
}



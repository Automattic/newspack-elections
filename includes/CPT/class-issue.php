<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack\CPT;

use \Newspack\Govpack\Helpers;

/**
 * Register and handle the "Issue" Custom Post Type
 */
class Issue {

	/**
	 * Valid issue formats.
	 *
	 * @var array
	 */
	public static $issue_formats = [ 'full', 'mini', 'wiki' ];

	/**
	 * Default issue format.
	 *
	 * @var string
	 */
	public static $default_issue_format = 'full';

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var Newspack\Govpack\CPT\Issue The single instance of the class
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
	 * Post Type slug. Used when registering and referencing
	 */
	const CPT_SLUG = 'govpack_issues';

	/**
	 * Shortcode.
	 */
	const SHORTCODE = 'govpack_issue';

	/**
	 * Inits the class and registeres the hooks call
	 *
	 * @return self
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ __class__, 'hooks' ], 11, 1 );
	}

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		add_action( 'init', [ __CLASS__, 'register_post_type' ] );
		add_action( 'cmb2_init', [ __CLASS__, 'add_issue_boxes' ] );
		add_filter( 'wp_insert_post_data', [ __CLASS__, 'set_issue_title' ], 10, 3 );
		add_action( 'edit_form_after_editor', [ __CLASS__, 'show_issue_title' ] );
		add_filter( 'manage_edit-' . self::CPT_SLUG . '_sortable_columns', [ __CLASS__, 'sortable_columns' ] );
		add_filter( 'manage_' . self::CPT_SLUG . '_posts_columns', [ __CLASS__, 'manage_columns' ] );
		add_shortcode( self::SHORTCODE, [ __CLASS__, 'shortcode_handler' ] );
		add_filter( 'body_class', [ __CLASS__, 'filter_body_class' ] );
		add_action( 'add_meta_boxes', [ __CLASS__, 'remove_yoast_metabox' ], 11 );
	}

	/**
	 * Register the Issues post type
	 *
	 * @return object|WP_Error
	 */
	public static function register_post_type() {
		return register_post_type( // phpcs:ignore WordPress.NamingConventions.ValidPostTypeSlug.NotStringLiteral
			self::CPT_SLUG,
			[
				'labels'       => [
					'name'               => _x( 'Issues', 'post type general name', 'govpack' ),
					'singular_name'      => _x( 'Issue', 'post type singular name', 'govpack' ),
					'menu_name'          => _x( 'Issues', 'admin menu', 'govpack' ),
					'name_admin_bar'     => _x( 'Issue', 'add new on admin bar', 'govpack' ),
					'add_new'            => _x( 'Add New', 'popup', 'govpack' ),
					'add_new_item'       => __( 'Add New Issue', 'govpack' ),
					'new_item'           => __( 'New Issue', 'govpack' ),
					'edit_item'          => __( 'Edit Issue', 'govpack' ),
					'view_item'          => __( 'View Issue', 'govpack' ),
					'all_items'          => __( 'Issues', 'govpack' ),
					'search_items'       => __( 'Search Issues', 'govpack' ),
					'not_found'          => __( 'No issues found.', 'govpack' ),
					'not_found_in_trash' => __( 'No issues found in Trash.', 'govpack' ),
				],
				'has_archive'  => false,
				'public'       => true,
				'show_in_rest' => true,
				'show_ui'      => true,
				'supports'     => [ 'revisions', 'thumbnail' ],
				'as_taxonomy'  => \Newspack\Govpack\Tax\Issue::TAX_SLUG,
				'menu_icon'    => 'dashicons-groups',
				'rewrite'      => [
					'slug'       => apply_filters( 'govpack_issue_filter_slug', 'issue' ),
					'with_front' => 'false',
				],
			]
		);
	}

	/**
	 * Print out the post title where the normal title field would be. This post type does not
	 * `supports` the title field; it is constructed from the issue data.
	 */
	public static function show_issue_title() {
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
		$sortable_columns[ 'taxonomy-' . \Newspack\Govpack\Tax\State::TAX_SLUG ]           = 'State';
		$sortable_columns[ 'taxonomy-' . \Newspack\Govpack\Tax\Party::TAX_SLUG ]           = 'Party';
		$sortable_columns[ 'taxonomy-' . \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG ] = 'Legislative Body';
		return $sortable_columns;
	}

	/**
	 * Remove tags column from issue admin screen.
	 *
	 * @param string[] $columns The column header labels keyed by column ID.
	 * @return array
	 */
	public static function manage_columns( $columns ) {
		unset( $columns['tags'] );
		return $columns;
	}

	/**
	 * Using CMB2, add custom fields to issue.
	 */
	public static function add_issue_boxes() {
		/**
		 * Name metabox.
		 */
		$cmb_name = new_cmb2_box(
			[
				'id'           => 'issue_id',
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
				'name' => __( 'Title', 'govpack' ),
				'id'   => 'title',
				'type' => 'text',
			]
		);

	}

	/**
	 * Set the post title based on the issue data (title);
	 *
	 * @param array $data                An array of slashed, sanitized, and processed post data.
	 * @param array $postarr             An array of sanitized (and slashed) but otherwise unmodified post data.
	 * @param array $unsanitized_postarr An array of slashed yet *unsanitized* and unprocessed post data as
	 *                                   originally passed to wp_insert_post().
	 * @return array
	 */
	public static function set_issue_title( $data, $postarr, $unsanitized_postarr = false ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$title = $postarr['title'] ?? '';
		if ( $title ) {
			$data['post_title'] = $title;
			$data['post_name']  = null;
		}
		return $data;
	}

	/**
	 * Fetch issue data into an array. Used for shortcode and block.
	 *
	 * @param int $issue_id    Array of shortcode attributes.
	 *
	 * @return array Issue data
	 */
	public static function get_data( $issue_id ) {
		$issue_id = absint( $issue_id );
		if ( ! $issue_id ) {
			return;
		}

		$issue_raw_data = get_post_meta( $issue_id );
		if ( ! $issue_raw_data ) {
			return;
		}

		$term_objects = wp_get_post_terms( $issue_id, [ \Newspack\Govpack\Tax\Party::TAX_SLUG, \Newspack\Govpack\Tax\State::TAX_SLUG, \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG ] );
		$term_data    = array_reduce(
			$term_objects,
			function( $carry, $item ) {
				$carry[ $item->taxonomy ] = $item->name;
				return $carry;
			},
			[]
		);

		$issue_data = [ // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
			'id'               => $issue_id,
			'title'            => $issue_raw_data['title'][0] ?? '',
			'phone'            => $issue_raw_data['main_phone'][0] ?? '',
			'twitter'          => $issue_raw_data['twitter'][0] ?? '',
			'instagram'        => $issue_raw_data['instagram'][0] ?? '',
			'email'            => $issue_raw_data['email'][0] ?? '',
			'facebook'         => $issue_raw_data['facebook'][0] ?? '',
			'website'          => $issue_raw_data['leg_url'][0] ?? '',
			'biography'        => $issue_raw_data['biography'][0] ?? '',
			'party'            => $term_data[ \Newspack\Govpack\Tax\Party::TAX_SLUG ] ?? '',
			'state'            => $term_data[ \Newspack\Govpack\Tax\State::TAX_SLUG ] ?? '',
			'legislative_body' => $term_data[ \Newspack\Govpack\Tax\LegislativeBody::TAX_SLUG ] ?? '',
		];

		return $issue_data;
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

		$issue_data = self::get_data( $atts['id'] );
		if ( ! $issue_data ) {
			return;
		}

		$atts = shortcode_atts(
			[
				'format'    => self::$default_issue_format,
				'className' => '',
			],
			$atts
		);

		if ( ! in_array( $atts['format'], self::$issue_formats, true ) ) {
			$atts['format'] = self::$default_issue_format;
		}

		$issue_data['format'] = $atts['format'];

		ob_start();
		require_once GOVPACK_PLUGIN_FILE . 'template-parts/profile.php'; // phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingCustomConstant
		$html = ob_get_clean();

		return $html;
	}

	/**
	 * Create an issue.
	 *
	 * @param array $data   Array of issue data.
	 *
	 * @return int|WP_Error The post ID on success. 0 or WP_Error on failure.
	 */
	public static function create( $data ) {
		$post_args = [
			'post_type'   => self::CPT_SLUG,
			'post_status' => 'publish',
			'tax_input'   => [],
		];

		$meta_keys = [
			'govpack_id',
			'title',
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
		$post_args = self::set_issue_title( $post_args, $data );

		// Insert the post and post metadata.
		$new_post = wp_insert_post( $post_args );
		if ( 0 === $new_post || is_wp_error( $new_post ) ) {
			return $new_post;
		}

		// Fetch the image.
		if ( ! empty( $data['image'] ) ) {
			if ( $data['image'] ) {
				$description = $data['title'];
				$image_id    = Helpers::upload_image( $data['image'], $new_post, $description );

				if ( is_wp_error( $image_id ) ) {
					if ( defined( 'WP_CLI' ) && WP_CLI ) {
						\WP_CLI::warning( "Failed to upload image [{$data['image']}] for issue $new_post." );
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
							\WP_CLI::success( "Added image for issue $new_post." );
						} else {
							\WP_CLI::warning( "Failed to set post thumnbnail for issue $new_post." );
						}
					}
				}
			}
		}

		// Insert the taxonomy separate. wp_insert_post() will not insert
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
	 * Add body classes depending on layout.
	 *
	 * @param array $classes CSS classes.
	 *
	 * @return array
	 */
	public static function filter_body_class( $classes ) {
		if ( is_singular( self::CPT_SLUG ) ) {
			$classes[] = 'archive';
			$classes[] = 'feature-latest';

			$key = array_search( 'single', $classes, true );
			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}
		}

		return $classes;
	}

	/**
	 * Fetch stories related to an issue.
	 *
	 * @param integer $issue_id Issue id.
	 *
	 * @return WP_Query
	 */
	public static function get_stories( $issue_id ) {
		$term_id = get_post_meta( $issue_id, 'term_id', true );
		$args    = [
			'tax_query' => [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				[
					'taxonomy' => \Newspack\Govpack\Tax\Issue::TAX_SLUG,
					'field'    => 'id',
					'terms'    => $term_id,
				],
			],
		];

		return \Newspack\Govpack\Helpers::get_cached_query( $args, 'posts_govpack_issues_' . $term_id );
	}

	/**
	 * Hide the Yoast metabox.
	 *
	 * @return void
	 */
	public static function remove_yoast_metabox() {
		remove_meta_box( 'wpseo_meta', self::CPT_SLUG, 'normal' );
	}
}

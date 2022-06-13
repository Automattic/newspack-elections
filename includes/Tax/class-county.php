<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Tax;

/**
 * Register and handle the "County" Taxonomy.
 */
class County extends \Govpack\Core\Abstracts\Taxonomy {

	/**
	 * Post Type slug. Used when registering and referencing
	 */
	const TAX_SLUG = 'govpack_county';

	/**
	 * URL slug. Also used for fixtures.
	 */
	const SLUG = 'county';

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {
		parent::hooks();
		add_action( self::TAX_SLUG . '_edit_form_fields', [ get_called_class(), 'edit_form_fields' ], 10, 2 );
		add_action( self::TAX_SLUG . '_add_form_fields', [ get_called_class(), 'add_form_fields' ] );
		add_action( 'created_' . self::TAX_SLUG, [ get_called_class(), 'save_form' ], 10, 2 );
		add_action( 'edited_' . self::TAX_SLUG, [ get_called_class(), 'save_form' ], 10, 2 );

		add_filter( 'manage_edit-' . self::TAX_SLUG . '_columns', [ get_called_class(), 'table_columns' ] );
		add_filter( 'manage_' . self::TAX_SLUG . '_custom_column', [ get_called_class(), 'table_content' ], 10, 3 );
		add_filter( 'manage_edit-' . self::TAX_SLUG . '_sortable_columns', [ get_called_class(), 'sortable_columns' ] );
	}

	/**
	 * Register this taxonomy for profiles.
	 */
	public static function register_taxonomy() {
		register_taxonomy(
			self::TAX_SLUG,
			self::get_taxonomy_post_types(),
			[
				'labels'            => [
					'name'                       => _x( 'Counties', 'Taxonomy General Name', 'govpack' ),
					'singular_name'              => _x( 'County', 'Taxonomy Singular Name', 'govpack' ),
					'menu_name'                  => __( 'Counties', 'govpack' ),
					'all_items'                  => __( 'All Counties', 'govpack' ),
					'parent_item'                => __( 'Parent County', 'govpack' ),
					'parent_item_colon'          => __( 'Parent County:', 'govpack' ),
					'new_item_name'              => __( 'New County Name', 'govpack' ),
					'add_new_item'               => __( 'Add New County', 'govpack' ),
					'edit_item'                  => __( 'Edit County', 'govpack' ),
					'update_item'                => __( 'Update County', 'govpack' ),
					'view_item'                  => __( 'View County', 'govpack' ),
					'separate_items_with_commas' => __( 'Separate counties with commas', 'govpack' ),
					'add_or_remove_items'        => __( 'Add or remove counties', 'govpack' ),
					'choose_from_most_used'      => __( 'Choose from the most used', 'govpack' ),
					'popular_items'              => __( 'Popular Counties', 'govpack' ),
					'search_items'               => __( 'Search Counties', 'govpack' ),
					'not_found'                  => __( 'Not Found', 'govpack' ),
					'no_terms'                   => __( 'No counties', 'govpack' ),
					'items_list'                 => __( 'Counties list', 'govpack' ),
					'items_list_navigation'      => __( 'Counties list navigation', 'govpack' ),
				],
				'public'            => true,
				'hierarchical'      => false,
				'rewrite'           => [
					'slug'         => self::SLUG,
					'with_front'   => false,
					'hierarchical' => false,
				],
				'meta_box_cb'       => false,
				'show_admin_column' => false,
				'show_in_rest'      => true,
				'show_ui'           => false,
			]
		);
	}

	/**
	 * Seed taxonomies with default data.
	 */
	public static function seed() {
		$file_path = GOVPACK_PLUGIN_FILE . 'assets/json/county.json';

		if ( ! file_exists( $file_path ) || 0 !== validate_file( $file_path ) ) {
			return;
		}

		$json = file_get_contents( $file_path ); // phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		$data = json_decode( $json, true );

		if ( json_last_error() !== JSON_ERROR_NONE ) {
			return;
		}

		$progress = 1;
		$count    = 0;
		foreach ( $data as $item ) {
			$name        = preg_replace( '/ (City and Borough|Borough|County|Parish|Municipio|Census Area)$/', '', $item['name'] );
			$county_name = sprintf( '%s (%s)', $name, $item['state'] );

			$term_exists_result = term_exists( $county_name, static::TAX_SLUG ); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.term_exists_term_exists

			if ( is_array( $term_exists_result ) ) {
				echo 'Term for ' . esc_html( $county_name ) . " exists; skipping.\n";
				continue;
			} else {
				if ( 0 === $progress % 5 ) {
					echo '.';
				}
				if ( 0 === $progress % 100 ) {
					echo "\n";
				}
			}
			$progress++;

			$new_term = wp_insert_term( $county_name, static::TAX_SLUG );

			if ( is_array( $new_term ) ) {
				echo 'Adding term meta for ' . esc_html( $county_name ) . ".\n";
				update_term_meta( $new_term['term_id'], 'state', $item['state'] );
				update_term_meta( $new_term['term_id'], 'fips', $item['fips'] );
				$count++;
			} else {
				echo 'Failed to add term for ' . esc_html( $county_name ) . ".\n";
			}
		}

		return $count;
	}

	/**
	 * Add state and fips columns to table. Rename 'Name' to 'County'.
	 *
	 * @param string[] $columns The column header labels keyed by column ID.
	 * @return array
	 */
	public static function table_columns( $columns ) {
		unset( $columns['description'] );
		unset( $columns['slug'] );
		unset( $columns['posts'] );
		$columns['name']  = 'County';
		$columns['state'] = 'State';
		$columns['fips']  = 'FIPS';

		return $columns;
	}

	/**
	 * Add State and FIPS content to table.
	 *
	 * @param string $string      Blank string.
	 * @param string $column_name Name of the column.
	 * @param int    $term_id     Term ID.
	 */
	public static function table_content( $string, $column_name, $term_id ) {
		if ( in_array( $column_name, [ 'state', 'fips' ], true ) ) {
			return get_term_meta( $term_id, $column_name, true );
		}
	}

	/**
	 * Denote State and FIPS columns as sortable.
	 *
	 * @param array $sortable_columns An array of sortable columns.
	 */
	public static function sortable_columns( $sortable_columns ) {
		$sortable_columns['state'] = 'State';
		$sortable_columns['fips']  = 'FIPS';
		return $sortable_columns;
	}

	/**
	 * Save State and FIPS to the database.
	 *
	 * @param int $term_id Term ID.
	 * @param int $tt_id   Term taxonomy ID.
	 */
	public static function save_form( $term_id, $tt_id ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		update_term_meta(
			$term_id,
			'fips',
			filter_input( INPUT_POST, 'fips', FILTER_SANITIZE_NUMBER_INT )
		);

		$states = \Govpack\Helpers::states();
		$state  = filter_input( INPUT_POST, 'state', FILTER_SANITIZE_STRING );
		if ( isset( $states[ $state ] ) ) {
			update_term_meta(
				$term_id,
				'state',
				$state
			);
		} else {
			delete_term_meta( $term_id, 'state' );
		}
	}

	/**
	 * Add state and FIPS fields to add form.
	 *
	 * @param string $taxonomy The taxonomy slug.
	 */
	public static function add_form_fields( $taxonomy ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$states = \Govpack\Helpers::states();
		?>
		<div class="form-field state-wrap">
			<label for="state">State</label>
			<select id="state" name="state" ria-required="true">>
				<option></option>
			<?php foreach ( $states as $code => $name ) : ?>
				<option value="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
			</select>
		</div>

		<div class="form-field fips-wrap">
			<label for="fips">FIPS Code</label>
			<input type='number' id='fips' size='5' maxlength='5' name='fips' aria-required="true" />
		</div>
		<?php
	}

	/**
	 * Add state and FIPS fields to edit form.
	 *
	 * @param WP_Term $term     Current taxonomy term object.
	 * @param string  $taxonomy Current taxonomy slug.
	 */
	public static function edit_form_fields( $term, $taxonomy ) { // phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable
		$states = Helpers::states();
		$state  = get_term_meta( $term->term_id, 'state', true );
		$fips   = get_term_meta( $term->term_id, 'fips', true );

		?>
		<tr class="form-field form-required term-state-wrap">
			<th scope="row"><label for="state">State</label></th>
			<td>
				<select id="state" name="state" ria-required="true">>
					<option></option>
				<?php foreach ( $states as $code => $name ) : ?>
					<option <?php selected( $code, $state ); ?> value="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
				</select>

			</td>
		</tr>

		<tr class="form-field form-required term-fips-wrap">
			<th scope="row"><label for="fips">FIPS Code</label></th>
			<td><input name="fips" id="fips" type="number" value="<?php echo esc_attr( $fips ); ?>" size="5" maxlength="5" aria-required="true"></td>
		</tr>
		<?php
	}
}

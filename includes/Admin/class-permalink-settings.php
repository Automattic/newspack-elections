<?php

namespace Govpack\Core\Admin;

class Permalink_Settings{

	private $permalinks;
	private $base_slug;

	private $option_name = "govpack_permalinks";

	public function __construct(){
		$this->add_permalink_settings_section();
		$this->handle_save();

		$this->base_slug = "guide";
		
	}

	public static function hooks(){
		new self();
	}

	public function defaults(){
		return [
			"profile_base" => ''
		];
	}

	public function get_permalinks(){
		return (array) get_option( $this->option_name, $this->defaults());
	}

	public function update_permalinks(){
		update_option( $this->option_name, $this->permalinks );
	}

	/**
	 * Makes a permalink suitable for saving in the options table
	 * 
	 * Other sanitisation methods may remove required '%s' and break the urls
	 * 
	 * Sourced from WooCommerce https://github.com/woocommerce/woocommerce/blob/c8202bc72943acfa2caa78be6337c23768b815cd/plugins/woocommerce/includes/wc-formatting-functions.php#L77
	 */
	private static function sanitize_permalink($permalink){
		global $wpdb;

		$permalink = $wpdb->strip_invalid_text_for_column( $wpdb->options, 'option_value', $permalink ?? '' );
	
		if ( is_wp_error( $permalink ) ) {
			$permalink = '';
		}
	
		$permalink = esc_url_raw( trim( $permalink ) );
		$permalink = str_replace( 'http://', '', $permalink );
		return untrailingslashit( $permalink );
	}

	/**
	 * Handles when the Permalink Form is Saved.
	 * 
	 * Attempts to quickly exit if we know we're not in wp-admin, not in a save action (i.e. $_POST is empty), or not in the permalink form
	 * Handles nonce verification for CSRF 
	 * Passes off to the actual save logic
	 */
	public function handle_save() {
		
		if ( ! is_admin() ) {
			return;
		}

		if(!isset($_POST, $_POST['govpack_profile_permalink'])){
			return;
		}
		
		if( ! wp_verify_nonce( wp_unslash( $_POST['govpack-permalinks-nonce'] ), 'govpack-permalinks' )) {
			return;
		}

		$this->save();
	}

	public function save() {

		
		$profile_base = isset( $_POST['govpack_profile_permalink'] ) ? wp_unslash( $_POST['govpack_profile_permalink'] )  : ''; // WPCS: input var ok, sanitization ok.

		if($profile_base === "custom"){
			if ( isset( $_POST['govpack_profile_permalink_structure'] ) ) { // WPCS: input var ok.
				
				// Taken from WC but with breaking down to understand.
				// Working form the Inner Most call outwards
				// wp_unslash remove backslashes that may have been added by earlier escaping
				// trim removes possible accidental whitespace, carriage return, newline, tab etc that could break urls
				// str_replace('#'... removes # characters that would cause everything after them to be treated as anchors
				// preg_replace( '#/+#', '/', '/' .... replaces every forward slash (or group of forward slashes) with a single '/'
				// eg / => /, // => /, /// => / . Note it adds a / at the start of the string to make sure there is always at least one /
				$profile_base = preg_replace( '#/+#', '/', '/' . str_replace( '#', '', trim( wp_unslash( $_POST['govpack_profile_permalink_structure'] ) ) ) ); // WPCS: input var ok, sanitization ok.
		
			} else {
				$profile_base = '/';
			}

		} elseif ( empty( $profile_base ) ) {
			$profile_base = 'profile';
		}

		$this->permalinks = $this->get_permalinks();
		$this->permalinks['profile_base'] = self::sanitize_permalink($profile_base);

		$this->update_permalinks();

	}

	

	public function add_permalink_settings_section() {

		$setting_section_id = "govpack-permalink";

		\add_settings_section( 
			$setting_section_id, 
			__( 'Govpack Permalinks', 'govpack' ), 
			array( $this, 'settings' ), 
			'permalink' 
		);
	}

	public function settings() {
		wp_nonce_field( 'govpack-permalinks', 'govpack-permalinks-nonce' );
		echo wp_kses_post( wpautop( sprintf( __( 'You may use a custom base for your Govpack Profile\'s URLs here. For example, using <code>candidate</code> would make your profile links like <code>%scandidate/jo-smith/</code>.', 'govpack' ), esc_url( home_url( '/' ) ) ) ) );
		
		$this->permalinks = $this->get_permalinks();
		
		$structures = array(
			0 => '',
			1 => '/' . trailingslashit( $this->base_slug ),
		);

		?>
		<table class="form-table">
		<tbody>
			<tr>
				<th>
					<label>
						<input name="govpack_profile_permalink" type="radio" value="<?php echo esc_attr( $structures[0] ); ?>" class="tog" <?php checked( $structures[0], $this->permalinks['profile_base'] ); ?> /> 
						<?php esc_html_e( 'Default', 'govpack' ); ?>
					</label>
				</th>
				<td>
					<code class="default-example">
						<?php echo esc_html( home_url() ); ?>/profile/jo-smith/
					</code>
				</td>
			</tr>

			<tr>
				<th>
					<label>
						<input name="govpack_profile_permalink" type="radio" value="<?php echo esc_attr( $structures[1] ); ?>" class="tog" <?php checked( $structures[1], $this->permalinks['profile_base'] ); ?> /> 
						<?php esc_html_e( 'Guide Base', 'govpack' ); ?>
					</label>
				</th>
				<td>
					<code class="default-example">
						<?php echo esc_html( home_url() ); ?>/guide/jo-smith/
					</code>
				</td>
			</tr>

			<tr>
				<th>
					<label>
						<input name="govpack_profile_permalink" type="radio" value="custom" class="tog" <?php checked( in_array( $this->permalinks['profile_base'], $structures, true ), false ); ?> /> 
						<?php esc_html_e( 'Custom Base', 'govpack' ); ?>
					</label>
				</th>
				<td>
					<input name="govpack_profile_permalink_structure" id="govpack_profile_permalink_structure" type="text" value="<?php echo esc_attr( $this->permalinks['profile_base'] ? trailingslashit( $this->permalinks['profile_base'] ) : '' ); ?>" class="regular-text code"> <br />
					<span class="description"><?php esc_html_e( 'Enter a custom base to use for GovPack Profiles. If not set the base of profile will be used.', 'govpack' ); ?></span>
				</td>
			</tr>
		</tbody>
	</table>

	<?php
	}
}
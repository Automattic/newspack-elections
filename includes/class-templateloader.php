<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core;

class TemplateLoader extends \Govpack_Vendor_Gamajo_Template_Loader {

		/**
		 * Prefix for filter names.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $filter_prefix = 'govpack';

		/**
		 * Directory name where custom templates for this plugin should be found in the theme.
		 *
		 * For example: 'your-plugin-templates'.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $theme_template_directory = 'govpack';

		/**
		 * Reference to the root directory path of this plugin.
		 *
		 * Can either be a defined constant, or a relative reference from where the subclass lives.
		 *
		 * e.g. YOUR_PLUGIN_TEMPLATE or plugin_dir_path( dirname( __FILE__ ) ); etc.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $plugin_directory = GOVPACK_PLUGIN_PATH;

	public function hooks() {
		add_filter( 'template_include', [ $this, 'template_include' ] );
	}

	public function template_include( $template ) {

		if ( is_embed() ) {
			return $template;
		}

		if ( wp_is_block_theme() ) {
			return $template;
		}

		if ( is_singular( \Govpack\Core\CPT\Profile::CPT_SLUG ) ) {
			return $this->locate_template( \Govpack\Core\CPT\Profile::TEMPLATE_NAME );
		}

		return $template;
	}

	private function do_render( $template, $attributes = [], $content = '', $block = null, $extra = null ) {
		ob_start();
		require $template; //phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		$html = ob_get_clean();
		return $html;
	}
	public function render_block( $slug, $attributes = [], $content = '', $block = null, $extra = null ) {
		$template = $this->get_template_part( $slug, null, false );
		return $this->do_render( $template, $attributes, $content, $block, $extra );
	}

	public function get_block_part( $slug, $name = null, $attributes = [], $content = '', $block = null, $extra = null ) {
		// Directly echoing HTML here, this comes from a template, so not escapable. Escaping shoulld be handled in the actual template.
		echo $this->do_render( $this->get_template_part( $slug, $name, false ), $attributes, $content, $block, $extra );//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

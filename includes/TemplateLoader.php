<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack;
use Govpack\Abstracts\Plugin;

class TemplateLoader extends \Govpack_Vendor_Gamajo_Template_Loader {

	use PluginAware;

		/**
		 * Prefix for filter names.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $filter_prefix;

		/**
		 * Directory name where custom templates for this plugin should be found in the theme.
		 *
		 * For example: 'your-plugin-templates'.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $theme_template_directory;

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
		protected $plugin_directory;


	public function __construct(Plugin $plugin) {

		$this->plugin($plugin);

		$this->filter_prefix = "govpack";
		$this->theme_template_directory = "govpack";
		$this->plugin_directory = $this->plugin->path();
	}

	public function hooks(): void {
		add_filter( 'template_include', [ $this, 'template_include' ] );
	}

	public function template_include( $template ) {

		if ( is_embed() ) {
			return $template;
		}

		if ( wp_is_block_theme() ) {
			return $template;
		}

		if ( ! is_singular( \Govpack\Profile\CPT::CPT_SLUG ) ) {
			return $template;
		}

		$located = $this->locate_template( \Govpack\Profile\CPT::TEMPLATE_NAME );

		// A theme copy under govpack/ is an explicit opt-in; it outranks both.
		if ( $located && 0 !== strpos( $located, $this->plugin_directory ) ) {
			return $located;
		}

		if ( $this->theme_handles_single_profile( $template ) ) {
			return $template;
		}

		return $located;
	}

	/**
	 * Whether to leave the profile for the theme to render.
	 *
	 * True for every classic theme with a single.php. The bundle renders outside
	 * the column themes constrain article text to, and replaces an editor-chosen
	 * page template.
	 *
	 * @param string $template Template the hierarchy resolved to.
	 * @return bool
	 */
	private function theme_handles_single_profile( $template ): bool {

		$handles = ! empty( $template ) && 'index.php' !== basename( $template );

		/**
		 * Filters whether the theme renders a single profile in place of the bundled template.
		 *
		 * @param bool   $handles  Whether the theme renders the profile.
		 * @param string $template Template the hierarchy resolved to.
		 */
		return (bool) apply_filters( 'govpack_theme_handles_single_profile', $handles, $template );
	}

	private function do_render( string $template, array $attributes = [], string $content = '', mixed $block = null, mixed $extra = null ): string {
		ob_start();
		/**
		 * @psalm-suppress UnresolvableInclude
		 */
		require $template; //phpcs:ignore WordPressVIPMinimum.Files.IncludingFile.UsingVariable
		$html = ob_get_clean();
		return $html;
	}

	public function render_block( string $slug, array $attributes = [], string $content = '', mixed $block = null, mixed $extra = null ): string {
		$template = $this->get_template_part( $slug, null, false );
		return $this->do_render( $template, $attributes, $content, $block, $extra );
	}

	public function get_block_part( string $slug, null|string $name = null, array $attributes = [], string $content = '', mixed $block = null, mixed $extra = null ): void {
		// Directly echoing HTML here, this comes from a template, so not escapable. Escaping shoulld be handled in the actual template.
		echo $this->do_render( $this->get_template_part( $slug, $name, false ), $attributes, $content, $block, $extra );//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

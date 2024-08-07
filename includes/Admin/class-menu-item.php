<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin;

use Exception;

/**
 * Create an Admin menu
 */
class Menu_Item extends Menu {

	/**
	 * Paren Slug, i.e, which menu this menu item is added to
	 * 
	 * @var parent_slug
	 */
	public $parent_slug;
   
	/**
	 * Set Parent Slug, so we know the menu to use
	 * 
	 * @param string $value value to set the parent slug.
	 */
	public function set_parent_slug( $value ) {
		return $this->set( 'parent_slug', $value );
	}

	/**
	 * Create the Menu Item to include in Menu.
	 */
	public function create() {


		try {
		   
			$this->check_required(
				[
					'page_title',
					'menu_title',
					'menu_slug',
					'function',
					'parent_slug',
				]
			);

			add_submenu_page( 
				$this->parent_slug,
				$this->page_title, 
				$this->menu_title, 
				$this->capability, //phpcs:ignore WordPress.WP.Capabilities.Undetermined
				$this->menu_slug,
				$this->function,
				$this->position 
			);
			
		
		} catch ( \Exception $e ) {
			\wp_die( \esc_html( $e->getMessage() ) );
		}
	}
}

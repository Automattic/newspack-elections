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
class Menu {
	/** 
	 * Title added to broser bag, eg <title> 
	 * 
	 * @var page_title 
	 */ 
	protected $page_title; 

	/**
	 * Title in the Menu
	 * 
	 * @var menu_title 
	 */
	protected $menu_title; 

	/**
	 * Unique ID for the menu in urls etc
	 * 
	 * @var menu_slug 
	 */
	protected $menu_slug;
	
	/** 
	 * Call back to render the page
	 * 
	 * @var function 
	 */ 
	protected $function; 

	/** 
	 * WP_capability required or you'll get an error
	 * 
	 * @var page_title 
	 */ 
	protected $capability = 'manage_options'; 
	
	/** 
	 * Where in the menu will our item be located
	 * 
	 * @var position 
	 */ 
	protected $position = 30; 

	/** 
	 *  URL for icon placement
	 * 
	 * @var icon_url 
	 */ 
	protected $icon_url = ''; 
	
	/** 
	 * Array of children to include in the menu
	 * 
	 *  @var items 
	 */  
	protected $items = []; 

	/** 
	 * Generic set and return so we can use a fluent style
	 * 
	 *  @param string $key string of object property to set.
	 *  @param string $value caluw to set the property.
	 */  
	public function set( $key, $value ) {
		$this->$key = $value;
		return $this;
	}

	/** 
	 * Set page title
	 * 
	 *  @param string $value value to set page title.
	 */ 
	public function set_page_title( $value ) {
		return $this->set( 'page_title', $value );
	}

		/** 
		 * Set page title
		 * 
		 *  @param string $value value to set page title.
		 */ 
	public function set_menu_title( $value ) {
		return $this->set( 'menu_title', $value );
	}
	/** 
	 * Set menu title
	 * 
	 *  @param string $value value to set menu title.
	 */ 
	public function set_menu_slug( $value ) {
		return $this->set( 'menu_slug', $value );
	}
	/** 
	 * Set capability
	 * 
	 *  @param string $value value to set capability.
	 */ 
	public function set_capability( $value ) {
		return $this->set( 'capability', $value );
	}
	/** 
	 * Set position to use in menu
	 * 
	 *  @param string $value value to set position to use in menu.
	 */ 
	public function set_position( $value ) {
		return $this->set( 'position', $value );
	}
	/** 
	 * Set icon url
	 * 
	 *  @param string $value value to set icon url.
	 */ 
	public function set_icon( $value ) {
		return $this->set( 'icon_url', $value );
	}
	/** 
	 * Set callback function
	 * 
	 *  @param string $value value to set callback function.
	 */ 
	public function set_callback( $value ) {
		return $this->set( 'function', $value );
	}
	/** 
	 * Add a submenu item 
	 * 
	 *  @param Menu_Item $item Submemnu Item.
	 */ 
	public function add_item( $item ) {

		$this->items[] = $item->set_parent_slug( $this->menu_slug );
	}
	
	/** 
	 * Checks that the required items are included.
	 * 
	 *  @param array $required Require properties.
	 *  @throws Exception Required property Missing.
	 *  @throws Exception Required property is an empty string.
	 */ 
	public function check_required( $required ) {
		
		foreach ( $required as $key ) {

			if ( null === $this->$key ) {
				throw new Exception( 'Required Menu Property ' . $key . ' is unset' );
			}

			if ( '' === $this->$key ) {
				throw new Exception( 'Required Menu Property ' . $key . ' is an empty string and much have a value' );
			}
		}
	}

	/** 
	 * Creates The menu and calls main WP menthods to do it.
	 */ 
	public function create() {
		try {
			

			$this->check_required(
				[
					'page_title',
					'menu_title',
					'menu_slug',
					'function',
				]
			);

			\add_action(
				'admin_menu',
				function() {

					\add_menu_page( 
						$this->page_title, 
						$this->menu_title, 
						$this->capability, 
						$this->menu_slug,
						$this->function,
						$this->icon_url,
						$this->position 
					);

					foreach ( $this->items as $item ) {
						$item->create();
					}
				},
				9 
			);
		
		} catch ( \Exception $e ) {
			\wp_die( \esc_html( $e->getMessage() ) );
		}
	}

	/**
	 * Add submenus for post types.
	 *
	 * @access private
	 * @since 3.1.0
	 */
	public static function add_taxonomy_submenus() {
		
		
		foreach ( \get_taxonomies( [ 'show_ui' => true ], 'objects' ) as $tax ) {
			
			if ( ! isset( $tax->show_in_which_menu ) ) {
				continue;
			}

		
			// Sub-menus only.
			if ( ! $tax->show_in_which_menu || "govpack" !== $tax->show_in_which_menu ) {
				continue;
			}


			\add_submenu_page( $tax->show_in_which_menu, $tax->labels->name, $tax->labels->name, $tax->cap->manage_terms, "edit-tags.php?taxonomy=$tax->name&post_type=govpack_profiles" );
		}
	}

}

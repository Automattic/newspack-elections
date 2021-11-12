<?php
/**
 * Govpack
 *
 * @package Newspack
 */

namespace Newspack\Govpack;

defined( 'ABSPATH' ) || exit;

define( 'GOVPACK_VERSION', '0.0.1' );

/**
 * Main Govpack Class.
 */
class Govpack {

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var Govpack\Govpack The single instance of the class
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
	 * Inits the class and registeres the hooks call
	 *
	 * @return self
	 */
	public function __construct() {
		add_action( 'after_setup_theme', [ __class__, 'hooks' ] );
		add_action( 'plugins_loaded', [ '\Newspack\Govpack\ActionScheduler\ActionScheduler', 'hooks' ], 0 );
	}

	/**
	 * WordPress Hooks
	 */
	public static function hooks() {

		
		\Newspack\Govpack\CPT\Issue::hooks();
		\Newspack\Govpack\CPT\Profile::hooks();
		\Newspack\Govpack\Block\Issue::hooks();
		\Newspack\Govpack\Block\IssueArchive::hooks();
		\Newspack\Govpack\Block\Profile::hooks();
		\Newspack\Govpack\CPT\AsTaxonomy::hooks();
		\Newspack\Govpack\Tax\City::hooks();
		\Newspack\Govpack\Tax\County::hooks();
		\Newspack\Govpack\Tax\Installation::hooks();
		\Newspack\Govpack\Tax\Issue::hooks();
		\Newspack\Govpack\Tax\LegislativeBody::hooks();
		\Newspack\Govpack\Tax\OfficeHolderStatus::hooks();
		\Newspack\Govpack\Tax\Party::hooks();
		\Newspack\Govpack\Tax\Profile::hooks();
		\Newspack\Govpack\Tax\State::hooks();
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			\Newspack\Govpack\CLI::init();
		}

		\Newspack\Govpack\Importer\Actions::hooks();
		
		
		$menu = new \Newspack\Govpack\Admin\Menu();
		$menu->setPageTitle( 'GovPack' )
			->setMenuTitle( 'GovPack' )
			->setMenuSlug( 'govpack' )
			->setCallback(
				function() {
				
				}
			);

		$item = new \Newspack\Govpack\Admin\MenuItem();
		$menu->addItem(
			$item->setPageTitle( 'Import' )
				->setMenuTitle( 'Import' )
				->setMenuSlug( 'govpack_import' )
				->setCallback( [ '\Newspack\Govpack\Admin\Pages\Import', 'view' ] ) 
		);

		$item = new \Newspack\Govpack\Admin\MenuItem();
		$menu->addItem(
			$item->setPageTitle( 'Profiles' )->setMenuTitle( 'Profiles' )->setMenuSlug( 'govpack_profiles' )->setCallback(
				function() {
					
				} 
			) 
		);

		$item = new \Newspack\Govpack\Admin\MenuItem();
		$menu->addItem(
			$item->setPageTitle( 'Issues' )
				->setMenuTitle( 'Issues' )
				->setMenuSlug( '/edit.php?post_type=govpack_issues' )
				->setCallback(
					function() {
						
					}
				) 
		);

		$menu->create();
	}

	
}

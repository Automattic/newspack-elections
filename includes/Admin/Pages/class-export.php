<?php
/**
 * Govpack
 *
 * @package Govpack
 */

namespace Govpack\Core\Admin\Pages;

/**
 * GovPack Class to Handle Export
 */
class Export {


	/**
	 * Handle View for the Export Form
	 */
	public static function view() { 
		wp_enqueue_script( 'govpack-exporter' );
		wp_enqueue_style( 'wp-components' );
		include __DIR__ . './../Views/export.php';
	}
}

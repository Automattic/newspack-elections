<?php

class Govpack_Bootstrap_Helper {

	static $notice_defaults = array(
		'type'               => 'error',
		'dismissible'        => true,
		'additional_classes' => array( 'inline', 'notice-alt' ),
		'attributes'         => array( 'data-slug' => 'govpack' )
	);

	public static function notice_vendor_missing() {
		\wp_admin_notice(
			__( 'Govpack: Dependencies Not Installed. Please run <code>composer install --no-dev</code> in the plugin directory.', 'govpack' ),
			self::$notice_defaults
		);
	}

	public static function notice_prefixed_vendor_missing() {
		\wp_admin_notice(
			__( 'Govpack: Dependencies Not Prefixed. Please run <code>composer prefix-namespaces</code> in the plugin directory.', 'govpack' ),
			self::$notice_defaults
		);
	}

	public static function notice_build_missing() {
		\wp_admin_notice(
			__( 'Govpack: Compiled CSS and JavaScript are missing. Please run <code>npm install && npm run build</code> in the plugin directory.', 'govpack' ),
			self::$notice_defaults
		);
	}

}
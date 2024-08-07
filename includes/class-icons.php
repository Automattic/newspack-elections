<?php

namespace Govpack\Core;

class Icons {

	private array $cache = [];

	private array $pre_known = [
		'facebook',
		'twitter',
		'linkedin',
		'instagram',
		'email',
		'youtube',
		'x',
		'phone',
		'website',
	];

	public function icon_dir() {
		return GOVPACK_PLUGIN_FILE . '/src/images';
	}
	/**
	 * Load an SVG icon from disk
	 */
	private function load( $icon ) {
		$filepath = sprintf( '%s/%s.svg', $this->icon_dir(), $icon );

		// never load a remote file
		if ( wp_http_validate_url( $filepath ) ) {
			return false;
		}

		
		// file_get_contents may return an error but not an exception, pre-emptivley check the file exists to prevent a warning.
		// we cache this result
		if ( ! file_exists( $filepath ) ) {
			return false;
		}

		$content = file_get_contents( $filepath ); //phpcs:ignore WordPressVIPMinimum.Performance.FetchingRemoteData.FileGetContentsUnknown
		if ( $content === false ) {
			return false;
		}
		return $content;
	}

	/**
	 * Provides an array of all icons that might want to be loaded in advance.
	 * 
	 * TODO : Add a Filter so developer can add new icons to load.
	 * NB : to add new icons this way they'd need to add this to this folder, which they shouldn't. 
	 * The loaders should pass through several directory options
	 */
	public function get_pre_known(): array {
		return $this->pre_known;
	}

	/**
	 * Provides an array of all icons that are pre-known and have been added to the cache since
	 */
	public function all() {
		
		foreach ( $this->pre_known as $icon ) {
			$this->get( $icon );
		}

		return $this->cache;
	}

	/**
	 * Gets an Icon, either from Cache or disk 
	 */
	public function get( $icon ) {

		if ( ! $this->cached( $icon ) ) {
			$value = $this->load( $icon );
			$this->cache( $icon, $value );
		}

		if ( ! $this->cached( $icon ) ) {
			return '';
		}

		return $this->cache[ $icon ];
	}

	/**
	 * Looks for an icon in the icon cache 
	 */
	public function cached( $icon ) {
		return isset( $this->cache[ $icon ] );
	}

	/**
	 * Puts an icon in the cache
	 */
	public function cache( $key, $value ) {
		$this->cache[ $key ] = $value;
	}

	public function exists( $key ) {
		
		$found = $this->get( $key );

		if ( ! $found ) {
			return false;
		}

		// get can return a string, check for empty then covert to bool
		if ( $found === '' ) {
			return false;
		}
		
		return true;
	}
}

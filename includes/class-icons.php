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
		'website'
	];

	public function icon_dir(){
		return GOVPACK_PLUGIN_FILE . '/src/images';
	}
	/**
	 * Load an SVG icon from disk
	 */
	public function load($icon){
		$filepath = sprintf("%s/%s.svg", $this->icon_dir(), $icon);
		// Suppress the warning when a file isn't found. We want to fall to go to the cache so we know not to try this icon again.
		return @file_get_contents( $filepath );
	}

	/**
	 * Provides an array of all icons that might want to be loaded in advance.
	 * 
	 * TODO : Add a Filter so developer can add new icons to load.
	 * NB : to add new icons this way they'd need to add this to this folder, which they shouldn't. 
	 * The loaders should pass through several directory options
	 */
	public function get_pre_known() : array {
		return $this->pre_known;
	}

	/**
	 * Provides an array of all icons that are pre-known and have been added to the cache since
	 */
	public function all(){
		
		foreach($this->pre_known as $icon){
			$this->get($icon);
		}

		return $this->cache;
	}

	/**
	 * Gets an Icon, either from Cache or disk 
	 */
	public function get($icon){

		if(!$this->cached($icon)){
			$value = $this->load($icon);
			$this->cache($icon, $value);
		}

		return $this->cache[$icon];
	}

	/**
	 * looks for an icon in the icon cache 
	 */
	public function cached($icon){
		return isset($this->cache[$icon]);
	}

	/**
	 * Puts an icon in the cache
	 */
	public function cache($key, $value){
		$this->cache[$key] = $value;
	}

}
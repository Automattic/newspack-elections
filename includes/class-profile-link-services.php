<?php

namespace Govpack\Core;

use PO;

class Profile_Link_Services {

	

	/**
	 * Array that stores the generated link objects for each service
	 */
	private $services;

	public function __construct() {
	}

	public function get_linkable() {

		// a list of known classes
		$linkable = [
			'Ballotpedia',
			'Fec',
			'Gab',
			'Google',
			'Govtrack',
			'Linkedin',
			'OpenSecrets',
			'OpenStates',
			'Rumble',
			'VoteSmart',
			'VoteView',
			'WikiPedia', 
		];

		

		//generate the FullyQualified Class names
		$classes = array_map(
			function ( $classname ) {
				return __NAMESPACE__ . '\\ProfileLinks\\' . $classname;
			},
			$linkable
		);

		// filter down to only classes the definitly exist
		$classes = array_filter(
			$classes,
			function ( $classname ) {
				return class_exists( $classname );
			}
		);

		
		
		return $classes;
	}

	public function get_services() {
		
		if ( isset( $this->services ) ) {
			return $this->services;
		}   
		
		$this->services = [];
		
		foreach ( $this->get_linkable() as $class ) {
			$linkable                                = new $class( $this );
			$this->services[ $linkable->get_slug() ] = $linkable;
		}

		return $this->services;
	}

	public function to_array() {
		return array_map(
			function ( $link ) {
				return $link->get_service();
			},
			$this->get_services()
		);
	}
}

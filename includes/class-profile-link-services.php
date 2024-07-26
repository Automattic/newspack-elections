<?php

namespace Govpack\Core;

use PO;

class Profile_Link_Services {

	

	/**
	 * Array that stores the generated link objects for each service
	 */
	private $services;

	public function __construct()
	{

	}

	public function getLinkable(){

		// a list of known classes
		$linkable = [
			//'BallotPedia',
			'Fec',
			'Gab',
			'Google',
			'Govtrack',
			'Linkedin',
			'OpenSecrets',
			//'OpenStates',
			'Rumble',
			'VoteSmart',
			'VoteView',
			'WikiPedia', 
		];

		

		//generate the FullyQualified Class names
		$classes = array_map(function($class){
			return __NAMESPACE__ . '\\ProfileLinks\\' . $class;
		}, $linkable);

		

		// filter down to only classes the definitly exist
		$classes = array_filter($classes, function($class){
			return class_exists($class);
		});

		
		
		return $classes;
	}

	public function get_services(){
		
		if(isset($this->services)){
			return $this->services;
		}	
		
		$this->services = [];
		
		foreach($this->getLinkable() as $class){
			$linkable = new $class($this);
			$this->services[$linkable->get_slug()] = $linkable;
		}

		return $this->services;
	}

	public function toArray(){
		return array_map(function($link){
			return $link->get_service();
		}, $this->get_services());
	}
}
<?php

namespace Govpack\Core;

class Profile_Links {

	/**
	 * Post ID of the govpack profile this will generate links for
	 */
	public $profile_id;

	/**
	 * Array that stores the test results for each link service
	 */
	private $tests = [];

	/**
	 * Array that stores the generated link objects for each service
	 */
	private $links = [];

	public function __construct($profile_id)
	{
		$this->profile_id = $profile_id;
	}

	public function getLinkable(){

		// a list of known classes
		$linkable = [
			'BalletPedia',
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

	public function generate(){
		foreach($this->getLinkable() as $class){
			$linkable = new $class($this);

			// test this link option, save the result and move on to the next of its a failure
			$this->tests[$linkable->get_slug()] = $linkable->test();
			if(!$this->tests[$linkable->get_slug()]){
				continue;
			}

			$this->links[$linkable->get_slug()] = $linkable;
		}
	}

	public function get_meta($key){
		return get_post_meta( $this->profile_id , $key, true );
	}

	public function toArray(){
		return array_map(function($link){
			return $link->toArray();
		}, $this->links);
	}
}
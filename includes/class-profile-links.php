<?php

namespace Govpack\Core;

class Profile_Links {

	private $profile_id;

	private $tests = [];
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
			'OpenStates',
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
			$linkable = new $class();

			// test this link option, save the result and move on to the next of its a failure
			$this->tests[$linkable->get_slug()] = $linkable->test($this->profile_id);
			if(!$this->tests[$linkable->get_slug()]){
				continue;
			}

			$this->links[$linkable->get_slug()] = $linkable;
		}
	}

	public function toArray(){
		return array_map(function($link){
			return $link->toArray();
		}, $this->links);
	}
}
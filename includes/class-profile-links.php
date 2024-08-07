<?php

namespace Govpack\Core;

class Profile_Links extends Profile_Link_Services {

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

	public function __construct( $profile_id ) {
		$this->profile_id = $profile_id;
	}


	public function generate() {
		foreach ( $this->get_linkable() as $class ) {
			$linkable = new $class( $this );

			if ( ! $linkable->enabled() ) {
				continue;
			}

			// test this link option, save the result and move on to the next of its a failure
			$this->tests[ $linkable->get_slug() ] = $linkable->test();
			if ( ! $this->tests[ $linkable->get_slug() ] ) {
				continue;
			}

			$this->links[ $linkable->get_slug() ] = $linkable;
		}
	}

	public function get_meta( $key ) {
		return get_post_meta( $this->profile_id, $key, true );
	}

	public function to_array() {
		return array_map(
			function ( $link ) {
				return $link->to_array();
			},
			$this->links
		);
	}
}

<?php

namespace Govpack\Core;

class Permalinks {

	/**
	 * Stores static instance of class.
	 *
	 * @access protected
	 * @var Govpack\Govpack The single instance of the class
	 */
	protected static $instance = null;

	private $option_name = "govpack_permalinks";

	private $permalinks = array();


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


	public function permalinks(){
		if(empty($this->permalinks)){
			$this->permalinks = $this->get_permalinks();
		}

		return $this->permalinks;
	}

	private function defaults(){
		return [
			"profile_base" => ''
		];
	}

	public function get_permalinks(){
		return (array) get_option( $this->option_name, $this->defaults());
	}

	
	public function update_permalinks(){
		update_option( $this->option_name , $this->permalinks );
	}

}

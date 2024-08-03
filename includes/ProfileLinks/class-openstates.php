<?php
namespace Govpack\Core\ProfileLinks;

class OpenStates extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "openstates";

	public function meta_key(){
		return 'openstates_id';
	}

	public function label(){
		return 'OpenStates';
	}

	public function enabled(){
		return true;
	}
}
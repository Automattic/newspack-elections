<?php
namespace Govpack\Core\ProfileLinks;

class Google extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "google";

	public function meta_key(){
		return 'google_entity_id';
	}

	public function label(){
		return 'Google';
	}
}
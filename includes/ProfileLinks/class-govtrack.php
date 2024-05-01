<?php
namespace Govpack\Core\ProfileLinks;

class Govtrack extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "govtrack";

	public function meta_key(){
		return 'govtrack_id';
	}

	public function label(){
		return 'GovTrack';
	}
}
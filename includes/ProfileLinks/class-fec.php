<?php
namespace Govpack\Core\ProfileLinks;

class Fec extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "fec";

	public function meta_key(){
		return 'fec_id';
	}

	public function label(){
		return 'FEC';
	}
}
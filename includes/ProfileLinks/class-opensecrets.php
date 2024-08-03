<?php
namespace Govpack\Core\ProfileLinks;

class OpenSecrets extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "opensecrets";

	public function meta_key(){
		return 'opensecrets_id';
	}

	public function label(){
		return 'OpenSecrets';
	}

	public function enabled(){
		return true;
	}
}
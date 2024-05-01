<?php
namespace Govpack\Core\ProfileLinks;

class Linkedin extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "linkedin";

	public function meta_key(){
		return 'linkedin';
	}

	public function label(){
		return 'LinkedIn';
	}
}
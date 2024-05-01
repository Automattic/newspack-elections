<?php
namespace Govpack\Core\ProfileLinks;

class BalletPedia extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "balletpedia";

	public function meta_key(){
		return 'balletpedia_id';
	}

	public function label(){
		return 'BalletPedia';
	}
}
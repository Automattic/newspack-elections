<?php
namespace Govpack\Core\ProfileLinks;

class WikiPedia extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "wikipedia";

	public function meta_key(){
		return 'wikipedia_id';
	}

	public function label(){
		return 'WikiPedia';
	}

	public function url_template(){
		return "https://wikipedia.org/wiki/{wikipedia_id}/";
	}
}
<?php
namespace Govpack\Core\ProfileLinks;

class Fec extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "fec";

	public function meta_key(){
		return 'fec_id';
	}

	public function label(){
		return 'Federal Election Comission';
	}

	public function url_template(){
		return "https://www.fec.gov/data/candidate/{fec_id}/";
	}
}
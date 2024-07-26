<?php
namespace Govpack\Core\ProfileLinks;

class BallotPedia extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "ballotpedia";

	public function meta_key(){
		return 'ballotpedia_id';
	}

	public function label(){
		return 'BallotPedia';
	}

	public function url_template(){
		return "https://www.fec.gov/data/candidate/{fec_id}/";
	}
}
<?php
namespace Govpack\Core\ProfileLinks;

class BallotPedia extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = 'ballotpedia';

	public function meta_key() {
		return 'balletpedia_id';
	}

	public function label() {
		return 'Ballotpedia';
	}

	public function url_template() {
		return 'https://ballotpedia.org/{balletpedia_id}';
	}
}

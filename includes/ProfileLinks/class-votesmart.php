<?php
namespace Govpack\Core\ProfileLinks;

class VoteSmart extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "votesmart";

	public function meta_key(){
		return 'votesmart_id';
	}

	public function label(){
		return 'VoteSmart';
	}
}
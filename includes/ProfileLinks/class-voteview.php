<?php
namespace Govpack\Core\ProfileLinks;

class VoteView extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "voteview";

	public function meta_key(){
		return 'icpsr_id';
	}

	public function label(){
		return 'VoteView';
	}
}
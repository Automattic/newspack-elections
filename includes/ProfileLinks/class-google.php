<?php
namespace Govpack\Core\ProfileLinks;

class Google extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = "google";

	public function meta_key(){
		return 'google_entity_id';
	}

	public function label(){
		return 'Google Trends';
	}

	public function prep_meta_value($meta_value){
		return urlencode($meta_value);
	}

	public function url_template(){
		///m/01rbs3 = %2Fm%2F01rbs3
		return "https://trends.google.com/trends/explore?date=all&q={google_entity_id}";
	} 
}
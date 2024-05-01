<?php
namespace Govpack\Core\ProfileLinks;

abstract class ProfileLink {
	protected $label;
	protected $slug = false;
	protected $post_meta;

	abstract function meta_key();
	abstract function label();

	public function test($profile_id){

		if(!$this->profile_has_meta_key($profile_id)){
			return false;
		}

		return true;
	}

	public function get_slug(){

		if(!$this->slug){
			die("No Slug In Linkable");
		}

		return $this->slug;
	}

	public function profile_has_meta_key($profile_id){
		$post_meta = $this->meta_value($profile_id);
		
		if(!$post_meta){
			return false;
		}

		if($post_meta === ""){
			return false;
		}

		return true;
	}

	public function meta_value($profile_id){
		if(isset($this->post_meta)){
			return $this->post_meta;
		}

		$this->post_meta = get_post_meta( $profile_id , $this->meta_key(), true );
		return $this->post_meta;
	}

	public function toArray () {
		return [
			"target" => "_blank",
			"src" => $this->generate_url(),
			"label" => $this->label()
		];
	}

	public function generate_url(){
		return "https://sfdsad";
	}
}
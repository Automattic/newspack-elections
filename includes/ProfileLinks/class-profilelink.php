<?php
namespace Govpack\Core\ProfileLinks;

abstract class ProfileLink {
	protected $label;
	protected $slug = false;
	protected $post_meta;
	protected $profile;

	abstract function meta_key();
	abstract function label();
	function url_template(){return "";}

	public function __construct($profile){
		$this->profile = $profile;
	}

	public function test(){
		
		if(!$this->profile_has_meta_key($this->profile->profile_id)){
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

	public function profile_has_meta_key(){
		$post_meta = $this->meta_value();
		
		if(!$post_meta){
			return false;
		}

		if($post_meta === ""){
			return false;
		}

		return true;
	}

	public function meta_value(){
		if(isset($this->post_meta)){
			return $this->post_meta;
		}

		$this->post_meta = $this->profile->get_meta($this->meta_key());
		return $this->post_meta;
	}

	public function toArray () {
		return [
			"meta" => $this->meta_value(),
			"target" => "_blank",
			"src" => $this->generate_url(),
			"label" => $this->label()
		];
	}

	public function generate_url(){
		$template = $this->url_template();
		$tag = "{". $this->meta_key() ."}";
		$with_placeholders = str_replace($tag, "%s", $template);
		return sprintf($with_placeholders, $this->meta_value());
	}
}
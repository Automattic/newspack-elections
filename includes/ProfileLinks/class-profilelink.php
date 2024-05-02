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

	public function prep_meta_value($meta_value){
		return $meta_value;
	}

	public function toArray () {
		return [
			"meta" => $this->meta_value(),
			"target" => "_blank",
			"href" => $this->href(),
			"text" => $this->label(),
			"id" => null,
			"rel" => null,
			"class" => []
		];
	}

	public function generate_url(){
		$template = $this->url_template();
		$tag = "{". $this->meta_key() ."}";
		$with_placeholders = str_replace($tag, "%s", $template);
		return sprintf($with_placeholders, $this->prep_meta_value($this->meta_value()));
	}

	public function is_url_valid($url){
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			return false;
		}

		return true;
	}
	public function href(){

		if($this->is_url_valid($this->meta_value())){
			return $this->meta_value();
		}
		
		$new_url = $this->generate_url();
		if($this->is_url_valid($new_url)){
			return $new_url;
		}

		return false;
	}
}
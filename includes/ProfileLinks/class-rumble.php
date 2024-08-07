<?php
namespace Govpack\Core\ProfileLinks;

class Rumble extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = 'rumble';

	public function meta_key() {
		return 'rumble';
	}
	public function label() {
		return 'Rumble';
	}
	public function url_template() {
		return 'https://rumble.com/user/{rumble}/';
	}
}

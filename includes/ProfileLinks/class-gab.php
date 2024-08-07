<?php
namespace Govpack\Core\ProfileLinks;

class Gab extends \Govpack\Core\ProfileLinks\ProfileLink {

	protected $slug = 'gab';

	public function meta_key() {
		return 'gab';
	}

	public function label() {
		return 'Gab';
	}

	public function url_template() {
		return 'https://gab.com/{gab}/';
	}
}

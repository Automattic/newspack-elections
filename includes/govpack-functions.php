<?php

function gp(){
	return Govpack\Core\Govpack::instance();
}

function gp_template_loader(){
	return gp()->front_end()->template_loader();
}

function gp_get_template_part( $slug, $name = '' ) {
	return gp_template_loader()->get_template_part($slug, $name);
}

function gp_get_permalink_structure(){
	return Govpack\Core\Permalinks::instance()->permalinks();
}

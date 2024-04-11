<?php


function govpack_get_template_part( $slug, $name = '' ) {
	return gp_template_loader()->get_template_part($slug, $name);
}

function gp_template_loader(){
	return Govpack\Core\Govpack::instance()->front_end->template_loader();
}
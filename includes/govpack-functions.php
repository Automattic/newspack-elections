<?php

function gp(){
	return Govpack\Core\Govpack::instance();
}

function gp_template_loader(){
	return gp()->front_end()->template_loader();
}

function gp_get_template_part( $slug, $name = '', $data = [] ) {
	return gp_template_loader()->get_template_part($slug, $name, true, $data);
}

function gp_get_block_part( $slug, $name = '', $attributes = [], $content = "", $block = null, $extra = null ) {
	return gp_template_loader()->get_block_part($slug, $name, $attributes, $content, $block, $extra);
}

function gp_get_permalink_structure(){
	return Govpack\Core\Permalinks::instance()->permalinks();
}

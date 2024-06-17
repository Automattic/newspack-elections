<?php

if(!function_exists("gp")){
	function gp(){
		return Govpack\Core\Govpack::instance();
	}
}

if(!function_exists("gp_template_loader")){
	function gp_template_loader(){
		return gp()->front_end()->template_loader();
	}
}

if(!function_exists("gp_get_template_part")){
	function gp_get_template_part( $slug, $name = '', $data = [] ) {
		return gp_template_loader()->get_template_part($slug, $name, true, $data);
	}
}

if(!function_exists("gp_get_block_part")){
	function gp_get_block_part( $slug, $name = '', $attributes = [], $content = "", $block = null, $extra = null ) {
		return gp_template_loader()->get_block_part($slug, $name, $attributes, $content, $block, $extra);
	}
}

if(!function_exists("gp_get_permalink_structure")){
	function gp_get_permalink_structure(){
		return Govpack\Core\Permalinks::instance()->permalinks();
	}
}
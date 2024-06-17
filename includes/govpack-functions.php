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

/**
 * Provides Developer feedback if using a hook, method or function is being used incorrectly.
 * 
 * Trigers a userland error if WP_DEBUG is true.
 * 
 * Wraps the core `_doing_it_wrong` function as it provides all we need for now but it may change 
 * or our needs may evolve.
 * 
 * See https://developer.wordpress.org/reference/functions/_doing_it_wrong/ for info.
 */
if(!function_exists("gp_doing_it_wrong")){
	function gp_doing_it_wrong(string $function_name, string $message, string $version) : void {
		_doing_it_wrong( $function_name, $message, $version );
	}
}
<?php

namespace Govpack\Core;

class Widgets {

	public static function hooks(){
		add_action("widgets_init", [__CLASS__, 'register_widget_area']);
	}

	public static function register_widget_area(){
		register_sidebar(
			array(
				'name'          => __( 'Govpack Sidebar ', 'govpack' ),
				'id'            => 'govpack-sidebar',
				'description'   => esc_html__( 'Add widgets here to appear in the sidebar of Govpack profiles.', 'govpack' ),
				'before_widget' => '<section id="%1$s" class="below-content widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widgettitle">',
				'after_title'   => '</h2>',
			)
		);
	}
}
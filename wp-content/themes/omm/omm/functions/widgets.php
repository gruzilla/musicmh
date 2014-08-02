<?php

if ( function_exists( 'register_sidebar' ) ) {

	register_sidebar( array(
		'name' => __( "Sidebar Blog", 'onioneye' ),
		'id' => 'sidebar-blog',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
		
	register_sidebar( array(
		'name' => __( "Sidebar Pages", 'onioneye' ),
		'id' => 'sidebar-pages',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
	
}

?>

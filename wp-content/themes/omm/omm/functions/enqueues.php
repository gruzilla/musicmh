<?php

/*-----------------------------------------------------------------------------------*/
/*	Register and Enqueue Theme Styles
/*-----------------------------------------------------------------------------------*/

function oy_add_main_styles() {

	wp_enqueue_style( 'oy-normalize', get_template_directory_uri() . '/css/normalize.css' );
    wp_enqueue_style( 'oy-style', get_stylesheet_uri() );

}

function oy_add_ie_styles() {

	 wp_register_style( 'ie-style', get_template_directory_uri() . '/css/ie9.css', 'all' );
     wp_enqueue_style( 'ie-style' );

}

function oy_add_fonts() {

    $protocol = is_ssl() ? 'https' : 'http';
    global $wp_styles;
    // somebody else alredy registers open-sans
    // wp_enqueue_style( 'oy-open-sans', "$protocol://fonts.googleapis.com/css?family=Open+Sans:400,500,300&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext" );
    wp_enqueue_style( 'oy-teko', "$protocol://fonts.googleapis.com/css?family=Teko:300,400,500,600,700&subset=latin,cyrillic-ext,cyrillic,greek-ext,greek,vietnamese,latin-ext" );
}

function oy_fix_prefixfree_fonts($tag){
    $customXML = new SimpleXMLElement($tag);
    $attrs = $customXML->attributes();
    if (!isset($attrs->id)) {
        return $tag;
    }
    $id = (string)$attrs->id;
    $values = explode('-', $id);

    if (array_pop($values) !== 'css') {
        return $tag;
    }

    $id = join('-', $values);

    if (!in_array($id, array('oy-teko', 'oy-open-sans', 'open-sans'))) {
        return $tag;
    }

    $customXML->addAttribute('data-noprefix', 'data-noprefix');
    $dom = dom_import_simplexml($customXML);

    return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
}

add_action( 'wp_enqueue_scripts', 'oy_add_main_styles', 1 );
add_action( 'wp_enqueue_scripts', 'oy_add_ie_styles', 2 );
add_action( 'wp_enqueue_scripts', 'oy_add_fonts', 3 );

add_filter('style_loader_tag', 'oy_fix_prefixfree_fonts');

/*-----------------------------------------------------------------------------------*/
/*	Register and Enqueue Theme Scripts
/*-----------------------------------------------------------------------------------*/

function oy_add_modernizr() {

    wp_register_script( 'oy-modernizr', get_template_directory_uri() . '/js/modernizr.custom-2.7.1.min.js', false, '2.7.1' );
    wp_enqueue_script( 'oy-modernizr' );

}


function oy_add_prefixfree() {

    wp_register_script( 'oy-prefixfree', get_template_directory_uri() . '/js/prefixfree.min.js', false, '1.0.3' );
    wp_enqueue_script( 'oy-prefixfree' );

}


function oy_add_jquery() {

    wp_enqueue_script( 'jquery' );

}


function oy_add_isotope() {

	wp_enqueue_script( 'oy-isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array ( 'jquery' ) );

}


function oy_add_jquery_easing() {

    wp_register_script( 'oy-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'oy-easing' );

}


function oy_add_fit_vids() {

    wp_register_script( 'oy-fit_vids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.0.0', true );
    wp_enqueue_script( 'oy-fit_vids' );

}


function oy_add_transit() {

    wp_register_script( 'oy-transit', get_template_directory_uri() . '/js/jquery.transit.min.js', array( 'jquery' ), '0.9.9', true );
    wp_enqueue_script( 'oy-transit' );

}

function oy_add_gumroad() {
    wp_register_script( 'oy-gumroad', 'https://gumroad.com/js/gumroad.js', array('jquery'));
    //wp_register_script( 'oy-gumroad', 'https://gumroad.com/js/gumroad.js', array('gumroad'), '0.0.1', true);
    wp_enqueue_script( 'oy-gumroad' );
}


function oy_add_comment_reply() {
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}


function oy_add_custom_footer_jquery() {

	wp_enqueue_script('oy-custom-footer-js', get_template_directory_uri() . '/js/jquery.footer.custom.js', array( 'jquery' ), false, true);

}


/* wp enqueue script */
add_action( 'wp_enqueue_scripts', 'oy_add_modernizr', 5 );
add_action( 'wp_enqueue_scripts', 'oy_add_prefixfree', 8 );
add_action( 'wp_enqueue_scripts', 'oy_add_transit', 10 );
add_action( 'wp_enqueue_scripts', 'oy_add_jquery', 15 );
add_action( 'wp_enqueue_scripts', 'oy_add_gumroad', 17);
add_action( 'wp_enqueue_scripts', 'oy_add_isotope', 20 );
add_action( 'wp_enqueue_scripts', 'oy_add_jquery_easing', 30 );
add_action( 'wp_enqueue_scripts', 'oy_add_fit_vids', 70 );
add_action( 'wp_enqueue_scripts', 'oy_add_custom_footer_jquery', 90 );
add_action( 'wp_enqueue_scripts', 'oy_add_comment_reply' );

?>
<?php

/* Set the content width based on the theme's design and stylesheet. */
if( ! isset( $content_width ) )
    $content_width = 940;

function oy_adjust_content_width() {

	global $content_width;

    if( is_page_template( 'template-page-with-sidebar.php' ) ) {
    	$content_width = 628;
    }

    if( is_singular( 'post' ) || is_home() ) {
    	$content_width = 705;
    }

}

add_action( 'template_redirect', 'oy_adjust_content_width' );


/*-----------------------------------------------------------------------------------*/
/* Theme Includes */
/*-----------------------------------------------------------------------------------*/

require_once( get_template_directory() . '/functions/options.php' );
require_once( get_template_directory() . '/functions/theme-functions.php' );
require_once( get_template_directory() . '/functions/enqueues.php' );
require_once( get_template_directory() . '/functions/widgets.php' );
require_once( get_template_directory() . '/functions/plugins.php' );


/*-----------------------------------------------------------------------------------*/
/*	Theme Support
/*-----------------------------------------------------------------------------------*/

// Adding WP 3+ Functions & Theme Support
function oy_theme_support() {

	add_theme_support('post-thumbnails', array( 'post', 'mmtile' ));
	add_theme_support('custom-background');
	add_theme_support('automatic-feed-links'); // rss thingy
	add_theme_support('menus');            // wp menus
	register_nav_menu('main', __( 'The main menu', 'onioneye' ));

	/* Allow for localization */
	load_theme_textdomain ('onioneye');

}

// launching this stuff after theme setup
add_action('after_setup_theme', 'oy_theme_support');


/*-----------------------------------------------------------------------------------*/
/* Excerpts
/*-----------------------------------------------------------------------------------*/

function new_excerpt_more( $more ) {
    global $post;
	return '… <span class="read-btn"><a class="read-more" href="'. get_permalink( $post->ID ) . '">' . __( 'Read More &rarr;', 'onioneye' ) . '</a></span>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function wpe_new_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'wpe_new_excerpt_length' );


/*-----------------------------------------------------------------------------------*/
/* Thumbnail Size Options
/*-----------------------------------------------------------------------------------*/

if(function_exists('add_image_size')) {
	set_post_thumbnail_size(9999, 9999); // Default post thumbnail size
	add_image_size('mid-size', 600, 9999); // Post thumbnail size
	add_image_size('content-width', 940, 9999); // Permalink thumbnail size
	add_image_size('full-size', 9999, 9999); // Full size image
	add_image_size('gallery-thumb', 480, 400, true); //change to false to disable hard cropping
}


/*-----------------------------------------------------------------------------------*/
/* Search Function
/*-----------------------------------------------------------------------------------*/

add_filter('pre_get_posts', 'tgm_cpt_search');
/**
 * This function modifies the main WordPress query to include an array of post types instead of the default 'post' post type.
 *
 * @param mixed $query The original query
 * @return $query The amended query
 */
function tgm_cpt_search($query) {
    if (!is_admin() && $query->is_search)
		$query->set('post_type', array('post', 'mmtile'));
    return $query;
};


/*-----------------------------------------------------------------------------------*/
/* Comment Layout
/*-----------------------------------------------------------------------------------*/

function oy_post_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="comment-body group">
			<header class="comment-author vcard">
				<?php echo get_avatar( $comment, 45 ); ?>
				<?php printf(__('<cite class="fn">%s</cite>'), get_comment_author_link()) ?>
				<div class="comment-meta">
					<time datetime="<?php echo comment_time('Y-m-j'); ?>"><?php comment_time('F jS, Y'); ?></time>
					<span class="bullet">&nbsp;&middot;&nbsp;</span>
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					<?php edit_comment_link(__('&nbsp;&middot;&nbsp; Edit', 'onioneye'),'  ','') ?>
				</div>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="help">
          			<p><?php _e('Your comment is awaiting moderation.', 'onioneye') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content group">
				<?php comment_text() ?>
			</section>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
}


/*-----------------------------------------------------------------------------------*/
/* Custom Walker
/*-----------------------------------------------------------------------------------*/

class Nfr_Menu_Walker extends Walker_Nav_Menu{

	/**
    * Traverse elements to create list from elements.
    *
    * Display one element if the element doesn't have any children otherwise,
    * display the element and its children. Will only traverse up to the max
    * depth and no ignore elements under that depth. It is possible to set the
    * max depth to include all depths, see walk() method.
    *
    * This method shouldn't be called directly, use the walk() method instead.
    *
    * @since 2.5.0
    *
    * @param object $element Data object
    * @param array $children_elements List of elements to continue traversing.
    * @param int $max_depth Max depth to traverse.
    * @param int $depth Depth of current element.
    * @param array $args
    * @param string $output Passed by reference. Used to append additional content.
    * @return null Null on failure with no changes to parameters.
    */
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
        	return;

        $id_field = $this->db_fields['id'];

        //display this element
        if ( is_array( $args[0] ) )
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );

        //Adds the 'parent' class to the current item if it has children
        if( ! empty( $children_elements[$element->$id_field] ) ) {
       		array_push($element->classes,'parent');
        }

        $cb_args = array_merge( array(&$output, $element, $depth), $args);

        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

        	foreach( $children_elements[ $id ] as $child ){

            	if ( !isset($newlevel) ) {
                	$newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                	$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
           	}
            unset( $children_elements[ $id ] );
        }

        if ( isset($newlevel) && $newlevel ){
    	    //end the child delimiter
            $cb_args = array_merge( array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge( array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
}


/*-----------------------------------------------------------------------------------*/
/*	Modified Native WP Gallery Shortcode
/*-----------------------------------------------------------------------------------*/

add_filter("post_gallery", "wpse56909_post_gallery",10,2);
function wpse56909_post_gallery($output, $attr) {
    global $post;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'gallery-thumb',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
        $gallery_style = "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;
            }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->";
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon'>
                $link
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";

    return $output;
}


/*-----------------------------------------------------------------------------------*/
/*	Miscellaneous
/*-----------------------------------------------------------------------------------*/

// This will ensure that the text content of widgets is parsed for shortcodes and those shortcodes are ran. Awesome.
add_filter('widget_text', 'do_shortcode');

//Enable AutoEmbeds from Plain Text URLs in Text Widgets
add_filter( 'widget_text', array( $wp_embed, 'run_shortcode' ), 8 );
add_filter( 'widget_text', array( $wp_embed, 'autoembed'), 8 );

// loading jquery reply elements on single pages automatically
function oy_queue_js(){
	if (!is_admin()){ if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) wp_enqueue_script('comment-reply'); }
}

// reply on comments script
add_action('wp_print_scripts', 'oy_queue_js');


// setup code for the metronet plugin, that lets you easily reorder posts by drag and drop
add_filter( 'metronet_reorder_post_types', 'slug_set_reorder' );
function slug_set_reorder( $post_types ) {
    $post_types = array( 'mmtile' );
    return $post_types;
}

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

?>
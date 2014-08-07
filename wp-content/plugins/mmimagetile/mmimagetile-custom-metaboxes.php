<?php
/**
 * @wordpress-plugin
 * Plugin Name: MMImageTile Custom Metaboxes
 * Description: Enables custom metaboxes for the mmimagetile post type.
 * Version:     1.0.0
 * Author:      gruzilla
 * Author URI:  https://abendstille.at
 * Text Domain: mmimagetilemetaboxes
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

load_plugin_textdomain( 'mmimagetilemetaboxes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

function mmimagetile_initialize_cmb_meta_boxes() {
    if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( 'includes/metabox/init.php' );
    }
}

add_action( 'init', 'mmimagetile_initialize_cmb_meta_boxes', 9999 );


function mmimagetile_alerts_metaboxes( $meta_boxes ) {
    $prefix = 'onioneye_'; // Prefix for all fields
    $meta_boxes[] = array(
        'id' => 'onioneye_metabox',
        'title' => __('Additional Information', 'mmimagetilemetaboxes'),
        'pages' => array('mmimagetile'), // post type
        'context' => 'normal',
        'priority' => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(
            array(
                'name' => __('Image 1', 'image0'),
                'desc' => __('The images that should iterate automataically'),
                'id' => $prefix . 'image0',
                'type' => 'file',
            ),
            array(
                'name' => __('Image 2', 'image1'),
                'desc' => __('The images that should iterate automataically'),
                'id' => $prefix . 'image1',
                'type' => 'file',
            ),
            array(
                'name' => __('Image 3', 'image2'),
                'desc' => __('The images that should iterate automataically'),
                'id' => $prefix . 'image2',
                'type' => 'file',
            ),
            array(
                'name' => __('Switch speed', 'switchspeed'),
                'desc' => __('How many milliseconds should the animation pause between every image.'),
                'id' => $prefix . 'switchspeed',
                'type' => 'text',
            ),
        ),
    );

    return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'mmimagetile_alerts_metaboxes' );


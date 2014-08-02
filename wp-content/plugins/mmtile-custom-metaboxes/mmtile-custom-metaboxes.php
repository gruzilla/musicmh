<?php
/**
 * @wordpress-plugin
 * Plugin Name: MMTile Custom Metaboxes
 * Description: Enables custom metaboxes for the mmtile post type.
 * Version:     1.0.0
 * Author:      OnionEye
 * Author URI:  http://themeforest.net/user/onioneye
 * Text Domain: mmtilemetaboxes
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

load_plugin_textdomain( 'mmtilemetaboxes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'includes/metabox/init.php' );
	}
}

add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );


function twpb_alerts_metaboxes( $meta_boxes ) {
	$prefix = 'onioneye_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'onioneye_metabox',
		'title' => __('Additional Information', 'mmtilemetaboxes'),
		'pages' => array('mmtile'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Soundcloud Url', 'mmtilemetaboxes'),
				'desc' => __('The url to the soundcloud song. eg.: https://soundcloud.com/themavrikk/when-da-bass-goes-boom', 'mmtilemetaboxes'),
				'id' => $prefix . 'soundcloud',
				'type' => 'text',
			),
			array(
				'name' => __('Gumroad Url', 'mmtilemetaboxes'),
				'desc' => __('The URL to the gumroad item. eg.: https://gum.co/demo', 'mmtilemetaboxes'),
				'id' => $prefix . 'gumroad',
				'type' => 'text'
			),
			array(
				'name' => __('BPM', 'mmtilemetaboxes'),
				'desc' => __('Beats per minute. eg. 120', 'mmtilemetaboxes'),
				'id' => $prefix . 'bpm',
				'type' => 'text'
			),
			array(
				'name' => __('Color', 'mmtilemetaboxes'),
				'desc' => __('Overlaying color.', 'mmtilemetaboxes') . ' Colors:<br />'.join('<br />', array(
					'black  #746e68',
					'orange #dab48e',
					'green1 #949e77',
					'green2 #90b78f',
					'blue   #8fc5cf',
					'violet #ab97a2',
					'brown  #9e897a',
				)),
				'id' => $prefix . 'color',
				'type' => 'colorpicker'
			),
			array(
				'name' => __('Publication Date', 'mmtilemetaboxes'),
				'desc' => __('Display the publication date of this post in the live view?', 'mmtilemetaboxes'),
				'id'   => $prefix . 'publication_date',
				'type' => 'checkbox',
		    ),
		),
	);

	return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'twpb_alerts_metaboxes' );


<?php
/**
 * @wordpress-plugin
 * Plugin Name: Portfolio Custom Metaboxes
 * Description: Enables custom metaboxes for the portfolio post type. 
 * Version:     1.0.0
 * Author:      OnionEye
 * Author URI:  http://themeforest.net/user/onioneye
 * Text Domain: portfoliometaboxes
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */
 
load_plugin_textdomain( 'portfoliometaboxes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

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
		'title' => __('Additional Information', 'portfoliometaboxes'), 
		'pages' => array('portfolio'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => __('Client', 'portfoliometaboxes'),
				'desc' => __('The name of the client for this portfolio item.', 'portfoliometaboxes'),
				'id' => $prefix . 'client',
				'type' => 'text',				
			),
			array(
				'name' => __('Item URL', 'portfoliometaboxes'),
				'desc' => __('The link/URL of this portfolio item.', 'portfoliometaboxes'),
				'id' => $prefix . 'item_url',
				'type' => 'text'				
			),
			array(
				'name' => __('Publication Date', 'portfoliometaboxes'),
				'desc' => __('Display the publication date of this post in the live view?', 'portfoliometaboxes'),
				'id'   => $prefix . 'publication_date',
				'type' => 'checkbox',
		    ),
		),
	);

	return $meta_boxes;
}

add_filter( 'cmb_meta_boxes', 'twpb_alerts_metaboxes' );

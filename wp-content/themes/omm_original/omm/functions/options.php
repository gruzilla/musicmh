<?php

/*-----------------------------------------------------------------------------------*/
/*	Theme Customization Options
/*-----------------------------------------------------------------------------------*/
 
add_action( 'customize_register', 'themename_customize_register' );

function themename_customize_register($wp_customize) {

	$wp_customize->remove_section('colors');
	$wp_customize->remove_section('background_image');
	$wp_customize->get_section('static_front_page')->priority = 20;
	$wp_customize->get_section('nav')->priority = 30;

	/*-----------------------------------------------------------------------------------*/
	/*	General Settings
	/*-----------------------------------------------------------------------------------*/

	$wp_customize->get_section('title_tagline')->title = __('General Settings', 'onioneye');
	$wp_customize->get_section('title_tagline')->priority = 10;
    
    $wp_customize->add_setting('oy_logo');
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'oy_custom_logo', array(
        'label'   => __('Main Logo', 'onioneye'),
        'section' => 'title_tagline',
        'settings'   => 'oy_logo',
    ) ) );
    
    $wp_customize->add_setting('oy_is_logo_retina');
    
    $wp_customize->add_control('oy_retina_ready', array(
	    'label'    => __('Make the logo retina ready? (This will &ldquo;squash&rdquo; the logo in half to make it look crisp on retina devices)', 'onioneye'),
	    'section'  => 'title_tagline',
	    'type'     => 'checkbox',
		'settings' => 'oy_is_logo_retina',
	) );
	
	$wp_customize->add_setting('oy_is_search_disabled');
    
    $wp_customize->add_control('oy_ctrl_is_search_disabled', array(
	    'label'    => __('Disable the theme&#8217;s search function?', 'onioneye'),
	    'section'  => 'title_tagline',
	    'type'     => 'checkbox',
		'settings' => 'oy_is_search_disabled',
	) );
	
	/*-----------------------------------------------------------------------------------*/
	/*	Social Networks
	/*-----------------------------------------------------------------------------------*/
    
    $wp_customize->add_section( 'oy_social_networks', array(
	    'title'          => __( 'Social Networks', 'onioneye' ),
	    'priority'       => 50,
	)); 
	
	$wp_customize->add_setting('oy_facebook');
    
    $wp_customize->add_control('oy_ctrl_facebook', array(
	    'label'    => __('FaceBook URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_facebook',
	) );
	
	$wp_customize->add_setting('oy_twitter');
    
    $wp_customize->add_control('oy_ctrl_twitter', array(
	    'label'    => __('Twitter URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_twitter',
	) );
	
	$wp_customize->add_setting('oy_googleplus');
    
    $wp_customize->add_control('oy_ctrl_googleplus', array(
	    'label'    => __('Google Plus URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_googleplus',
	) );
	
	$wp_customize->add_setting('oy_pinterest');
    
    $wp_customize->add_control('oy_ctrl_pinterest', array(
	    'label'    => __('Pinterest URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_pinterest',
	) );
	
	$wp_customize->add_setting('oy_instagram');
    
    $wp_customize->add_control('oy_ctrl_instagram', array(
	    'label'    => __('Instagram URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_instagram',
	) );
	
	$wp_customize->add_setting('oy_youtube');
    
    $wp_customize->add_control('oy_ctrl_youtube', array(
	    'label'    => __('YouTube URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_youtube',
	) );
	
	$wp_customize->add_setting('oy_vimeo');
    
    $wp_customize->add_control('oy_ctrl_vimeo', array(
	    'label'    => __('Vimeo URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_vimeo',
	) );
	
	$wp_customize->add_setting('oy_tumblr');
    
    $wp_customize->add_control('oy_ctrl_tumblr', array(
	    'label'    => __('Tumblr URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_tumblr',
	) );
	
	$wp_customize->add_setting('oy_linkedin');
    
    $wp_customize->add_control('oy_ctrl_linkedin', array(
	    'label'    => __('Linkedin URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_linkedin',
	) );
	
	$wp_customize->add_setting('oy_soundcloud');
    
    $wp_customize->add_control('oy_ctrl_soundcloud', array(
	    'label'    => __('SoundCloud URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_soundcloud',
	) );
	
	$wp_customize->add_setting('oy_behance');
    
    $wp_customize->add_control('oy_ctrl_behance', array(
	    'label'    => __('Behance URL', 'onioneye'),
	    'section'  => 'oy_social_networks',
	    'type'     => 'text',
		'settings' => 'oy_behance',
	) );
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Contact Details
	/*-----------------------------------------------------------------------------------*/
    
    $wp_customize->add_section( 'oy_contact_details', array(
	    'title'          => __( 'Contact Details', 'onioneye' ),
	    'priority'       => 60,
	)); 
	
	$wp_customize->add_setting('oy_email');
    
    $wp_customize->add_control('oy_ctrl_email', array(
	    'label'    => __('Email', 'onioneye'),
	    'section'  => 'oy_contact_details',
	    'type'     => 'text',
		'settings' => 'oy_email',
	) );
	
	$wp_customize->add_setting('oy_telephone');
    
    $wp_customize->add_control('oy_ctrl_telephone', array(
	    'label'    => __('Telephone', 'onioneye'),
	    'section'  => 'oy_contact_details',
	    'type'     => 'text',
		'settings' => 'oy_telephone',
	) );
	
	
	/*-----------------------------------------------------------------------------------*/
	/*	Blog Settings
	/*-----------------------------------------------------------------------------------*/
	
	$wp_customize->add_section( 'oy_blog', array(
	    'title'          => __( 'Blog Settings', 'onioneye' ),
	    'priority'       => 70,
	)); 
	
	$wp_customize->add_setting('oy_sidebar_enabled');
    
    $wp_customize->add_control('oy_ctrl_sidebar', array(
	    'label'    => __('Enable Sidebar on the Blog?', 'onioneye'),
	    'section'  => 'oy_blog',
	    'type'     => 'checkbox',
		'settings' => 'oy_sidebar_enabled',
	));
	
	$wp_customize->add_setting('oy_post_content');
	
	$wp_customize->add_control( 'oy_ctrl_post_content', array(
    'label'      => __('Show Excerpt or the Whole Post?', 'onioneye'),
    'section'    => 'oy_blog',
    'settings'   => 'oy_post_content',
    'type'       => 'radio',
    'choices'    => array(
        'excerpt' => __('Post Excerpt', 'onioneye'),
        'full' => __('Full Content', 'onioneye'),
        ),
	));
	
} 

?>
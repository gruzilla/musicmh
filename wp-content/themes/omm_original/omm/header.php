<!DOCTYPE html>
<!--[if(IE 9)&!(IEMobile)]> <html <?php language_attributes(); ?> class="no-js ie9 oldie"> <![endif]-->
<!--[if (lt IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	
	<!-- title -->	
	<title>
		<?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;
		wp_title( '-', true, 'right' );
		// Add the blog name.
		bloginfo( 'name' );
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' - ' . sprintf( __( 'Page %s', 'onioneye' ), max( $paged, $page ) );
		?>
	</title>
	
	<!-- meta tags -->	
	<meta name="description" content="<?php bloginfo( 'description' ); ?>" />
	<meta name="author" content="OnionEye">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, minimal-ui" />
			
  	<!-- RSS and pingback -->
  	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		
	<!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end of wordpress head -->	
</head>

<body <?php body_class(); ?>>

	<?php $tagline = get_option('blogdescription', ''); ?>
	<?php $locations = get_nav_menu_locations(); ?>
	<?php count($locations) ? $is_menu_existent = $locations['main'] : $is_menu_existent = false; ?>
	<?php $main_logo_url = get_theme_mod('oy_logo', ''); ?>
	<?php $is_logo_retina = get_theme_mod('oy_is_logo_retina', ''); ?>
	<?php $terms = get_terms('portfolio_category'); ?>
	<?php $category_count = count($terms); ?>
	<?php $email = get_theme_mod('oy_email', ''); ?>
	<?php $telephone = get_theme_mod('oy_telephone', ''); ?>
	<?php $is_social_existent = oy_is_social_existent(); ?>
	<?php $is_search_disabled = get_theme_mod('oy_is_search_disabled', false); ?>
	
	<?php // Display the menu for mobile, if the menu, or the categories exists ?>			
	<?php if($is_menu_existent || $category_count || $is_social_existent) { ?>
		<div class="dropdown-container">
			<div class="close-button">×</div>
			<div class="dropdown-content">
								
				<div class="mobile-menu">
					<?php if($is_menu_existent) { ?>														
						<?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => 'nav', 'menu' => 'custom_menu', 'container_class' => 'group', 'depth' => 2, 'walker' => new Nfr_Menu_Walker() ) ); ?>
					<?php } ?>
						
					<?php if($category_count) { ?>
					
						<?php get_template_part('includes/portfolio-filter'); ?>
						
					<?php } ?>
					
					<?php if($is_social_existent) { ?>
						
						<?php get_template_part('includes/social'); ?>
						
					<?php } ?>
				</div><!-- /.mobile-menu -->
			</div><!-- /.dropdown-content -->
		</div><!-- /.dropdown-container -->
	<?php } ?>		
	
	<div class="main-container group">	
		
		<?php if($is_menu_existent || $category_count || $is_social_existent || !$is_search_disabled) { ?>
			<div class="header-buttons <?php echo ($is_menu_existent || $category_count || $is_social_existent) ? 'menu-and-search' : 'search-only'; ?>">	
				<?php get_template_part('includes/search-form-mobile'); ?>
				<?php if(!$is_search_disabled) { ?>
					<div class="search-button"></div>
				<?php } ?>
				<?php if($is_menu_existent || $category_count || $is_social_existent) { ?>
					<div class="menu-button"></div>
				<?php } ?>
			</div><!-- /.header-buttons -->
		<?php } ?>	
		
		<div class="full-height group">
			
			<header class="header">
			
				<div class="logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						
						<?php if($main_logo_url && $is_logo_retina) { ?>
											
							<?php 
								$image_details = wp_get_attachment_image_src( oy_get_attachment_id_from_src( $main_logo_url ), 'full');
													
								// If the dimensions of the image are correctly returned, calculate half of its width and height. 
								if($image_details[1] && $image_details[2]) { 
									$image_half_width = round($image_details[1] / 2);
									$image_half_height = round($image_details[2] / 2);
								}
							?>
									
							<img src="<?php echo $image_details[0]; ?>" alt="<?php esc_attr_e( 'Site Logo', 'onioneye' ); ?>" width="<?php echo $image_half_width; ?>" 
							height="<?php echo $image_half_height ?>">
												
						<?php } else if($main_logo_url) { ?>
											
							<img src="<?php echo $main_logo_url; ?>" alt="<?php esc_attr_e( 'Site Logo', 'onioneye' ); ?>">
												
						<?php } else { ?>
											
							<span class="textual-logo"><?php echo get_option( 'blogname' ); ?></span>
												
						<?php } ?>	
								
					</a>
				</div><!-- /.logo -->
				
				<?php if($tagline) { ?>
					<p class="tagline">
						<?php echo $tagline; ?>
					</p>
				<?php } ?>
				
				<?php if(!$is_search_disabled) { ?>
					<div class="search-container sep">					 
						<?php get_template_part('includes/search-form'); ?>
					</div>
				<?php } ?>
				
				<?php if ($is_menu_existent) { ?>
				
					<p class="header-title"><?php _e( 'Menu', 'onioneye' ); ?></p>
								
					<?php wp_nav_menu( array( 'theme_location' => 'main', 'container' => 'nav', 'menu' => 'custom_menu', 'container_class' => 'group', 'menu_class' => 'menu sep', 'depth' => 2, 'walker' => new Nfr_Menu_Walker() ) ); ?>
					
				<?php } ?>
				
				<?php if($category_count) { ?>
					
					<?php get_template_part('includes/portfolio-filter'); ?>
					
				<?php } ?>
				
				<?php if($is_social_existent) { ?>
					
					<?php get_template_part('includes/social'); ?>
					
				<?php } ?>
				
				<?php if($telephone || $email) { ?>
					<ul class="contact-info sep">
						<?php if($telephone) { ?><li><a href="tel:<?php echo $telephone; ?>" class="tel-link" itemprop="telephone"><?php echo $telephone; ?></a></li><?php } ?>
						<?php if($email) { ?><li><a href="mailto:<?php echo $email; ?>" class="mail-link" itemprop="email"><?php echo $email; ?></a></li><?php } ?>
					</ul>
				<?php } ?>
				
				<p class="copyright">
					<small><?php printf(__('&copy; %1$s %2$s. All rights reserved.', 'onioneye'), date("Y"), get_bloginfo('name')); ?></small>
				</p>
								
			</header><!-- /.header --> 
								
			<div class="main-content group">	
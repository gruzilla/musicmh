<?php $facebook_url = get_theme_mod('oy_facebook', ''); ?>		
<?php $twitter_url = get_theme_mod('oy_twitter', ''); ?>		
<?php $googleplus_url = get_theme_mod('oy_googleplus', ''); ?>		
<?php $pinterest_url = get_theme_mod('oy_pinterest', ''); ?>		
<?php $instagram_url = get_theme_mod('oy_instagram', ''); ?>		
<?php $youtube_url = get_theme_mod('oy_youtube', ''); ?>		
<?php $vimeo_url = get_theme_mod('oy_vimeo', ''); ?>	
<?php $tumblr_url = get_theme_mod('oy_tumblr', ''); ?>
<?php $linkedin_url = get_theme_mod('oy_linkedin', ''); ?>
<?php $soundcloud_url = get_theme_mod('oy_soundcloud', ''); ?>
<?php $behance_url = get_theme_mod('oy_behance', ''); ?>

<p class="header-title"><?php _e( 'Social', 'onioneye' ); ?></p>		
	
<ul class="social-networking sep group">
					
	<?php if($facebook_url) { ?>
		<li><a target="_blank" class="facebook-link" href="<?php echo esc_url($facebook_url); ?>"><?php esc_attr_e('FaceBook', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($twitter_url) { ?>
		<li><a target="_blank" class="twitter-link" href="<?php echo esc_url($twitter_url); ?>"><?php esc_attr_e('Twitter', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($googleplus_url) { ?>
		<li><a target="_blank" class="googleplus-link" href="<?php echo esc_url($googleplus_url); ?>"><?php esc_attr_e('Google Plus', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($pinterest_url) { ?>
		<li><a target="_blank" class="pinterest-link" href="<?php echo esc_url($pinterest_url); ?>"><?php esc_attr_e('Pinterest', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($instagram_url) { ?>
		<li><a target="_blank" class="instagram-link" href="<?php echo esc_url($instagram_url); ?>"><?php esc_attr_e('Instagram', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($youtube_url) { ?>
		<li><a target="_blank" class="youtube-link" href="<?php echo esc_url($youtube_url); ?>"><?php esc_attr_e('YouTube', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($vimeo_url) { ?>
		<li><a target="_blank" class="vimeo-link" href="<?php echo esc_url($vimeo_url); ?>"><?php esc_attr_e('Vimeo', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($tumblr_url) { ?>
		<li><a target="_blank" class="tumblr-link" href="<?php echo esc_url($tumblr_url); ?>"><?php esc_attr_e('Tumblr', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($linkedin_url) { ?>
		<li><a target="_blank" class="linkedin-link" href="<?php echo esc_url($linkedin_url); ?>"><?php esc_attr_e('LinkedIn', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($soundcloud_url) { ?>
		<li><a target="_blank" class="soundcloud-link" href="<?php echo esc_url($soundcloud_url); ?>"><?php esc_attr_e('SoundCloud', 'onioneye'); ?></a></li>
	<?php } ?>
	<?php if($behance_url) { ?>
		<li><a target="_blank" class="behance-link" href="<?php echo esc_url($behance_url); ?>"><?php esc_attr_e('Behance', 'onioneye'); ?></a></li>
	<?php } ?>
	
</ul><!-- /.social-networking -->
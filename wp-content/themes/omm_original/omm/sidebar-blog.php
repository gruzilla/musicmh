<aside class="sidebar sidebar-blog group">
	<ul>
		<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
			
			<?php dynamic_sidebar( 'sidebar-blog' ); ?>
			
		<?php else : ?>
			
			<li><h4 class="sub"><?php _e( 'Widgetized Area' , 'onioneye' ); ?></h4></li>
			<li><p><?php printf(__( 'Go to Appearance &raquo; Widgets tab to overwrite this section. Use any widgets that fits you best. This is called %1$sSidebar - Blog%2$s.', 'onioneye'), '<strong>', '</strong>'); ?></p></li>
			
		<?php endif; ?>
	</ul>
</aside><!-- .sidebar -->

<?php $terms = get_terms('portfolio_category'); ?>
<?php $category_count = count($terms); ?>
	
<?php // Display the category filter, if at least one category exists. ?>
<?php if ($category_count) { ?>

	<p class="header-title"><?php _e( 'Filter', 'onioneye' ); ?></p>					
				
	<ul class="portfolio-filter sep group">
										
		<?php
		$all_link = '#';
					
		// Find the link to the portfolio page, if the current page isn't the portfolio page itself, or a single portfolio item
		if(!is_page_template('template-portfolio.php') || !is_page_template('single-portfolio.php')) {
			$pages = get_pages(array(
				'meta_key' => '_wp_page_template',
				'meta_value' => 'template-portfolio.php',
				'hierarchical' => 0
			));
			foreach($pages as $page){
				$all_link = get_page_link( $page->ID );
				break;
			}
		}
		?>
						
		<li <?php if(!is_tax() && (is_page_template('template-portfolio.php') || is_page_template('single-portfolio.php'))) { ?>class="active"<?php } ?>>
			<a href="<?php echo $all_link ?>" data-filter="*" class="filter-all group" title="<?php esc_attr_e( 'View all items', 'onioneye' ); ?>"><?php _e( 'All', 'onioneye' ); ?></a>
		</li>
								
		<?php foreach ( $terms as $term ) { ?>
					
			<?php 
				//Always check if it's an error before continuing. get_term_link() can be finicky sometimes
				$term_link = get_term_link( $term, 'portfolio_category' );
							
				if(is_wp_error($term_link))
					continue;
			?>
							
				<li <?php if(get_queried_object()->slug == $term->slug) { ?>class="active"<?php } ?>>
					<a href="<?php echo $term_link ?>" data-filter=".<?php echo $term->slug; ?>" class="filter-<?php echo $term->slug; ?> group">
						<?php echo $term->name; ?>
					</a>
				</li>
															
		<?php } ?>
					
	</ul><!-- /.portfolio-filter -->
					
<?php } ?>
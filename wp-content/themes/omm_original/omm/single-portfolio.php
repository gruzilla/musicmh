<?php get_header(); ?>
		
	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			
		<?php $terms = get_the_terms( $post->ID , 'portfolio_category', 'string' ); ?>
		<?php $num_of_terms = count($terms); ?>
        <?php $is_pub_date_displayed = get_post_meta( $post->ID, 'onioneye_publication_date', true ); ?>
        <?php $client = get_post_meta( $post->ID, 'onioneye_client', true ); ?>
		<?php $project_url = get_post_meta( $post->ID, 'onioneye_item_url', true ); ?>
		
		<div class="single-portfolio-container group">
			<h1 class="item-title post-title"><?php the_title(); ?></h1>	        
			
			<section class="the-content single-item group">
				<?php the_content(); ?>
			</section><!-- /.single-item -->
			
			<?php 
			    $no_of_columns = 0; 
			    
			    if($is_pub_date_displayed) {
					$no_of_columns++;  
			    }
				if($terms) {
					$no_of_columns++; 	
				}
				if($client) {
					$no_of_columns++;
				}
				if($project_url) {
					$no_of_columns++;
				}
			?>
			
			<div class="project-meta group <?php echo 'oy-' . $no_of_columns . '-cols'; ?>">
		         
		        <?php if($is_pub_date_displayed) { ?>
		        
			        <div class="meta-column">
			           	<strong class="caps"><?php _e( 'Date', 'onioneye' ); ?><span class="colon">:</span></strong>
						<span><?php echo mysql2date( __( 'F Y', 'onioneye' ), $post->post_date ); ?></span>
					</div>
				
				<?php } ?>
		          
				<?php if($terms) { ?>	
		          
		         	<div class="meta-column">
			           	<strong class="caps"><?php _e( 'Skills', 'onioneye' ); ?><span class="colon">:</span></strong>
						<span>
							<?php 
								$i = 0;
		
								foreach($terms as $term) {
			
									if($i + 1 == $num_of_terms) {
			    						echo $term -> name;
			 						}
									else {
										echo $term -> name . ', ';
									}
										
									$i++;
								}
							?>
						</span>
					</div>
			          	
				<?php } ?>
		          
				<?php if($client) { ?>
					<div class="meta-column">
			       		<strong class="caps"><?php _e( 'Client', 'onioneye' ); ?><span class="colon">:</span></strong>
				  		<span><?php echo $client; ?></span> 
				  	</div>
			  	<?php } ?>
		          
			  	<?php if($project_url) { ?>
				  	<div class="meta-column">
			           	<a class="url-button" href="<?php echo esc_url($project_url); ?>"><?php _e( 'Visit site', 'onioneye' ); ?></a> 
					</div>
				<?php } ?>
		          
			</div><!-- /.project-meta -->
			
		</div><!-- /.single-portfolio-container -->
        
    <?php endwhile; ?>
    
    <?php get_template_part('includes/portfolio'); ?>
    				
<?php get_footer(); ?>
<?php get_header(); ?>

	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php

        switch ($post->post_type) {
            case 'mmtile':
                $terms = get_the_terms( $post->ID , 'mmtile_category', 'string' );
                $num_of_terms = count($terms);
                $is_pub_date_displayed = get_post_meta( $post->ID, 'onioneye_publication_date', true );
                $soundcloud_url = get_post_meta( $post->ID, 'onioneye_soundcloud', true );
                $gumroad_url = get_post_meta( $post->ID, 'onioneye_gumroad', true );
                $bpm = get_post_meta( $post->ID, 'onioneye_bpm', true );
                $color = get_post_meta( $post->ID, 'onioneye_color', true );
                break;
            case 'mmimagetile':
                $image0 = get_post_meta( $post->ID, 'onioneye_image0', true );
                $image1 = get_post_meta( $post->ID, 'onioneye_image1', true );
                $image2 = get_post_meta( $post->ID, 'onioneye_image2', true );
                break;
        }
        ?>

		<div class="single-mmtile-container group">
			<h1 class="item-title post-title"><?php the_title(); ?></h1>

			<section class="the-content single-item group">
				<?php the_content(); ?>
			</section><!-- /.single-item -->

            <?php if($image0 || $image1 || $image3) { ?>
                <div class="mm-gallery">
                    <?php if ($image0) { ?><img src="<?php echo $image0; ?>"><? } ?>
                    <?php if ($image1) { ?><img src="<?php echo $image1; ?>"><? } ?>
                    <?php if ($image2) { ?><img src="<?php echo $image2; ?>"><? } ?>
                </div>
            <? }?>

			<?php if($soundcloud_url) { ?>
			<iframe width="100%" height="166" scrolling="no" frameborder="no" class="soundcloud" src="<?php
				$urlParams = array(
					'url' => $soundcloud_url,
					'auto_play' => 'false',
					'hide_related' => 'true',
					'show_comments' => 'false',
					'show_user' => 'true',
					'show_reposts' => 'false',
					'visual' => 'false',
					'color' => 'ff5500',
					'sharing' => 'false',
					'show_playcount' => 'false',
					'show_artwork' => 'false'
				);

				$q = array();
				foreach ($urlParams as $key => $val) {
					$q[] = $key . '=' . urlencode($val);
				}

				echo 'https://w.soundcloud.com/player/?'.
					join('&amp;', $q);
			?>"></iframe>
			<?php } ?>


			<?php if($gumroad_url) { ?>
			<a href="<?php echo $gumroad_url ?>" class="gumroad-button">Buy my product</a>
			<?php } ?>

			<?php
				$no_of_columns = 0;

				if($is_pub_date_displayed) {
					$no_of_columns++;
				}
				if($terms) {
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
						<strong class="caps"><?php _e( 'Genres', 'onioneye' ); ?><span class="colon">:</span></strong>
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

				<?php if ($bpm) { ?>
					<div class="meta-column">
						<strong class="caps"><?php _e( 'BPM', 'onioneye' ); ?><span class="colon">:</span></strong>
						<span><?php echo $bpm; ?></span>
					</div>
				<?php } ?>

				<?php if ($color) { ?>
					<div class="meta-column">
						<strong class="caps"><?php _e( 'Color', 'onioneye' ); ?><span class="colon">:</span></strong>
						<span><?php echo $color; ?></span>
					</div>
				<?php } ?>

			</div><!-- /.project-meta -->

		</div><!-- /.single-mmtile-container -->

	<?php endwhile; ?>

	<?php get_template_part('includes/mmtile'); ?>

<?php get_footer(); ?>
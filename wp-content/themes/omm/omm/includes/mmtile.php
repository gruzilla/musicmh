<?php
	$desired_width = 600;
	$desired_height = 600;

	if(is_tax()) { // is category page
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$args = array( 'post_type' => array('mmtile', 'mmimagetile'), 'mmtile_category' => $term -> slug, 'posts_per_page' => -1, 'orderby' => 'menu_order' );
	}
	else { // is main mmtile page
		$args = array( 'post_type' => array('mmtile', 'mmimagetile'), 'posts_per_page' => -1, 'orderby' => 'menu_order' );
	}

   	$loop = new WP_Query( $args );

	if($loop->have_posts()) {
?>

	<div class="pf-gallery-container">
		<div class="pf-adjuster">
			<div id="isotope-trigger" class="mmtile-gallery group">

				<?php
				//output the latest projects from the 'my_mmtile' custom post type
				while ($loop->have_posts()) {
                    $loop->the_post();
					$preview_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full-size' );
					$preview_img_url = $preview_img['0'];
					$image_full_width = $preview_img[1];
					$image_full_height = $preview_img[2];
				?>

					<div data-id="id-<?php echo $post->ID; ?>" class="isotope-item mmtile-item mmtile-item-<?php the_ID(); ?> <?php $terms = get_the_terms( $post -> ID, 'mmtile_category' ); if ( !empty( $terms ) ) { foreach( $terms as $term ) { echo $term -> slug . ' '; } } ?>">

						<div class="project-link" style="cursor: pointer" onclick="this.classList.toggle('tile-flip-hover')">

                            <?php

                            switch ($post->post_type) {
                                case 'mmtile':
                                    $num_of_terms = count($terms);
                                    $is_pub_date_displayed = get_post_meta( $post->ID, 'onioneye_publication_date', true );
                                    $soundcloud_url = get_post_meta( $post->ID, 'onioneye_soundcloud', true );
                                    $gumroad_url = get_post_meta( $post->ID, 'onioneye_gumroad', true );
                                    $bpm = get_post_meta( $post->ID, 'onioneye_bpm', true );
                                    $color = get_post_meta( $post->ID, 'onioneye_color', true );
                                    break;
                                case 'mmimagetile':
                                    $switchspeed = get_post_meta( $post->ID, 'onioneye_switchspeed', true );
                                    if (is_numeric($switchspeed)) {
                                        $switchspeed = intval($switchspeed);
                                    } else {
                                        $switchspeed = 5000;
                                    }
                                    $animationDuration = ceil($switchspeed / 5);
                                    $image0 = get_post_meta( $post->ID, 'onioneye_image0', true );
                                    $image1 = get_post_meta( $post->ID, 'onioneye_image1', true );
                                    $image2 = get_post_meta( $post->ID, 'onioneye_image2', true );
                                    break;
                            }

                            if ($image0 || $image1 || $image2) {
                            ?>
                                <div class="thumb_container">
                                    <div class="front">
                                        <div id="mm-gallery-<?php echo $post->ID ?>" class="mm-gallery">
                                            <?php
                                            if ($image0) {
                                                $thumb = oy_get_attachment_id_from_src( $image0 );
                                                $thumbInfo = wp_get_attachment_image_src($thumb, 'full');
                                                $image0_full_width = $thumbInfo[1];
                                                $image0_full_height = $thumbInfo[2];

                                                $url = $image0;
                                                if ( $image0_full_width > $desired_width || $image0_full_height > $desired_height ) {
                                                    $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
                                                    $url = $image['url'];
                                                }
                                                echo '<img class="preview-img" src="' . $url . '" alt="' . the_title('', '', false) . '" style="display:block" />';
                                            }
                                            if ($image1) {
                                                $thumb = oy_get_attachment_id_from_src( $image1 );
                                                $thumbInfo = wp_get_attachment_image_src($thumb, 'full');
                                                $image1_full_width = $thumbInfo[1];
                                                $image1_full_height = $thumbInfo[2];

                                                $url = $image1;
                                                if ( $image1_full_width > $desired_width || $image1_full_height > $desired_height ) {
                                                    $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
                                                    $url = $image['url'];
                                                }
                                                echo '<img class="preview-img" src="' . $url . '" alt="' . the_title('', '', false) . '" />';
                                            }
                                            if ($image2) {
                                                $thumb = oy_get_attachment_id_from_src( $image2 );
                                                $thumbInfo = wp_get_attachment_image_src($thumb, 'full');
                                                $image2_full_width = $thumbInfo[1];
                                                $image2_full_height = $thumbInfo[2];

                                                $url = $image2;
                                                if ( $image2_full_width > $desired_width || $image2_full_height > $desired_height ) {
                                                    $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
                                                    $url = $image['url'];
                                                }
                                                echo '<img class="preview-img" src="' . $url . '" alt="' . the_title('', '', false) . '" />';
                                            }
                                            ?>
                                        </div>
                                        <script>
                                            (function($) {
                                                window.setInterval(function() {
                                                    var $imgs = $('#mm-gallery-<?php echo $post->ID ?> img');
                                                    var visImg = Math.max(0, $('#mm-gallery-<?php echo $post->ID ?> img:visible').index());
                                                    var index = (visImg + 1) % $imgs.length;

                                                    $($imgs.get(visImg)).css({
                                                        'z-index': 1,
                                                        'position': 'absolute',
                                                        'top': 0,
                                                        'left': 0
                                                    }).fadeOut(<?php echo $animationDuration; ?>, function() {
                                                        $(this).css({
                                                            'z-index': '',
                                                            'position': '',
                                                            'top': '',
                                                            'left': ''
                                                        });
                                                    });
                                                    $($imgs.get(index)).show();
                                                }, <?php echo $switchspeed; ?>);
                                            })(jQuery);
                                        </script>
                                    </div>
                                </div>
                            <?php
                            }

                            $genre = null;
                            if (is_array($terms)) {
                                foreach($terms as $term) {
                                    if ($term -> parent && strtolower(get_term($term->parent, 'mmtile_category')->name) == 'genre') {
                                        $genre .= $term->name . ' ';
                                    }
                                }
                            }

                            if ($preview_img_url) { ?>

								<div class="thumb-container">
									<?php
										$thumb = oy_get_attachment_id_from_src( $preview_img_url );
										$image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
									?>

									<div class="front">
										<div>
											<?php // If the original width of the thumbnail doesn't match the width of the slider, resize it; otherwise, display it in original size ?>
											<?php if( $image_full_width > $desired_width || $image_full_height > $desired_height ) { ?>

												<img class="preview-img" src="<?php echo $image[url]; ?>" alt="<?php the_title(); ?>" />

											<?php } else { ?>

												<img class="preview-img" src="<?php echo $preview_img_url; ?>" alt="<?php the_title(); ?>" />

											<?php } ?>
										</div><!-- /.preview-img-wrap -->

										<?php
											$addCss = '';
											if ($color) {
												$dec = hex2rgb($color);
												$addCss = 'background-color: rgba('.join(',', $dec) . ', 0.7)';
											}
										?>
										<div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; <?php echo $addCss; ?>"></div>

										<h3 class="project-title caps" style="top: 40%; opacity:1; color: white; font-size:1.75rem; font-family:'Teko','Open Sans',sans-serif">
											<a href="<?php the_permalink(); ?>" style="color:#fff"><?php the_title(); ?></a><br />
											<span style="font-weight:400; font-size: 1.25rem;"><?php echo $genre ? $genre . ' - ' : ''; echo $bpm ?> BPM</span>
										</h3>
									</div>
									<div class="player" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-align: center; background-color: #fff;">
										<?php if($soundcloud_url) { ?>
										<iframe width="80%" height="166" scrolling="no" frameborder="no" style="margin: 20% auto auto" src="<?php
											$urlParams = array(
												'url' => $soundcloud_url,
												'auto_play' => 'false',
												'hide_related' => 'true',
												'show_comments' => 'false',
												'show_user' => 'true',
												'show_reposts' => 'false',
												'visual' => 'false',
												'color' => $color ? $color : 'ff5500',
												'sharing' => 'false',
												'show_playcount' => 'false'
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
									</div>

								</div><!-- /.thumb-container -->

							<?php } ?>

						</div><!-- /.project-link -->

					</div><!-- /.mmtile-item -->

				<?php } ?>

			</div><!-- /#isotope-trigger -->
		</div><!-- /.pf-adjuster -->
	</div><!-- /.pf-gallery-container -->
	<script>
		/*
		(function($) {
			$('.project-link').on('click tap', function(event) {
				event.preventDefault();
				event.stopPropagation();

				var showPlayer = $(this).data('showPlayer');

				if (showPlayer) {
					$(this).find('h3').show();
					console.debug($(this).find('.player'));
					$(this).find('.player').hide();
					$(this).data('showPlayer', false);
				} else {
					$(this).find('h3').hide();
					console.debug(this);
					console.debug($(this).find('.player').length);
					$(this).find('.player').show();
					$(this).data('showPlayer', true);
				}
			});
		})(jQuery);
		/* */
	</script>

<?php } // end if ?>
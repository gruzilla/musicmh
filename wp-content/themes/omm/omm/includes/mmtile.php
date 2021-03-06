<?php
	$desired_width = 600;
	$desired_height = 600;

	if(is_tax()) { // is category page
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$args = array( 'post_type' => 'mmtile', 'mmtile_category' => $term -> slug, 'posts_per_page' => -1, 'orderby' => 'menu_order' );
	}
	else { // is main mmtile page
		$args = array( 'post_type' => 'mmtile', 'posts_per_page' => -1, 'orderby' => 'menu_order' );
	}

    $loop = new WP_Query( $args );

    $args2 = array( 'post_type' => 'mmimagetile', 'posts_per_page' => -1, 'orderby' => 'menu_order' );

    $loop2 = new WP_Query($args2);


	if ($loop->have_posts()) {
?>

	<div class="pf-gallery-container">
		<div class="pf-adjuster">
			<div id="isotope-trigger" class="mmtile-gallery group">

				<?php
				//output the latest projects from the 'my_mmtile' custom post type
                $morePosts = $loop2->have_posts();
                for ($i = 0; $i < $loop->post_count + $loop2->post_count; $i++) {

                    $morePosts = $morePosts && $loop2->have_posts();
                    $whichLoop = '0';
                    if (1 === ($i % 2) && $morePosts) {
                        $loop2->the_post();
                        $whichLoop = '2';
                    } else {
                        $loop->the_post();
                    }

					$preview_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full-size' );
					$preview_img_url = $preview_img['0'];
					$image_full_width = $preview_img[1];
					$image_full_height = $preview_img[2];

                    $num_of_terms = null;
                    $is_pub_date_displayed = null;
                    $soundcloud_url = null;
                    $gumroad_url = null;
                    $bpm = null;
                    $color = null;
                    $switchspeed = null;
                    $animationDuration = null;
                    $image0 = null;
                    $image1 = null;
                    $image2 = null;
                    $backgroundImage = null;

                    switch ($post->post_type) {
                        case 'mmtile':
                            $num_of_terms = count($terms);
                            $is_pub_date_displayed = get_post_meta( $post->ID, 'onioneye_publication_date', true );
                            $soundcloud_url = get_post_meta( $post->ID, 'onioneye_soundcloud', true );
                            $gumroad_url = get_post_meta( $post->ID, 'onioneye_gumroad', true );
                            $bpm = get_post_meta( $post->ID, 'onioneye_bpm', true );
                            $color = get_post_meta( $post->ID, 'onioneye_color', true );
                            $license = get_post_meta( $post->ID, 'onioneye_license', true );
                            $editable = get_post_meta( $post->ID, 'onioneye_editable', true );

                            $onclick = 'this.classList.toggle(\'tile-flip-hover\')';
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

                            if ($image0) {
                                $thumb = oy_get_attachment_id_from_src( $image0 );
                                $thumbInfo = wp_get_attachment_image_src($thumb, 'full');
                                $image0_full_width = $thumbInfo[1];
                                $image0_full_height = $thumbInfo[2];

                                $url = $image0;
                                if ( $image0_full_width > $desired_width || $image0_full_height > $desired_height ) {
                                    $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
                                    if (is_array($image)) {
                                        $url = $image['url'];
                                    } else {
                                        $url = null;
                                    }
                                }
                                if ($url) {
                                    $image0 = '<img class="preview-img" src="' . $url . '" alt="' . the_title('', '', false) . '" />';
                                } else {
                                    $image0 = null;
                                }
                            }
                            if ($image1) {
                                $thumb = oy_get_attachment_id_from_src( $image1 );
                                $thumbInfo = wp_get_attachment_image_src($thumb, 'full');
                                $image1_full_width = $thumbInfo[1];
                                $image1_full_height = $thumbInfo[2];

                                $url = $image1;
                                if ( $image1_full_width > $desired_width || $image1_full_height > $desired_height ) {
                                    $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
                                    if (is_array($image)) {
                                        $url = $image['url'];
                                    } else {
                                        $url = null;
                                    }
                                }
                                if ($url) {
                                    $image1 = '<img class="preview-img" src="' . $url . '" alt="' . the_title('', '', false) . '" />';
                                } else {
                                    $image1 = null;
                                }
                            }
                            if ($image2) {
                                $thumb = oy_get_attachment_id_from_src( $image2 );
                                $thumbInfo = wp_get_attachment_image_src($thumb, 'full');
                                $image2_full_width = $thumbInfo[1];
                                $image2_full_height = $thumbInfo[2];

                                $url = $image2;
                                if ( $image2_full_width > $desired_width || $image2_full_height > $desired_height ) {
                                    $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );
                                    if (is_array($image)) {
                                        $url = $image['url'];
                                    } else {
                                        $url = null;
                                    }
                                }
                                if ($url) {
                                    $image2 = '<img class="preview-img" src="' . $url . '" alt="' . the_title('', '', false) . '" />';
                                } else {
                                    $image2 = null;
                                }
                            }

                            $backgroundImage = $image2 ? $image2 : ($image1 ? $image1 : $image0);

                            $link = get_post_meta( $post->ID, 'onioneye_link', true );
                            if (empty($link) || strtolower(substr($link, 0, 4)) !== 'http') {
                                $onclick = 'return false;';
                            } else {
                                $onclick = 'window.location.href=\''.htmlspecialchars($link, ENT_QUOTES).'\'';
                            }
                            break;
                    }
                    ?>

					<div data-id="id-<?php echo $post->ID; ?>" class="isotope-item type-<?php echo $post->post_type; ?> mmtile-item mmtile-item-<?php the_ID(); ?> <?php $terms = get_the_terms( $post -> ID, 'mmtile_category' ); if ( !empty( $terms ) ) { foreach( $terms as $term ) { echo $term -> slug . ' '; } } ?>">

						<div class="project-link" style="cursor: pointer" onclick="<?php echo $onclick ?>">

                            <?php
                            if ($image0 || $image1 || $image2) {
                            ?>
                                <div class="thumb_container">
                                    <div class="front">
                                        <div id="mm-gallery-<?php echo $post->ID ?>" class="mm-gallery">
                                            <div class="mm-gallery-bg">
                                                <?php
                                                if ($backgroundImage) {
                                                    echo $backgroundImage;
                                                }
                                                ?>
                                            </div>
                                            <div class="mm-gallery-fg">
                                                <?php
                                                if ($image0) {
                                                    echo $image0;
                                                }
                                                if ($image1) {
                                                    echo $image1;
                                                }
                                                if ($image2) {
                                                    echo $image2;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <script>
                                            (function($) {
                                                window.setInterval(
                                                    function() {
                                                         $lastImg = $('#mm-gallery-<?php echo $post->ID ?> .mm-gallery-fg img:visible:last');
                                                        if (!$lastImg || $lastImg.length === 0) {
                                                            $('#mm-gallery-<?php echo $post->ID ?> .mm-gallery-fg img').show();
                                                            $lastImg = $('#mm-gallery-<?php echo $post->ID ?> .mm-gallery-fg img:visible:last');
                                                        }

                                                        $lastImg.fadeOut(
                                                            <?php echo $animationDuration; ?>
                                                        );
                                                    },
                                                    <?php echo $switchspeed; ?>
                                                );
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

                            if ($preview_img_url) {
                                $thumb = oy_get_attachment_id_from_src( $preview_img_url );
                                $image = vt_resize( $thumb, '', $desired_width, $desired_height, true );

                                if (is_array($image) && !empty($image['url'])) {
                                ?>

								<div class="thumb-container music-tile">

									<div class="front">
										<div>
											<?php // If the original width of the thumbnail doesn't match the width of the slider, resize it; otherwise, display it in original size ?>
											<?php if( $image_full_width > $desired_width || $image_full_height > $desired_height ) { ?>

												<img class="preview-img" src="<?php echo $image['url']; ?>" alt="<?php the_title(); ?>" />

											<?php } else { ?>

												<img class="preview-img" src="<?php echo $preview_img_url; ?>" alt="<?php the_title(); ?>" />

											<?php } ?>
										</div><!-- /.preview-img-wrap -->

										<?php
                                            $addCss = '';
                                            $addCssFull = '';
											if ($color) {
												$dec = hex2rgb($color);
                                                $addCss = 'background-color: rgba('.join(',', $dec) . ', 0.7)';
                                                $addCssFull = 'background-color: rgba('.join(',', $dec) . ', 1)';
											}
										?>
										<div class="project-background" style="<?php echo $addCss; ?>"></div>

										<h3 class="project-title caps">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br />
											<span><?php echo $genre ? $genre . ' - ' : ''; echo $bpm ?> BPM</span>
										</h3>

                                        <div class="project-play">
                                            <div class="dummy"></div>

                                            <div class="img-container">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/play.png">
                                            </div>
                                        </div>
									</div>
									<div class="player" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-align: center; <?php echo $addCssFull; ?>">
                                        <div class="vert-center">
                                        <h4><?php the_title(); ?></h4>
                                        <div class="genre"><?php echo $genre ? $genre . ' - ' : ''; echo $bpm ?> BPM</div>

										<?php if($soundcloud_url) { ?>
										<iframe width="80%" height="40%" scrolling="no" frameborder="no" style="margin: 0 auto; display:block" class="soundcloud" src="<?php
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


                                        <div style="width: 80%; margin: auto">
                                            <div class="detailinfo">
                                                <?php if ($license) { echo $license . '<br/>'; } ?>
                                                <?php echo ($editable) ? 'Editable' : 'No editing'; ?>
                                            </div>
                                            <?php if($gumroad_url) { ?>
                                                <a href="<?php echo $gumroad_url ?>" class="gumroad-button">Buy my product</a>
                                            <?php } ?>
                                        </div>

                                    </div>
									</div>

								</div><!-- /.thumb-container -->

							<?php }} ?>

						</div><!-- /.project-link -->

					</div><!-- /.mmtile-item -->

				<?php } ?>

			</div><!-- /#isotope-trigger -->
		</div><!-- /.pf-adjuster -->
	</div><!-- /.pf-gallery-container -->
	<script>
		(function($) {
			$('.music-tile').on('click tap', function(event) {
				event.preventDefault();
				event.stopPropagation();

                $(this).find('.player').fadeToggle(500);
			});
		})(jQuery);
	</script>

<?php } // end if ?>
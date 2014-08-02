<?php 

/*-----------------------------------------------------------------------------------*/
/* Find out if the user filled in any of the social networking links in 
/* the theme options.
/*-----------------------------------------------------------------------------------*/

function oy_is_social_existent() {
	$facebook_url = get_theme_mod('oy_facebook', ''); 		
	$twitter_url = get_theme_mod('oy_twitter', ''); 		
    $googleplus_url = get_theme_mod('oy_googleplus', ''); 		
	$pinterest_url = get_theme_mod('oy_pinterest', ''); 		
	$instagram_url = get_theme_mod('oy_instagram', ''); 		
	$youtube_url = get_theme_mod('oy_youtube', ''); 		
	$vimeo_url = get_theme_mod('oy_vimeo', ''); 	
	$tumblr_url = get_theme_mod('oy_tumblr', ''); 
	$linkedin_url = get_theme_mod('oy_linkedin', ''); 
	$soundcloud_url = get_theme_mod('oy_soundcloud', ''); 
	$behance_url = get_theme_mod('oy_behance', ''); 
	
	return ($facebook_url || $twitter_url || $googleplus_url || $pinterest_url || $instagram_url || $youtube_url || $vimeo_url || $tumblr_url ||
	$linkedin_url || $soundcloud_url || $behance_url) ? 1 : 0;		
}


/*-----------------------------------------------------------------------------------*/
/* Get the id of the attachment by providing the source of the image. Needed for
 * finding the image's meta info, such as its width and height.
/*-----------------------------------------------------------------------------------*/

function oy_get_attachment_id_from_src( $image_src ) {
	
	global $wpdb;
	
	$query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	$id = $wpdb->get_var($query);
	
	return $id;
	
}


/*-----------------------------------------------------------------------------------
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 -----------------------------------------------------------------------------------*/
 
function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

	// this is an attachment, so we have the ID
	if ( $attach_id ) {
	
		$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
		$file_path = get_attached_file( $attach_id );
	
	// this is not an attachment, let's use the image url
	} else if ( $img_url ) {
		
		$file_path = parse_url( $img_url );
		$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
		
		//$file_path = ltrim( $file_path['path'], '/' );
		//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
		
		$orig_size = getimagesize( $file_path );
		
		$image_src[0] = $img_url;
		$image_src[1] = $orig_size[0];
		$image_src[2] = $orig_size[1];
	}
	
	$file_info = pathinfo( $file_path );
	$extension = '.'. $file_info['extension'];

	// the image path without the extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	// checking if the file size is larger than the target size
	// if it is smaller or the same size, stop right here and return
	if ( $image_src[1] > $width || $image_src[2] > $height ) {

		// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
		if ( file_exists( $cropped_img_path ) ) {

			$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
			
			$vt_image = array (
				'url' => $cropped_img_url,
				'width' => $width,
				'height' => $height
			);
			
			return $vt_image;
		}

		// $crop = false
		if ( $crop == false ) {
		
			// calculate the size proportionaly
			$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// checking if the file already exists
			if ( file_exists( $resized_img_path ) ) {
			
				$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

				$vt_image = array (
					'url' => $resized_img_url,
					'width' => $proportional_size[0],
					'height' => $proportional_size[1]
				);
				
				return $vt_image;
			}
		}

		// no cache files - let's finally resize it
		// $new_img_path = image_resize( $file_path, $width, $height, $crop );
		$editor = wp_get_image_editor( $file_path );
		if ( is_wp_error( $editor ) )
		    return $editor;
		$editor->set_quality( 90 );
		$resized = $editor->resize( $width, $height, $crop );
		$dest_file = $editor->generate_filename( NULL, NULL );
		$saved = $editor->save( $dest_file );
		if ( is_wp_error( $saved ) )
		    return $saved;
		$new_img_path=$dest_file;

		$new_img_size = getimagesize( $new_img_path );
		$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

		// resized output
		$vt_image = array (
			'url' => $new_img,
			'width' => $new_img_size[0],
			'height' => $new_img_size[1]
		);
		
		return $vt_image;
	}

	// default output - without resizing
	$vt_image = array (
		'url' => $image_src[0],
		'width' => $image_src[1],
		'height' => $image_src[2]
	);
	
	return $vt_image;
}


?>
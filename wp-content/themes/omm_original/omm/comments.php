<?php

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="help">
    	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'onioneye'); ?></p>
  	</div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	
	<h3 id="comments" class="h4">
		<?php
			printf(_n( '%3$sOne%4$s thought on &ldquo;%2$s&rdquo;', '%3$s%1$s%4$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'onioneye' ),
						number_format_i18n( get_comments_number() ), get_the_title(), '<span>', '</span>' );
		?>
	</h3>
	
	<nav id="comment-nav">
		<ul class="group">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
	 	</ul>
	</nav>
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=oy_post_comments'); ?>
	</ol>
	
	<nav id="comment-nav">
		<ul class="group">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
		</ul>
	</nav>
  
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	
	<!-- If comments are closed. -->
	
	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>
	
	<?php 
	
	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'onioneye' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="author" name="author" type="text" placeholder="' . __('Your Name', 'onioneye') . '" tabindex="1" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'onioneye' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		            '<input id="email" name="email" type="text" placeholder="' . __('Your Email', 'onioneye') . '" tabindex="2" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'onioneye' ) . '</label>' .
		            '<input id="url" name="url" type="text" placeholder="' . __('Your Website', 'onioneye') . '" tabindex="3" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
	); 

	$new_defaults = array(
		'fields' => $fields,
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" tabindex="4" placeholder="' . __('Your Comment Here...', 'onioneye') . '"></textarea></p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.', 'onioneye' ) . '</p>',
		'comment_notes_after' => ''
	);
	
	?>
	
	<?php comment_form($new_defaults); ?>

<?php endif; ?>

<form role="search" method="get" id="main-search-form" action="<?php echo esc_url(home_url( '/'  )); ?>">
	<?php $value = __( 'Search&hellip;', 'onioneye' ); ?>
	<input type="text" name="s" id="main-search-field" value="<?php echo $value; ?>" onfocus="if (this.value == '<?php echo $value; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $value; ?>';}" />
	<input type="submit" id="main-search-submit" value="" />
</form>

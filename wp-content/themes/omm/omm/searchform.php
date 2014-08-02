<form method="get" class="search-form" action="<?php echo home_url(); ?>">
	<?php $value = __( 'Search&hellip;', 'onioneye' ); ?>
	<input type="text" class="search-field" name="s" id="s"  value="<?php echo $value; ?>" onfocus="if (this.value == '<?php echo $value; ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo $value; ?>';}" />
</form><!-- /.search-form -->


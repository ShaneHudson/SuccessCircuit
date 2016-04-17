
		<?php wp_footer(); ?>
		<script src="<?php echo get_bloginfo('template_directory'); ?>/js/modernizr.js"></script>
		<script>
			Modernizr.load({
  				test: Modernizr['object-fit'],
				nope: "<?php echo get_bloginfo('template_directory'); ?>/js/object-fit.js"
			});
		</script>
	</body>
	</body>
</html>

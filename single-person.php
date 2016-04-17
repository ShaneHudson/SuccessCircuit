<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<section>
		<article>
		    <?php
		        $name = get_the_field('first_name') . " " . get_the_field('last_name');
		        if ($preferred = get_the_field('preferred_name'))  {
                    $name = $preferred;
		        }
			<h1><?php echo $name; ?></h1>
		</article>
	</section>
<?php endwhile; ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

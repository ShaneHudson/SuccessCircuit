<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<section>
		<article>
		    <?php
		        $name = get_field('first_name') . " " . get_field('last_name');
		        if ($preferred = get_field('preferred_name'))  {
                    $name = $preferred;
		        }
		    ?>
			<h1><?php echo $name; ?></h1>
			<?php
                $images = get_field('photos');

                if( $images ): ?>
                    <ul>
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

		</article>
	</section>
<?php endwhile; ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

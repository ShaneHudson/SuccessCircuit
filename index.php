<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ): ?>
<section class="recent">
	<div class="grid-wrapper">
		<?php
			// Primary row
			query_posts( array(
				"posts_per_page" => 4
			));
			while ( have_posts() ) : the_post();
				the_content_box($post->ID);
			endwhile;
			//wp_reset_query(); ?>

			<ul class="widgets">
				<?php dynamic_sidebar('home'); ?>
			</ul>

	</div>
</section>
<?php else: ?>
<h2>No posts to display</h2>
<?php endif; ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer') ); ?>

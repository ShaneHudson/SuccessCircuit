<?php
/**
 * Search results page
 *
 * Please see /external/starkers-utilities.php for info on get_template_parts()
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>
<section class="recent">
	<?php if ( have_posts() ): ?>
	<h1>Search Results for '<?php echo get_search_query(); ?>'</h1>
	<div class="grid-wrapper">
		<?php
		while ( have_posts() ) : the_post();
			the_content_box($post->ID);
		endwhile; ?>
	</div>
	<?php else: ?>
		<h1>No results found for '<?php echo get_search_query(); ?>'</h1>
	<?php endif; ?>
</section>
<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

<?php
/**
 * The template for displaying the Home page.
 *
 * @package 	WordPress
 * @subpackage 	Success Circuit
 */
?>
<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<section class="recent">
  <h1>Recent Interviews</h1>
  <div class="grid-wrapper">
    <?php
      query_posts( array("posts_per_page" => 4, 'ignore_sticky_posts' => 1));
      while ( have_posts() ) : the_post();
        the_content_box($post->ID);
      endwhile;
    ?>
  </div>
</section>

<section class="featured">
  <h1>Featured Interviews</h1>
  <div class="grid-wrapper">
    <?php
      /* Get all Sticky Posts */
      $sticky = get_option( 'sticky_posts' );
      /* Sort Sticky Posts, newest at the top */
      rsort( $sticky );
      /* Get top 4 Sticky Posts */
      $sticky = array_slice( $sticky, 0, 4 );
      query_posts( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1 ) );
      while ( have_posts() ) : the_post();
        the_content_box($post->ID);
      endwhile;
    ?>
  </div>
</section>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

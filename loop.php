<?php
// Secondary row
// query_posts( array(
//	"posts_per_page" => 8
//));

if ( have_posts() ) :
	while ( have_posts() ) {
		the_post();
		the_content_box($post->ID);
	}
endif;

wp_reset_query(); ?>

<?php
// Secondary row
// query_posts( array(
//	"posts_per_page" => 8
//));  

while ( have_posts() ) : the_post();
	the_content_box($post->ID);
endwhile; 
//wp_reset_query(); ?>
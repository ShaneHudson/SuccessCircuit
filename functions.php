<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
 	 * @package 	WordPress
 	 * @subpackage 	Starkers
 	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================

	Required functions files

	======================================================================================================================== */

	require_once( 'functions/starkers-utilities.php' );
	require_once( 'functions/admin.php' );
	require_once( 'functions/widgets.php' );
	require_once( 'functions/menus.php' );

	/* ========================================================================================================================
	Theme specific settings

	Uncomment register_nav_menus to enable a single menu with the title of "Primary Navigation" in your theme

	======================================================================================================================== */

function bidirectional_acf_update_value( $value, $post_id, $field  ) {
	
	// vars
	$field_name = $field['name'];
	$global_name = 'is_updating_' . $field_name;
	
	
	// bail early if this filter was triggered from the update_field() function called within the loop below
	// - this prevents an inifinte loop
	if( !empty($GLOBALS[ $global_name ]) ) return $value;
	
	
	// set global variable to avoid inifite loop
	// - could also remove_filter() then add_filter() again, but this is simpler
	$GLOBALS[ $global_name ] = 1;
	
	
	// loop over selected posts and add this $post_id
	if( is_array($value) ) {
	
		foreach( $value as $post_id2 ) {
			
			// load existing related posts
			$value2 = get_field($field_name, $post_id2, false);
			
			
			// allow for selected posts to not contain a value
			if( empty($value2) ) {
				
				$value2 = array();
				
			}
			
			
			// bail early if the current $post_id is already found in selected post's $value2
			if( in_array($post_id, $value2) ) continue;
			
			
			// append the current $post_id to the selected post's 'related_posts' value
			$value2[] = $post_id;
			
			
			// update the selected post's value
			update_field($field_name, $value2, $post_id2);
			
		}
	
	}
	
	
	// find posts which have been removed
	$old_value = get_field($field_name, $post_id, false);
	
	if( is_array($old_value) ) {
		
		foreach( $old_value as $post_id2 ) {
			
			// bail early if this value has not been removed
			if( is_array($value) && in_array($post_id2, $value) ) continue;
			
			
			// load existing related posts
			$value2 = get_field($field_name, $post_id2, false);
			
			
			// bail early if no value
			if( empty($value2) ) continue;
			
			
			// find the position of $post_id within $value2 so we can remove it
			$pos = array_search($post_id, $value2);
			
			
			// remove
			unset( $value2[ $pos] );
			
			
			// update the un-selected post's value
			update_field($field_name, $value2, $post_id2);
			
		}
		
	}
	
	
	// reset global varibale to allow this filter to function as per normal
	$GLOBALS[ $global_name ] = 0;
	
	
	// return
    return $value;
    
}

add_filter('acf/update_value/name=related_people', 'bidirectional_acf_update_value', 10, 3);

// Register Custom Post Type
function person_post_type() {

	$labels = array(
		'name'                  => _x( 'People', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Person', 'Post Type Singular Name', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Person', 'text_domain' ),
		'description'           => __( 'Person entity', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
                'menu_icon'             => 'dashicons-groups',
	);
	register_post_type( 'person', $args );

}
add_action( 'init', 'person_post_type', 0 );

	add_theme_support('post-thumbnails');

	register_nav_menus(array('primary' => 'Primary Navigation', 'theme_location' => 'header'));
	register_nav_menus(array('footer' => 'Footer Navigation', 'theme_location' => 'footer'));

	function add_to_wp_menu ( $items, $args ) {
		if( 'footer' === $args->theme_location ) {
			$items .= date("Y");
			$items .= "&copy;";
			$items .= bloginfo( 'name' );
			$items .= " All rights reserved.";
		}
		return $items;
	}
	add_filter('wp_nav_menu_items','add_to_wp_menu',10,2);

    register_sidebar(array(
		'name' => 'Home Widgets',
		'id' => 'home',
        'before_title' => '<div class="title">',
        'after_title' => '</div>'
    ));

    function get_colour($post_id)  {
		$options = get_option('sc_categories_fields_option');
		$cat = get_the_category($post_id);
		$cat_id = $cat[0]->term_id;
		if ($cat[0]->term_id == 5 && isset($cat[1]->term_id)) {
			$cat_id = $cat[1]->term_id;
		}
		return $options[$cat_id]['category_colour'];
    }

	function the_content_box($post_id)  { ?>
		<div class="grid one-whole  lap-one-half  desk-one-quarter content-grid">
			<a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title(); ?>" rel="bookmark" class="content-grid__box">
				<?php if (has_post_thumbnail($post_id)) {
					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), "Full");
					$image_url = $image_url[0];
					if ($image_url != '')  { ?>
						<div class="content-grid__img-wrapper"><img src="<?php echo $image_url; ?>" class="content-grid__img" /></div>
					<?php }
					} ?>
				<article class="content-grid__content">
					<h2 class="content-grid__title"><?php the_title(); ?></h2>
					<?php the_excerpt(); ?>
					<time class="content-grid__date" datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
				</article>
			</a>
		</div>
	<?php }


	/*infinite scroll pagination */

	add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user
	add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');    // if user not logged in

	function wp_infinitepaginate(){
	    $loopFile        = $_POST['loop_file'];
	    $paged           = $_POST['page_no'];
	    $posts_per_page  = $_POST['amount'];
	    $cat = $_POST['cat'];



	    if (isset($cat))
	    	query_posts(array('paged' => $paged, 'cat' => $cat,  'post_status' => 'publish', 'ignore_sticky_posts' => 1 ));
	    else
	    	query_posts(array('paged' => $paged,  'post_status' => 'publish', 'ignore_sticky_posts' => 1  ));
	    get_template_part( $loopFile );
			wp_reset_query();
	    exit;
	}

	/* ========================================================================================================================

	Actions and Filters

	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'script_enqueuer' );

	add_filter( 'body_class', 'add_slug_to_body_class' );

	//filter the <p> tags from the images and iFrame
function filter_ptags_on_images($content)
{
$content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

	/* ========================================================================================================================

	Custom Post Types - include custom post types and taxonimies here e.g.

	e.g. require_once( 'custom-post-types/your-custom-post-type.php' );

	======================================================================================================================== */



	/* ========================================================================================================================

	Scripts

	======================================================================================================================== */
	//Making jQuery Google API
	function modify_jquery() {
		if (!is_admin()) {
			// comment out the next two lines to load the local copy of jQuery
			//wp_deregister_script('jquery');
			//wp_register_script('jquery', 'http://code.jquery.com/jquery-latest.min.js', false, '1.8.1');
			wp_enqueue_script('jquery');
		}
	}

	add_action('init', 'modify_jquery');


	/**
	 * Add scripts via wp_head()
	 *
	 * @return void
	 * @author Keir Whitaker
	 */

	function script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/site.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_script( 'social', get_template_directory_uri().'/js/social.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'social' );

		wp_register_style( 'screen', get_template_directory_uri().'/style.css', '', '', 'screen' );
        wp_enqueue_style( 'screen' );

		wp_register_style( 'site', get_template_directory_uri().'/css/style.min.css', '', '', 'screen' );
        wp_enqueue_style( 'site' );
	}

	/* ========================================================================================================================

	Comments

	======================================================================================================================== */

	/**
	 * Custom callback for outputting comments
	 *
	 * @return void
	 * @author Keir Whitaker
	 */
	function starkers_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
		<?php if ( $comment->comment_approved == '1' ): ?>
		<li>
			<article id="comment-<?php comment_ID() ?>">
				<?php comment_text() ?>
				<p class="comment-author"><?php comment_author_link() ?> - <time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
</p>
			</article>
		<?php endif; ?>
		</li>
		<?php
	}

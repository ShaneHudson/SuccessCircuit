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
			<?php
			$cat_colour = get_colour($post_id);?>
			<a href="<?php esc_url( the_permalink() ); ?>" data-colour="<?php echo $cat_colour; ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark" class="content-grid__box custom-bg">
				<?php if (has_post_thumbnail($post_id)) {
					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), "Full");
					$image_url = $image_url[0];
					if ($image_url != '')  { ?>
						<img src="<?php echo $image_url; ?>" class="content-grid__img" />
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
	    $posts_per_page  = get_option('posts_per_page');
	    $cat = $_POST['cat'];
			print $cat;
	    if (isset($cat))
	    	query_posts(array('paged' => $paged, 'cat' => $cat ));
	    else
	    	query_posts(array('paged' => $paged ));
	    get_template_part( $loopFile );
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
				<?php // echo get_avatar( $comment ); ?>
				<h4><?php comment_author_link() ?></h4>
				<time><a href="#comment-<?php comment_ID() ?>" pubdate><?php comment_date() ?> at <?php comment_time() ?></a></time>
				<?php comment_text() ?>
			</article>
		<?php endif; ?>
		</li>
		<?php
	}

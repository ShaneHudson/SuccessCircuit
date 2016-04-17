<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]-->
<!--[if lt IE 7 ]><html class="no-js ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<title><?php wp_title( '|' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"><!-- Remove if you're not building a responsive site. (But then why would you do such a thing?) -->
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico"/>
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-5141559-2']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
		<?php wp_head(); ?>


		<!-- start infinite scroll function  -->

		<?php if (!is_single() && !is_page() && !is_home() && !is_search()):?>

		<script type="text/javascript">
		    jQuery(document).ready(function($) {
		        var page = 2; // Start with the second page
				var hasScrolled = false;
		        var totalPages = <?php echo $wp_query->max_num_pages; ?>;
		        $(window).scroll(function(){
	            if  ($(window).scrollTop() == $(document).height() - $(window).height() && !hasScrolled){
								if (page >= totalPages)  {
									$('footer').show();
								}
								else  {
									hasScrolled = true;
									loadArticle(page);
									page++;
								}
	            }
		        });

		        function loadArticle(pageNumber){
              $.ajax({
                  url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
                  type:'POST',
                  data: "action=infinite_scroll&post_status=publish&page_no=" + pageNumber + "&amount=8&loop_file=loop<?php if(isset($cat)) { echo "&cat=" . $cat; } ?>",
                  success: function(html){
                    $(".grid-wrapper").append(html);    // This will be the div where our content will be loaded
					hasScrolled = false;
					Modernizr.load({
						test: Modernizr['object-fit'],
						nope: "<?php echo get_bloginfo('template_directory'); ?>/js/object-fit.js"
					});
                  }
              });
	            return false;
		        }
		    });
		</script>
		<?php endif; ?>
	</head>
	<body <?php body_class(); ?>>

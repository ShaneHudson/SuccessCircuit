<div class="container">
	<header>
		<a class="header_title" href="/"><span class="first-word">Success</span> <span class="second-word">Circuit</span></a>
			<!--<p class="header_description"><?php bloginfo( 'description' ); ?></p>-->
		<?php get_search_form(); ?>
		<?php wp_nav_menu( array('menu' => 'primary', 'container' => 'nav', 'walker' => new rc_scm_walker() )); ?>
	</header>

<div class="container">
	<header>
		<div class="gw">
			<div class="g lap-one-half desk-two-thirds">
				<a class="header_title" href="/"><?php bloginfo( 'name' ); ?></a>
				<p class="header_description"><?php bloginfo( 'description' ); ?></p>
			</div>
			<div class="g lap-one-third  desk-one-third">
				<?php get_search_form(); ?>
			</div>
		</div>
		<?php wp_nav_menu( array('menu' => 'primary', 'container' => 'nav', 'walker' => new rc_scm_walker() )); ?>
	</header>

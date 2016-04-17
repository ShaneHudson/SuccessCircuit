<?php get_template_parts( array( 'parts/shared/html-header', 'parts/shared/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<section>
		<article>

            <section class="profile__name">
                <?php
                    $name = get_field('first_name') . " " . get_field('last_name');
                    if ($preferred = get_field('preferred_name'))  {
                        $name = $preferred;
                    }
                ?>
                <h1><?php echo $name; ?></h1>
			</section>
            <section class="profile__photos">
			<?php
                $images = get_field('photos');

                if( $images ): ?>
                    <ul>
                        <?php foreach( $images as $image ): ?>
                            <li>
                                <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
            <section class="profile__people">
            <?php
                $people = get_field('related_people');

                if ($people): ?>
                    <ul>
                        <?php foreach( $people as $person ): ?>
                            <li><a href="<?php echo get_permalink( $person->ID ); ?>"><?php echo get_the_title( $person->ID ); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
            <section class="profile__interviews">
                <?php
                    $interviews = get_field('interviews');

                    if ($interviews): ?>
                        <ul>
                            <?php foreach( $interviews as $interview ): ?>
                                <li><a href="<?php echo get_permalink( $interview->ID ); ?>"><?php echo get_the_title( $interview->ID ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
            </section>

		</article>
	</section>
<?php endwhile; ?>

<?php get_template_parts( array( 'parts/shared/footer','parts/shared/html-footer' ) ); ?>

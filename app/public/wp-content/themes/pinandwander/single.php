<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php
    $pw_cats      = get_the_category();
    $pw_region    = ! empty( $pw_cats ) ? $pw_cats[0] : null;
    $pw_has_photo = has_post_thumbnail();
    ?>

    <main id="main" class="site-main trip">

        <header class="trip-hero<?php echo $pw_has_photo ? '' : ' is-placeholder'; ?>" id="hero">
            <?php if ( $pw_has_photo ) : ?>
                <div class="trip-hero-media">
                    <?php the_post_thumbnail( 'full', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
                </div>
            <?php endif; ?>
            <div class="trip-hero-overlay"></div>
            <div class="trip-hero-content">
                <?php if ( $pw_region ) : ?>
                    <a class="trip-kicker" href="<?php echo esc_url( get_category_link( $pw_region ) ); ?>">
                        <?php echo esc_html( $pw_region->name ); ?>
                    </a>
                <?php endif; ?>
                <h1 class="trip-title"><?php the_title(); ?></h1>
                <p class="trip-meta">
                    <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
                </p>
            </div>
        </header>

        <article <?php post_class( 'trip-article' ); ?>>

            <?php if ( has_excerpt() ) : ?>
                <p class="trip-standfirst"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>

            <div class="trip-content">
                <?php
                the_content();

                wp_link_pages( array(
                    'before' => '<nav class="trip-pagelinks">',
                    'after'  => '</nav>',
                ) );
                ?>
            </div>

            <footer class="trip-footer">
                <a class="trip-back" href="<?php echo esc_url( pinandwander_journal_url() ); ?>">
                    <?php esc_html_e( '&larr; All stories', 'pinandwander' ); ?>
                </a>
            </footer>

        </article>

        <?php
        $pw_prev = get_previous_post();
        $pw_next = get_next_post();

        if ( $pw_prev || $pw_next ) :
            ?>
            <nav class="trip-nav" aria-label="<?php esc_attr_e( 'More stories', 'pinandwander' ); ?>">
                <?php
                foreach ( array(
                    'prev' => array( $pw_prev, __( 'Previous story', 'pinandwander' ) ),
                    'next' => array( $pw_next, __( 'Next story', 'pinandwander' ) ),
                ) as $pw_dir => $pw_pair ) :
                    list( $pw_post, $pw_label ) = $pw_pair;
                    if ( ! $pw_post ) {
                        continue;
                    }
                    $pw_thumb = get_the_post_thumbnail_url( $pw_post, 'medium_large' );
                    ?>
                    <a class="trip-nav-link trip-nav-<?php echo esc_attr( $pw_dir ); ?>" href="<?php echo esc_url( get_permalink( $pw_post ) ); ?>">
                        <span class="trip-nav-thumb"<?php echo $pw_thumb ? ' style="background-image:url(' . esc_url( $pw_thumb ) . ')"' : ''; ?>></span>
                        <span class="trip-nav-text">
                            <span class="trip-nav-label"><?php echo esc_html( $pw_label ); ?></span>
                            <span class="trip-nav-title"><?php echo esc_html( get_the_title( $pw_post ) ); ?></span>
                        </span>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

        <?php
        if ( $pw_region ) :
            $pw_related = new WP_Query( array(
                'category__in'        => array( $pw_region->term_id ),
                'post__not_in'        => array( get_the_ID() ),
                'posts_per_page'      => 3,
                'post_status'         => 'publish',
                'ignore_sticky_posts' => true,
                'no_found_rows'       => true,
            ) );

            if ( $pw_related->have_posts() ) :
                ?>
                <section class="trip-related">
                    <h2 class="trip-related-title">
                        <?php
                        printf(
                            /* translators: %s: region name */
                            esc_html__( 'More from %s', 'pinandwander' ),
                            esc_html( $pw_region->name )
                        );
                        ?>
                    </h2>
                    <div class="journal-grid">
                        <?php
                        while ( $pw_related->have_posts() ) :
                            $pw_related->the_post();
                            get_template_part( 'template-parts/journal-card' );
                        endwhile;
                        ?>
                    </div>
                </section>
                <?php
            endif;
            wp_reset_postdata();
        endif;
        ?>

    </main>

<?php endwhile; ?>

<?php get_footer(); ?>

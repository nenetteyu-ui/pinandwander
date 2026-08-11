<?php get_header(); ?>

<main id="main" class="site-main">

    <!-- ================================================
         HERO
         ================================================ -->
    <section class="hero" id="hero">
        <div class="hero-bg" aria-hidden="true">
            <?php
            $pw_hero_slides = pinandwander_hero_slides();
            if ( ! empty( $pw_hero_slides ) ) :
                foreach ( $pw_hero_slides as $pw_i => $pw_url ) :
                    printf(
                        '<div class="hero-slide%1$s" style="background-image:url(%2$s)"></div>',
                        0 === $pw_i ? ' is-active' : '',
                        esc_url( $pw_url )
                    );
                endforeach;
            else :
                // No photos in assets/hero/ yet — show on-brand gradient placeholders.
                echo '<div class="hero-slide hero-slide-1 is-active"></div>';
                echo '<div class="hero-slide hero-slide-2"></div>';
                echo '<div class="hero-slide hero-slide-3"></div>';
            endif;
            ?>
        </div>
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <p class="hero-eyebrow">Travel Advisory &amp; Photography</p>
            <h1 class="hero-title">Pin <span class="amp">&amp;</span> Wander</h1>
            <p class="hero-tagline">Pin the dream, wander the world, and repeat.</p>
            <div class="hero-actions">
                <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( 'Work With Me', 'pinandwander' ); ?>
                </a>
                <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-ghost">
                    <?php esc_html_e( 'Explore the Journal', 'pinandwander' ); ?>
                </a>
            </div>
        </div>

        <div class="hero-scroll" aria-hidden="true">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- ================================================
         RECENT DESTINATIONS
         ================================================ -->
    <section class="section-destinations">

        <div class="section-header">
            <span class="eyebrow">Latest Adventures</span>
            <h2 class="section-title">Recent Destinations</h2>
        </div>

        <div class="destinations-grid">
            <?php
            $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
            );
            $query = new WP_Query( $args );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $categories = get_the_category();
                    $region     = ! empty( $categories ) ? esc_html( $categories[0]->name ) : '';
                    ?>
                    <article class="destination-card">
                        <a href="<?php the_permalink(); ?>" class="card-link">
                            <div class="card-image">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
                                <?php else : ?>
                                    <div class="card-placeholder"></div>
                                <?php endif; ?>
                                <div class="card-meta">
                                    <?php if ( $region ) : ?>
                                        <span class="card-region"><?php echo $region; ?></span>
                                    <?php endif; ?>
                                    <h3 class="card-title"><?php the_title(); ?></h3>
                                </div>
                            </div>
                        </a>
                    </article>
                    <?php
                endwhile;
                wp_reset_postdata();

            else :
                // Placeholder cards when no posts exist yet
                $placeholders = array(
                    array( 'region' => 'Southeast Asia',  'title' => 'Two Weeks in Bali &amp; Beyond' ),
                    array( 'region' => 'Europe',           'title' => 'A Slow Journey Through Portugal' ),
                    array( 'region' => 'South America',    'title' => 'Patagonia: End of the World' ),
                    array( 'region' => 'Africa',           'title' => 'Safari Season in the Serengeti' ),
                    array( 'region' => 'Oceania',          'title' => 'New Zealand&#8217;s South Island' ),
                    array( 'region' => 'Middle East',      'title' => 'Hidden Corners of Jordan' ),
                );
                foreach ( $placeholders as $card ) :
                    ?>
                    <article class="destination-card">
                        <div class="card-link">
                            <div class="card-image">
                                <div class="card-placeholder"></div>
                                <div class="card-meta">
                                    <span class="card-region"><?php echo $card['region']; ?></span>
                                    <h3 class="card-title"><?php echo $card['title']; ?></h3>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php
                endforeach;
            endif;
            ?>
        </div>

        <div class="section-cta">
            <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-outline">
                <?php esc_html_e( 'View All Destinations', 'pinandwander' ); ?>
            </a>
        </div>

    </section>

    <!-- ================================================
         ABOUT TEASER
         ================================================ -->
    <section class="section-about">
        <div class="about-inner">

            <div class="about-image">
                <div class="about-placeholder"></div>
            </div>

            <div class="about-content">
                <span class="eyebrow">About</span>
                <h2 class="section-title">Turning Wanderlust<br>Into Reality</h2>
                <p class="about-text">
                    As a travel advisor and photographer, I craft bespoke journeys for those who crave extraordinary experiences. Every destination is carefully curated, every detail considered — so you can be fully present for the moments that matter.
                </p>
                <a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="btn btn-outline">
                    <?php esc_html_e( 'Read My Story', 'pinandwander' ); ?>
                </a>
            </div>

        </div>
    </section>

    <!-- ================================================
         WORK WITH ME BANNER
         ================================================ -->
    <section class="section-cta-banner">
        <div class="cta-inner">
            <span class="eyebrow eyebrow--light">Travel Advisory Services</span>
            <h2 class="cta-title">Let&rsquo;s Plan Your Next Adventure</h2>
            <p class="cta-text">
                From boutique hotels to off-the-beaten-path experiences, I handle every detail so you can travel with ease and intention.
            </p>
            <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( 'Work With Me', 'pinandwander' ); ?>
            </a>
        </div>
    </section>

</main>

<?php get_footer(); ?>

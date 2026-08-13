<?php get_header(); ?>

<main id="main" class="site-main journal">

    <?php get_template_part( 'template-parts/journal-header', null, array( 'active' => 0 ) ); ?>

    <?php
    // ---- Map explorer (only when at least one Region category has posts) ----
    $pw_map_data = function_exists( 'pinandwander_journal_map_data' ) ? pinandwander_journal_map_data() : array();

    if ( ! empty( $pw_map_data ) ) :
        $pw_map_file = get_template_directory() . '/assets/world-map.svg';
        ?>
        <section class="journal-explorer" aria-label="<?php esc_attr_e( 'Explore stories by region', 'pinandwander' ); ?>">
            <div class="jmap-panel" id="jmapPanel">
                <span class="jmap-hint"><?php esc_html_e( 'Click a pin ▸', 'pinandwander' ); ?></span>
                <?php
                if ( is_readable( $pw_map_file ) ) {
                    echo file_get_contents( $pw_map_file ); // phpcs:ignore -- local, trusted theme asset
                }
                ?>
            </div>
            <aside class="jmap-list" id="jmapList" aria-live="polite">
                <div class="jmap-empty">
                    <span class="big"><?php esc_html_e( 'Where to?', 'pinandwander' ); ?></span>
                    <?php esc_html_e( 'Tap a glowing pin on the map to see the trips from that part of the world.', 'pinandwander' ); ?>
                </div>
            </aside>
        </section>
        <script type="application/json" id="jmap-data"><?php echo wp_json_encode( $pw_map_data, JSON_HEX_TAG | JSON_HEX_AMP ); ?></script>
    <?php endif; ?>

    <?php if ( have_posts() ) : ?>

        <div class="journal-grid" data-reveal-stagger="90">
            <?php
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/journal-card' );
            endwhile;
            ?>
        </div>

        <?php
        the_posts_pagination( array(
            'mid_size'  => 1,
            'prev_text' => __( '&larr; Newer', 'pinandwander' ),
            'next_text' => __( 'Older &rarr;', 'pinandwander' ),
        ) );
        ?>

    <?php else : ?>

        <?php get_template_part( 'template-parts/journal-placeholders' ); ?>

    <?php endif; ?>

</main>

<?php get_footer(); ?>

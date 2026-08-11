<?php get_header(); ?>

<main id="main" class="site-main journal">

    <?php
    $pw_term = get_queried_object();
    get_template_part( 'template-parts/journal-header', null, array(
        'active' => get_queried_object_id(),
        'title'  => single_cat_title( '', false ),
        'dek'    => ( $pw_term && ! empty( $pw_term->description ) )
            ? $pw_term->description
            : sprintf( __( 'Photographs and stories from %s.', 'pinandwander' ), single_cat_title( '', false ) ),
    ) );
    ?>

    <?php if ( have_posts() ) : ?>

        <div class="journal-grid">
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

        <p class="journal-note"><?php esc_html_e( 'No stories in this region yet.', 'pinandwander' ); ?></p>

    <?php endif; ?>

</main>

<?php get_footer(); ?>

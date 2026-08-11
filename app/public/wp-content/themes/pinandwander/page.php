<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <main id="main" class="site-main page">

        <header class="page-masthead">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <p class="page-dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="page-portrait">
                <?php the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
            </figure>
        <?php endif; ?>

        <?php if ( trim( get_the_content() ) !== '' ) : ?>
            <article <?php post_class( 'page-article' ); ?>>
                <div class="prose">
                    <?php
                    the_content();

                    wp_link_pages( array(
                        'before' => '<nav class="trip-pagelinks">',
                        'after'  => '</nav>',
                    ) );
                    ?>
                </div>
            </article>
        <?php else : ?>
            <?php get_template_part( 'template-parts/page-empty' ); ?>
        <?php endif; ?>

    </main>

<?php endwhile; ?>

<?php get_footer(); ?>

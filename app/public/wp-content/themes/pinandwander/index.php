<?php get_header(); ?>

<main id="main" class="site-main" style="padding-top: var(--nav-height);">

    <div style="max-width: 900px; margin: 0 auto; padding: 80px 48px;">

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-entry' ); ?> style="margin-bottom: 56px; padding-bottom: 56px; border-bottom: 1px solid rgba(0,0,0,0.08);">
                    <h2 style="font-family: var(--font-serif); font-size: 2rem; font-weight: 400; margin-bottom: 12px;">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <p style="font-size: 0.75rem; letter-spacing: 0.1em; text-transform: uppercase; color: var(--color-muted); margin-bottom: 20px;">
                        <?php the_date(); ?>
                    </p>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" style="display: block; margin-bottom: 20px; overflow: hidden;">
                            <?php the_post_thumbnail( 'large', array( 'style' => 'width:100%; height:420px; object-fit:cover;' ) ); ?>
                        </a>
                    <?php endif; ?>
                    <div style="line-height: 1.75; color: var(--color-mid);">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="btn btn-outline" style="margin-top: 20px; display: inline-block;">
                        <?php esc_html_e( 'Read More', 'pinandwander' ); ?>
                    </a>
                </article>
            <?php endwhile; ?>

            <?php the_posts_pagination(); ?>

        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'pinandwander' ); ?></p>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>

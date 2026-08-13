<?php
/**
 * Template for the "Work With Me" page (slug: contact).
 * Used automatically by WordPress for the page with that slug.
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php
    // Where enquiries go. Set under Settings → General → Administration Email Address,
    // or override with a custom field named "contact_email" on this page.
    $pw_email = get_post_meta( get_the_ID(), 'contact_email', true );
    if ( ! $pw_email || ! is_email( $pw_email ) ) {
        $pw_email = get_option( 'admin_email' );
    }
    ?>

    <main id="main" class="site-main page">

        <header class="page-masthead reveal">
            <span class="journal-kicker"><?php esc_html_e( 'Work With Me', 'pinandwander' ); ?></span>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <?php if ( has_excerpt() ) : ?>
                <p class="page-dek"><?php echo esc_html( get_the_excerpt() ); ?></p>
            <?php endif; ?>
        </header>

        <?php if ( has_post_thumbnail() ) : ?>
            <figure class="page-portrait reveal reveal-soft">
                <?php the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
            </figure>
        <?php endif; ?>

        <?php if ( trim( get_the_content() ) !== '' ) : ?>
            <article <?php post_class( 'page-article' ); ?>>
                <div class="prose reveal">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php else : ?>
            <?php get_template_part( 'template-parts/page-empty' ); ?>
        <?php endif; ?>

        <section class="contact-cta reveal" aria-labelledby="contact-cta-title">
            <h2 class="contact-cta-title" id="contact-cta-title">
                <?php esc_html_e( 'Let&rsquo;s plan something extraordinary', 'pinandwander' ); ?>
            </h2>
            <p class="contact-cta-text">
                <?php esc_html_e( 'Tell me where you dream of going, and I&rsquo;ll take it from there.', 'pinandwander' ); ?>
            </p>

            <?php if ( $pw_email ) : ?>
                <a class="btn btn-primary contact-cta-btn" href="mailto:<?php echo esc_attr( antispambot( $pw_email ) ); ?>">
                    <?php esc_html_e( 'Send Me an Email', 'pinandwander' ); ?>
                </a>
                <p class="contact-email">
                    <a href="mailto:<?php echo esc_attr( antispambot( $pw_email ) ); ?>">
                        <?php echo esc_html( antispambot( $pw_email ) ); ?>
                    </a>
                </p>
            <?php endif; ?>

            <div class="contact-social">
                <span class="contact-social-label"><?php esc_html_e( 'Or find me on', 'pinandwander' ); ?></span>
                <div class="contact-social-links">
                    <a href="#" aria-label="Instagram"><?php esc_html_e( 'Instagram', 'pinandwander' ); ?></a>
                    <a href="#" aria-label="Pinterest"><?php esc_html_e( 'Pinterest', 'pinandwander' ); ?></a>
                </div>
            </div>
        </section>

    </main>

<?php endwhile; ?>

<?php get_footer(); ?>

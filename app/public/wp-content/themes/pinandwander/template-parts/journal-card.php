<?php
/**
 * A single Photo Journal story card (used inside the loop).
 */
$pw_cats   = get_the_category();
$pw_region = ! empty( $pw_cats ) ? $pw_cats[0]->name : '';
?>
<article <?php post_class( 'story-card' ); ?>>
    <a href="<?php the_permalink(); ?>" class="story-link">
        <div class="story-media">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large', array( 'alt' => esc_attr( get_the_title() ) ) ); ?>
            <?php else : ?>
                <div class="story-placeholder"></div>
            <?php endif; ?>
        </div>
        <div class="story-body">
            <?php if ( $pw_region ) : ?>
                <span class="story-kicker"><?php echo esc_html( $pw_region ); ?></span>
            <?php endif; ?>
            <h3 class="story-title"><?php the_title(); ?></h3>
            <p class="story-meta"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></p>
            <?php $pw_excerpt = wp_trim_words( get_the_excerpt(), 20 ); ?>
            <?php if ( $pw_excerpt ) : ?>
                <p class="story-excerpt"><?php echo esc_html( $pw_excerpt ); ?></p>
            <?php endif; ?>
        </div>
    </a>
</article>

<?php
/**
 * Sample Photo Journal content shown when no posts are published yet,
 * so the page looks designed out of the box.
 */
$pw_lead = array(
    'region' => 'Patagonia',
    'title'  => 'To the End of the World and Back',
    'dek'    => 'Two weeks chasing light across the granite spires of Torres del Paine — and the small, unhurried moments in between.',
);

$pw_cards = array(
    array( 'region' => 'Southeast Asia', 'title' => 'Two Weeks in Bali &amp; Beyond' ),
    array( 'region' => 'Portugal',       'title' => 'A Slow Journey Down the Coast' ),
    array( 'region' => 'Japan',          'title' => 'Kyoto, Between the Seasons' ),
    array( 'region' => 'Morocco',        'title' => 'Blue Hours in Chefchaouen' ),
    array( 'region' => 'Iceland',        'title' => 'Chasing the Long Northern Dusk' ),
    array( 'region' => 'Peru',           'title' => 'Above the Sacred Valley' ),
);
?>

<article class="lead-story is-placeholder">
    <div class="lead-link">
        <div class="lead-media">
            <div class="lead-placeholder"></div>
            <div class="lead-overlay"></div>
        </div>
        <div class="lead-body">
            <span class="lead-kicker"><?php echo esc_html( $pw_lead['region'] ); ?> &middot; Featured</span>
            <h2 class="lead-title"><?php echo esc_html( $pw_lead['title'] ); ?></h2>
            <p class="lead-dek"><?php echo esc_html( $pw_lead['dek'] ); ?></p>
            <span class="lead-more"><?php esc_html_e( 'Read the story', 'pinandwander' ); ?></span>
        </div>
    </div>
</article>

<div class="journal-grid">
    <?php foreach ( $pw_cards as $pw_card ) : ?>
        <article class="story-card is-placeholder">
            <div class="story-link">
                <div class="story-media">
                    <div class="story-placeholder"></div>
                </div>
                <div class="story-body">
                    <span class="story-kicker"><?php echo esc_html( $pw_card['region'] ); ?></span>
                    <h3 class="story-title"><?php echo wp_kses_post( $pw_card['title'] ); ?></h3>
                    <p class="story-meta"><?php esc_html_e( 'Coming soon', 'pinandwander' ); ?></p>
                    <p class="story-excerpt"><?php esc_html_e( 'A sample story — publish your first trip journal to replace it.', 'pinandwander' ); ?></p>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<p class="journal-note">
    <?php esc_html_e( 'These are sample stories. Publish a post (with a featured photo and a Region category) and it will appear here automatically.', 'pinandwander' ); ?>
</p>

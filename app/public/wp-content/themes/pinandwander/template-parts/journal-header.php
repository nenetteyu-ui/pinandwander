<?php
/**
 * Photo Journal masthead + region filter.
 * Args: 'active' (int term id, 0 = All), 'title', 'dek'.
 */
$pw_active  = isset( $args['active'] ) ? (int) $args['active'] : 0;
$pw_title   = isset( $args['title'] ) && $args['title'] ? $args['title'] : __( 'Photo Journal', 'pinandwander' );
$pw_dek     = isset( $args['dek'] ) && $args['dek'] ? $args['dek'] : __( 'Dispatches, field notes, and photographs from the road.', 'pinandwander' );
$pw_journal = function_exists( 'pinandwander_journal_url' ) ? pinandwander_journal_url() : home_url( '/' );
$pw_cats    = get_categories( array( 'hide_empty' => true, 'orderby' => 'name' ) );
?>

<header class="journal-masthead">
    <span class="journal-kicker">Pin &amp; Wander</span>
    <h1 class="journal-title"><?php echo esc_html( $pw_title ); ?></h1>
    <p class="journal-dek"><?php echo esc_html( $pw_dek ); ?></p>
</header>

<?php if ( ! empty( $pw_cats ) ) : ?>
    <nav class="journal-filter" aria-label="<?php esc_attr_e( 'Filter by region', 'pinandwander' ); ?>">
        <a href="<?php echo esc_url( $pw_journal ); ?>"<?php echo 0 === $pw_active ? ' class="is-active" aria-current="page"' : ''; ?>>
            <?php esc_html_e( 'All', 'pinandwander' ); ?>
        </a>
        <?php foreach ( $pw_cats as $pw_cat ) : ?>
            <a href="<?php echo esc_url( get_category_link( $pw_cat ) ); ?>"<?php echo $pw_active === (int) $pw_cat->term_id ? ' class="is-active" aria-current="page"' : ''; ?>>
                <?php echo esc_html( $pw_cat->name ); ?>
            </a>
        <?php endforeach; ?>
    </nav>
<?php endif; ?>

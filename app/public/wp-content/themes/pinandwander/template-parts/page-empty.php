<?php
/**
 * Shown in place of the article when a page has no content yet.
 * Visitors see nothing; anyone who can edit the page sees a nudge.
 */
if ( ! current_user_can( 'edit_post', get_the_ID() ) ) {
    return;
}
?>
<div class="page-empty">
    <p class="page-empty-text">
        <?php esc_html_e( 'This page has no content yet — only you can see this note.', 'pinandwander' ); ?>
    </p>
    <a class="btn btn-outline" href="<?php echo esc_url( get_edit_post_link() ); ?>">
        <?php esc_html_e( 'Add content', 'pinandwander' ); ?>
    </a>
</div>

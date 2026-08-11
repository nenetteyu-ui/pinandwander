<footer class="site-footer">
    <div class="footer-inner">

        <div class="footer-top">

            <div class="footer-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home">
                    <?php echo pinandwander_logo_mark( 'footer-logo-mark' ); ?>
                    <span class="footer-logo-text">Pin <span class="amp">&amp;</span> Wander</span>
                </a>
                <p class="footer-tagline">Pin the dream. Wander the world.<br>Repeat.</p>
            </div>

            <nav aria-label="<?php esc_attr_e( 'Footer', 'pinandwander' ); ?>">
                <span class="footer-nav-label">Explore</span>
                <div class="footer-nav-links">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pinandwander' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'Photo Journal', 'pinandwander' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About', 'pinandwander' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Work With Me', 'pinandwander' ); ?></a>
                </div>
            </nav>

            <div class="footer-social-wrap">
                <span class="footer-social-label">Connect</span>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><?php esc_html_e( 'Instagram', 'pinandwander' ); ?></a>
                    <a href="#" aria-label="Pinterest"><?php esc_html_e( 'Pinterest', 'pinandwander' ); ?></a>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p class="footer-copy">
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'pinandwander' ); ?>
            </p>
            <p class="footer-copy">Designed with intention.</p>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

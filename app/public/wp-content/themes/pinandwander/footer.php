<footer class="site-footer">
    <div class="footer-inner">

        <div class="footer-top">

            <div class="footer-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — home">
                    <?php echo pinandwander_logo_mark( 'footer-logo-mark' ); ?>
                    <span class="footer-logo-text">Pin <span class="amp">&amp;</span> Wander</span>
                </a>
                <p class="footer-tagline">Pin the dream. Wander the world.<br>Repeat.</p>

                <?php
                // Coastline's IATA number is not published publicly — fill this
                // in and the line appears. Left empty, it does not render.
                $pw_coastline_iata = '';
                ?>
                <div class="footer-affiliations">
                    <p class="footer-affil-intro">
                        <?php esc_html_e( 'An independent travel advisory company, affiliated with', 'pinandwander' ); ?>
                    </p>
                    <ul class="footer-affil-list">
                        <li><span class="footer-affil-name">Travels with Tesa</span></li>
                        <li>
                            <span class="footer-affil-name">Coastline Travel Advisors</span>
                            <?php if ( $pw_coastline_iata ) : ?>
                                <span class="footer-affil-meta">IATA <?php echo esc_html( $pw_coastline_iata ); ?></span>
                            <?php endif; ?>
                            <span class="footer-affil-meta">
                                <?php esc_html_e( 'Affiliated with the Virtuoso travel network', 'pinandwander' ); ?>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <nav aria-label="<?php esc_attr_e( 'Footer', 'pinandwander' ); ?>">
                <span class="footer-nav-label">Explore</span>
                <div class="footer-nav-links">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'pinandwander' ); ?></a>
                    <a href="<?php echo esc_url( pinandwander_journal_url() ); ?>"><?php esc_html_e( 'Photo Journal', 'pinandwander' ); ?></a>
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

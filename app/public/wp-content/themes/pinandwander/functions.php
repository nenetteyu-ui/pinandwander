<?php

function pinandwander_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    register_nav_menus( array(
        'primary' => __( 'Primary Navigation', 'pinandwander' ),
    ) );
}
add_action( 'after_setup_theme', 'pinandwander_setup' );

function pinandwander_scripts() {
    // Google Fonts
    wp_enqueue_style(
        'pinandwander-fonts',
        'https://fonts.googleapis.com/css2?family=Libre+Bodoni:ital,wght@0,400;0,500;0,700;1,400&family=Inter:wght@300;400;500&display=swap',
        array(),
        null
    );

    // Theme stylesheet
    wp_enqueue_style(
        'pinandwander-style',
        get_stylesheet_uri(),
        array( 'pinandwander-fonts' ),
        wp_get_theme()->get( 'Version' )
    );

    // Theme JS
    wp_enqueue_script(
        'pinandwander-main',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get( 'Version' ),
        true
    );

    // Map explorer script, only on the Photo Journal (blog index)
    if ( is_home() ) {
        wp_enqueue_script(
            'pinandwander-journal-map',
            get_template_directory_uri() . '/assets/js/journal-map.js',
            array(),
            wp_get_theme()->get( 'Version' ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'pinandwander_scripts' );

/**
 * Hero slideshow timing.
 *
 * The crossfade runs entirely in CSS rather than on a JS timer: a keyframe
 * animation starts the moment the page paints (a transition cannot, because
 * the first slide is already marked active in the markup and so never changes
 * state), and it is not subject to background-tab timer throttling.
 *
 * The keyframe percentages depend on how many photos are in assets/hero/,
 * so the rule is generated here rather than hard-coded in style.css.
 */
function pinandwander_hero_inline_css() {
    if ( ! is_front_page() ) {
        return;
    }

    $slides = pinandwander_hero_slides();
    $count  = count( $slides );

    if ( 0 === $count ) {
        $count = 3; // the on-brand gradient placeholders
    }
    if ( $count < 2 ) {
        return; // a lone photo has nothing to cross-fade to
    }

    $slot  = 7.0;  // seconds each photo holds on its own
    $fade  = 2.6;  // seconds the outgoing and incoming photos overlap
    $total = $slot * $count;

    $fade_in  = round( $fade / $total * 100, 3 );
    $hold_end = round( $slot / $total * 100, 3 );
    $fade_out = round( ( $slot + $fade ) / $total * 100, 3 );

    $css = "
.hero-slide {
    animation: pwHeroCycle {$total}s linear infinite;
    animation-delay: calc(var(--pw-i, 0) * {$slot}s);
}

@keyframes pwHeroCycle {
    0%              { opacity: 0; transform: scale(1); }
    {$fade_in}%     { opacity: 1; }
    {$hold_end}%    { opacity: 1; }
    {$fade_out}%    { opacity: 0; transform: scale(1.2); }
    100%            { opacity: 0; transform: scale(1); }
}

@media (prefers-reduced-motion: reduce) {
    .hero-slide { animation: none; }
    .hero-slide.is-active { opacity: 1; transform: none; }
}
";

    wp_add_inline_style( 'pinandwander-style', $css );
}
add_action( 'wp_enqueue_scripts', 'pinandwander_hero_inline_css', 20 );

/**
 * URL of the Photo Journal (the WordPress "Posts page" if one is set,
 * otherwise /blog). Keeps nav links correct once the Posts page is assigned.
 */
function pinandwander_journal_url() {
    $posts_page = (int) get_option( 'page_for_posts' );
    if ( $posts_page ) {
        return get_permalink( $posts_page );
    }
    return home_url( '/blog' );
}

/**
 * Region → map coordinates, in the world map's 2754 x 1398 space.
 * Value: array( pinX, pinY, hitX, hitY, hitW, hitH ).
 * Keyed by category slug; aliases point at the same spot.
 * A pin only renders if a category with a matching slug has published posts.
 */
function pinandwander_map_regions() {
    return array(
        'north-america' => array( 600, 360, 300, 240, 620, 380 ),
        'south-america' => array( 915, 860, 780, 700, 340, 540 ),
        'europe'        => array( 1470, 320, 1360, 240, 320, 240 ),
        'africa'        => array( 1520, 700, 1360, 540, 440, 540 ),
        'asia'          => array( 2060, 360, 1690, 200, 860, 500 ),
        'oceania'       => array( 2380, 900, 2180, 780, 540, 340 ),
        'australia'     => array( 2380, 900, 2180, 780, 540, 340 ),
        'arctic'        => array( 1120, 150, 820, 20, 760, 230 ),
        'the-arctic'    => array( 1120, 150, 820, 20, 760, 230 ),
        'greenland'     => array( 1120, 150, 820, 20, 760, 230 ),
        'antarctica'    => array( 1377, 1290, 150, 1170, 2450, 220 ),
    );
}

/**
 * Build the data the map explorer needs: for every Region category that
 * (a) maps to a spot on the map and (b) has published posts, collect its
 * pin/hit coordinates and a short list of its stories.
 */
function pinandwander_journal_map_data() {
    $coords = pinandwander_map_regions();
    $data   = array();

    foreach ( get_categories( array( 'hide_empty' => true ) ) as $cat ) {
        if ( ! isset( $coords[ $cat->slug ] ) ) {
            continue;
        }
        $c = $coords[ $cat->slug ];

        $q = new WP_Query( array(
            'category__in'        => array( $cat->term_id ),
            'posts_per_page'      => 8,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        ) );

        $stories = array();
        while ( $q->have_posts() ) {
            $q->the_post();
            $stories[] = array(
                'title' => get_the_title(),
                'date'  => get_the_date(),
                'url'   => get_permalink(),
                'thumb' => has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'medium_large' ) : '',
            );
        }
        wp_reset_postdata();

        if ( empty( $stories ) ) {
            continue;
        }

        $data[] = array(
            'slug'    => $cat->slug,
            'name'    => $cat->name,
            'url'     => get_category_link( $cat ),
            'pin'     => array( $c[0], $c[1] ),
            'hit'     => array( $c[2], $c[3], $c[4], $c[5] ),
            'stories' => $stories,
        );
    }

    return $data;
}

function pinandwander_fallback_nav() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url( pinandwander_journal_url() ) . '">Photo Journal</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">About</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">Work With Me</a></li>';
    echo '</ul>';
}

/**
 * Scan assets/hero/ for images and return their URLs, sorted by filename.
 * Drop any number of jpg/png/webp files in that folder and they become
 * hero slides automatically — no renaming, no code changes.
 */
function pinandwander_hero_slides() {
    $dir = trailingslashit( get_template_directory() ) . 'assets/hero';
    $uri = trailingslashit( get_template_directory_uri() ) . 'assets/hero/';
    $slides = array();

    if ( ! is_dir( $dir ) ) {
        return $slides;
    }

    $allowed = array( 'jpg', 'jpeg', 'png', 'webp', 'gif', 'avif' );

    foreach ( (array) scandir( $dir ) as $file ) {
        if ( '' === $file || '.' === $file[0] ) {
            continue; // skip hidden files and . / ..
        }
        $ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );
        if ( ! in_array( $ext, $allowed, true ) ) {
            continue; // skip README.txt and anything non-image
        }
        $slides[] = $uri . rawurlencode( $file );
    }

    // Play in natural filename order (so 2.jpg comes before 10.jpg).
    natcasesort( $slides );

    return array_values( $slides );
}

/**
 * The Pin & Wander logo mark (double-orbit globe).
 * Globe wireframe uses currentColor so it adapts to its context;
 * the green disk and gold ring/pin are fixed brand colors.
 */
function pinandwander_logo_mark( $class = 'logo-mark' ) {
    return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 100 100" role="img" aria-hidden="true" focusable="false">'
        . '<g fill="none" stroke-linecap="round" stroke-linejoin="round">'
        // far side of the orbit (behind the globe)
        . '<g transform="rotate(-20 50 55)"><path d="M20,55 A30,11 0 0 1 80,55" stroke="#c9a96e" stroke-width="2"/></g>'
        . '<g transform="rotate(24 50 55)"><path d="M22,55 A28,9 0 0 1 78,55" stroke="#c9a96e" stroke-width="1.7" opacity="0.7"/></g>'
        // globe
        . '<circle cx="50" cy="55" r="19.5" fill="#10231a" stroke="none"/>'
        . '<circle cx="50" cy="55" r="19.5" stroke="currentColor" stroke-width="2.4"/>'
        . '<ellipse cx="50" cy="55" rx="7.8" ry="19.5" stroke="currentColor" stroke-width="1.6"/>'
        . '<ellipse cx="50" cy="55" rx="19.5" ry="6.3" stroke="currentColor" stroke-width="1.6"/>'
        // dropped pin
        . '<path d="M50,36 C44,29 41,27 41,23 A9,9 0 1 1 59,23 C59,27 56,29 50,36 Z" fill="#c9a96e" stroke="none"/>'
        . '<circle cx="50" cy="23" r="3.1" fill="#10231a" stroke="none"/>'
        // near side of the orbit (over the globe) + arrowhead riding the line
        . '<g transform="rotate(24 50 55)"><path d="M22,55 A28,9 0 0 0 78,55" stroke="#c9a96e" stroke-width="1.7" opacity="0.7"/></g>'
        . '<g transform="rotate(-20 50 55)">'
        . '<path d="M20,55 A30,11 0 0 0 80,55" stroke="#c9a96e" stroke-width="2"/>'
        . '<path d="M79.32,58.55 L73.58,66.56 L69.54,59.66 Z" fill="#c9a96e" stroke="none"/>'
        . '</g>'
        . '</g></svg>';
}

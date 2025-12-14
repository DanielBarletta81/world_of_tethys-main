<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-abyss bg-tethys-radial text-slate-100 antialiased' ); ?>>
<?php wp_body_open(); ?>
<?php
$nav_items = [
    'home'        => [ 'label' => __( 'Home', 'tethys' ), 'url' => home_url( '/' ) ],
    
    'books'       => [ 'label' => __( 'Books', 'tethys' ), 'url' => tethys_page_link( 'books-2' ) ],
    'shop'        => [ 'label' => __( 'Shop', 'tethys' ), 'url' => tethys_page_link( 'shop' ) ],
    'characters'  => [ 'label' => __( 'Characters', 'tethys' ), 'url' => tethys_page_link( 'characters' ) ],
    'real-science'=> [ 'label' => __( 'Legit Science', 'tethys' ), 'url' => tethys_page_link( 'real-science' ) ],
    'comments'    => [ 'label' => __( 'Comments', 'tethys' ), 'url' => tethys_page_link( 'comments' ) ],
    'signals'     => [ 'label' => __( 'Signals', 'tethys' ), 'url' => tethys_page_link( 'signals' ) ],
    'support'     => [ 'label' => __( 'Support', 'tethys' ), 'url' => tethys_page_link( 'support' ) ],
    'about'       => [ 'label' => __( 'About', 'tethys' ), 'url' => tethys_page_link( 'about' ) ],
];

$current_nav = 'home';

if ( is_page() ) {
    $slug = get_post_field( 'post_name', get_queried_object_id() );
    switch ( $slug ) {
        case 'world-of-tethys':
            $current_nav = 'world';
            break;
        case 'books-2':
            $current_nav = 'books';
            break;
        case 'shop':
            $current_nav = 'shop';
            break;
        case 'characters':
            $current_nav = 'characters';
            break;
        case 'real-science':
            $current_nav = 'real-science';
            break;
        case 'comments':
            $current_nav = 'comments';
            break;
        case 'signals-from-thethys':
            $current_nav = 'signals';
            break;
        case 'support':
            $current_nav = 'support';
            break;
        case 'about':
            $current_nav = 'about';
            break;
    }
} elseif ( is_front_page() ) {
    $current_nav = 'home';
}
?>
<header class="site-nav-bar">
    <div class="site-nav">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-nav__brand">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/new_cover.png' ); ?>" alt="<?php esc_attr_e( 'World of Tethys crest', 'tethys' ); ?>" class="site-nav__logo" loading="lazy">
            <span class="site-nav__wordmark"><?php esc_html_e( 'World of', 'tethys' ); ?> <span><?php esc_html_e( 'Tethys', 'tethys' ); ?></span></span>
        </a>
        <nav class="site-nav__links">
            <?php foreach ( $nav_items as $id => $item ) : ?>
                <?php
                $classes = 'nav-pill';
                if ( $id === $current_nav ) {
                    $classes .= ' nav-pill--active';
                }
                ?>
                <a href="<?php echo esc_url( $item['url'] ); ?>" class="<?php echo esc_attr( $classes ); ?>"<?php echo $id === $current_nav ? ' aria-current="page"' : ''; ?>>
                    <?php echo esc_html( $item['label'] ); ?>
                </a>
            <?php endforeach; ?>
            <a href="https://dcbarletta.substack.com" class="nav-pill" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e( 'Join the Watchlist', 'tethys' ); ?>
            </a>
        </nav>
    </div>
</header>

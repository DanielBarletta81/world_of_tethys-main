<?php
/**
 * Theme bootstrap for World of Tethys.
 */

if ( ! function_exists( 'tethys_theme_setup' ) ) {
    function tethys_theme_setup() {
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
    }
}
add_action( 'after_setup_theme', 'tethys_theme_setup' );

if ( ! function_exists( 'tethys_enqueue_assets' ) ) {
    function tethys_enqueue_assets() {
        $theme_dir = get_template_directory();

        wp_enqueue_style(
            'tethys-base',
            get_stylesheet_uri(),
            [],
            filemtime( $theme_dir . '/style.css' )
        );

        $css_path = $theme_dir . '/assets/css/tethys.css';
        if ( file_exists( $css_path ) ) {
            wp_enqueue_style(
                'tethys-tailwind',
                get_template_directory_uri() . '/assets/css/tethys.css',
                [ 'tethys-base' ],
                filemtime( $css_path )
            );
        }

        $links_js = $theme_dir . '/assets/js/tethys-links.js';
        if ( file_exists( $links_js ) ) {
            wp_enqueue_script(
                'tethys-links',
                get_template_directory_uri() . '/assets/js/tethys-links.js',
                [],
                filemtime( $links_js ),
                true
            );
        }

        $effects_js = $theme_dir . '/assets/js/tethys-effects.js';
        if ( file_exists( $effects_js ) ) {
            wp_enqueue_script(
                'tethys-effects',
                get_template_directory_uri() . '/assets/js/tethys-effects.js',
                [ 'tethys-links' ],
                filemtime( $effects_js ),
                true
            );
        }

        if ( is_front_page() ) {
            wp_enqueue_script(
                'stripe-buy-button',
                'https://js.stripe.com/v3/buy-button.js',
                [],
                null,
                true
            );

            $intro_script = <<<JS
(function initWotIntro(){const overlay=document.getElementById('wot-intro');if(!overlay)return;const skipButton=overlay.querySelector('[data-skip-intro]');const audio=document.getElementById('wot-intro-audio');const prefersReducedMotion=window.matchMedia('(prefers-reduced-motion: reduce)').matches;const alreadyPlayed=sessionStorage.getItem('wotIntroPlayed');if(prefersReducedMotion||alreadyPlayed){overlay.remove();return;}function finishIntro(){overlay.classList.add('intro-overlay--done');sessionStorage.setItem('wotIntroPlayed','1');window.setTimeout(()=>overlay.remove(),600);}function playIntro(){overlay.classList.add('intro-overlay--active');if(audio){audio.currentTime=0;const playPromise=audio.play();if(playPromise&&typeof playPromise.catch==='function'){playPromise.catch(()=>{});}}window.setTimeout(finishIntro,3600);}window.addEventListener('load',playIntro,{once:true});skipButton&&skipButton.addEventListener('click',finishIntro);})();
JS;

            if ( wp_script_is( 'tethys-effects', 'enqueued' ) ) {
                wp_add_inline_script( 'tethys-effects', $intro_script );
            } else {
                wp_register_script( 'tethys-intro-inline', '', [], null, true );
                wp_enqueue_script( 'tethys-intro-inline' );
                wp_add_inline_script( 'tethys-intro-inline', $intro_script );
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'tethys_enqueue_assets' );

if ( ! function_exists( 'tethys_page_link' ) ) {
    /**
     * Helper: create links to expected slugs, fallback to best-guess URL.
     */
    function tethys_page_link( $slug = '' ) {
        if ( empty( $slug ) ) {
            return home_url( '/' );
        }

        $page = get_page_by_path( $slug );
        if ( $page ) {
            return get_permalink( $page );
        }

        return home_url( '/' . trim( $slug, '/' ) . '/' );
    }
}

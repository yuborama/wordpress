<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/site-data.php';
require_once get_template_directory() . '/inc/theme-helpers.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/seed-front-page.php';

function gya_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('custom-logo');
    add_theme_support('editor-styles');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(
        array(
            'primary' => __('Menu principal', 'gya'),
            'footer' => __('Menu de footer', 'gya'),
        )
    );
}
add_action('after_setup_theme', 'gya_theme_setup');

function gya_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'gya-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        $theme_version
    );

    wp_enqueue_script(
        'gya-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'gya_enqueue_assets');

function gya_primary_menu_fallback() {
    echo '<ul class="menu">';
    echo '<li><a href="#soluciones">Soluciones</a></li>';
    echo '<li><a href="#insights">Insights</a></li>';
    echo '<li><a href="#servicios">Cómo ayudamos</a></li>';
    echo '<li><a href="#nosotros">Nosotros</a></li>';
    echo '</ul>';
}

function gya_footer_menu_fallback() {
    echo '<ul class="menu">';
    echo '<li><a href="#top">Inicio</a></li>';
    echo '<li><a href="#blog">Blog</a></li>';
    echo '<li><a href="#contacto">Contacto</a></li>';
    echo '</ul>';
}

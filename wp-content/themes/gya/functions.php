<?php

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/site-data.php';
require_once get_template_directory() . '/inc/theme-helpers.php';
require_once get_template_directory() . '/inc/hero-slides.php';
require_once get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/seed-front-page.php';

function gya_theme_setup()
{
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

function gya_register_categories_cpt()
{
    register_post_type('gya_category', [
        'labels' => [
            'name' => 'Categorías',
            'singular_name' => 'Categoría',
            'add_new_item' => 'Agregar nueva categoría',
            'edit_item' => 'Editar categoría',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-category',
        'supports' => ['title', 'thumbnail'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gya_register_categories_cpt');

function gya_register_subcategories_cpt()
{
    register_post_type('gya_subcategory', [
        'labels' => [
            'name' => 'Subcategorías',
            'singular_name' => 'Subcategoría',
            'add_new_item' => 'Agregar nueva subcategoría',
            'edit_item' => 'Editar subcategoría',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-tag',
        'supports' => ['title'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gya_register_subcategories_cpt');

function gya_register_como_ayudamos_cpt()
{
    $labels = array(
        'name' => 'Cómo ayudamos',
        'singular_name' => 'Item Cómo ayudamos',
        'menu_name' => 'Cómo ayudamos',
        'name_admin_bar' => 'Item Cómo ayudamos',
        'add_new' => 'Agregar nuevo',
        'add_new_item' => 'Agregar nuevo item',
        'new_item' => 'Nuevo item',
        'edit_item' => 'Editar item',
        'view_item' => 'Ver item',
        'all_items' => 'Todos los items',
        'search_items' => 'Buscar items',
        'not_found' => 'No se encontraron items',
        'not_found_in_trash' => 'No hay items en la papelera',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-heart',
        'query_var' => true,
        'rewrite' => array('slug' => 'como-ayudamos'),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => 22,
        'supports' => array('title'),
        'show_in_rest' => true,
    );

    register_post_type('como_ayudamos', $args);
}
add_action('init', 'gya_register_como_ayudamos_cpt');

function gya_register_team_member_cpt()
{
    $labels = array(
        'name' => 'Nuestro equipo',
        'singular_name' => 'Miembro del equipo',
        'menu_name' => 'Nuestro equipo',
        'name_admin_bar' => 'Miembro del equipo',
        'add_new' => 'Añadir nuevo',
        'add_new_item' => 'Añadir nuevo miembro',
        'new_item' => 'Nuevo miembro',
        'edit_item' => 'Editar miembro',
        'view_item' => 'Ver miembro',
        'all_items' => 'Todos los miembros',
        'search_items' => 'Buscar miembros',
        'not_found' => 'No se encontraron miembros',
        'not_found_in_trash' => 'No se encontraron miembros en la papelera',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => false,
        'rewrite' => array('slug' => 'equipo'),
        'show_in_rest' => true,
    );

    register_post_type('team_member', $args);
}
add_action('init', 'gya_register_team_member_cpt');

function gya_register_insights_cpt() {
    register_post_type('insights', array(
        'labels' => array(
            'name' => 'Insights',
            'singular_name' => 'Insight',
            'add_new' => 'Agregar Insight',
            'add_new_item' => 'Agregar nuevo Insight',
            'edit_item' => 'Editar Insight',
            'new_item' => 'Nuevo Insight',
            'view_item' => 'Ver Insight',
            'search_items' => 'Buscar Insights',
            'not_found' => 'No se encontraron Insights',
            'not_found_in_trash' => 'No se encontraron Insights en la papelera',
        ),
        'public' => true,
        'menu_icon' => 'dashicons-lightbulb',
        'supports' => array('title', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'insights'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'gya_register_insights_cpt');

function gya_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');
    $css_path = get_template_directory() . '/assets/css/main.css';
    $hero_css_path = get_template_directory() . '/assets/css/hero.css';
    $solutions_css_path = get_template_directory() . '/assets/css/solutions.css';
    $insights_css_path = get_template_directory() . '/assets/css/insights.css';
    $cta_css_path = get_template_directory() . '/assets/css/cta-banner.css';
    $services_css_path = get_template_directory() . '/assets/css/services.css';
    $team_css_path = get_template_directory() . '/assets/css/team.css';
    $js_path = get_template_directory() . '/assets/js/main.js';

    wp_enqueue_style(
        'gya-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        file_exists($css_path) ? filemtime($css_path) : $theme_version
    );

    wp_enqueue_style(
        'gya-hero-style',
        get_template_directory_uri() . '/assets/css/hero.css',
        array('gya-main-style'),
        file_exists($hero_css_path) ? filemtime($hero_css_path) : $theme_version
    );

    wp_enqueue_style(
        'gya-solutions-style',
        get_template_directory_uri() . '/assets/css/solutions.css',
        array('gya-main-style'),
        file_exists($solutions_css_path) ? filemtime($solutions_css_path) : $theme_version
    );

    wp_enqueue_style(
        'gya-insights-style',
        get_template_directory_uri() . '/assets/css/insights.css',
        array('gya-main-style'),
        file_exists($insights_css_path) ? filemtime($insights_css_path) : $theme_version
    );

    wp_enqueue_style(
        'gya-cta-banner-style',
        get_template_directory_uri() . '/assets/css/cta-banner.css',
        array('gya-main-style'),
        file_exists($cta_css_path) ? filemtime($cta_css_path) : $theme_version
    );

    wp_enqueue_style(
        'gya-services-style',
        get_template_directory_uri() . '/assets/css/services.css',
        array('gya-main-style'),
        file_exists($services_css_path) ? filemtime($services_css_path) : $theme_version
    );

    wp_enqueue_style(
        'gya-team-style',
        get_template_directory_uri() . '/assets/css/team.css',
        array('gya-main-style'),
        file_exists($team_css_path) ? filemtime($team_css_path) : $theme_version
    );

    wp_enqueue_script(
        'gya-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        file_exists($js_path) ? filemtime($js_path) : $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'gya_enqueue_assets');


function gya_primary_menu_fallback()
{
    echo '<ul class="menu">';
    echo '<li><a href="#soluciones">Soluciones</a></li>';
    echo '<li><a href="#insights">Insights</a></li>';
    echo '<li><a href="#servicios">Cómo ayudamos</a></li>';
    echo '<li><a href="#nosotros">Nosotros</a></li>';
    echo '</ul>';
}

function gya_footer_menu_fallback()
{
    echo '<ul class="menu">';
    echo '<li><a href="#top">Inicio</a></li>';
    echo '<li><a href="#blog">Blog</a></li>';
    echo '<li><a href="#contacto">Contacto</a></li>';
    echo '</ul>';
}

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

function gya_flush_rewrite_rules_once()
{
    $rewrite_version = '20260706_insights_detail';

    if (get_option('gya_rewrite_rules_version') === $rewrite_version) {
        return;
    }

    flush_rewrite_rules(false);
    update_option('gya_rewrite_rules_version', $rewrite_version);
}
add_action('init', 'gya_flush_rewrite_rules_once', 30);

function gya_is_team_page_request()
{
    global $wp;

    $request = isset($wp->request) ? trim((string) $wp->request, '/') : '';

    return is_page('team') || $request === 'team';
}

function gya_is_weare_page_request()
{
    global $wp;

    $request = isset($wp->request) ? trim((string) $wp->request, '/') : '';

    return is_page('weare') || $request === 'weare';
}

function gya_enqueue_assets()
{
    $theme_version = wp_get_theme()->get('Version');
    $css_path = get_template_directory() . '/assets/css/main.css';
    $hero_css_path = get_template_directory() . '/assets/css/hero.css';
    $solutions_css_path = get_template_directory() . '/assets/css/solutions.css';
    $insights_css_path = get_template_directory() . '/assets/css/insights.css';
    $insights_archive_css_path = get_template_directory() . '/assets/css/insights-archive.css';
    $insight_detail_css_path = get_template_directory() . '/assets/css/insight-detail.css';
    $category_detail_css_path = get_template_directory() . '/assets/css/category-detail.css';
    $cta_css_path = get_template_directory() . '/assets/css/cta-banner.css';
    $services_css_path = get_template_directory() . '/assets/css/services.css';
    $team_css_path = get_template_directory() . '/assets/css/team.css';
    $team_page_css_path = get_template_directory() . '/assets/css/team-page.css';
    $weare_page_css_path = get_template_directory() . '/assets/css/weare-page.css';
    $intro_loader_css_path = get_template_directory() . '/assets/css/intro-loader.css';
    $js_path = get_template_directory() . '/assets/js/main.js';
    $intro_loader_js_path = get_template_directory() . '/assets/js/intro-loader.js';
    $intro_lottie_path = get_template_directory() . '/assets/lottie/intro.json';

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

    if (is_post_type_archive('insights')) {
        wp_enqueue_style(
            'gya-insights-archive-style',
            get_template_directory_uri() . '/assets/css/insights-archive.css',
            array('gya-main-style', 'gya-insights-style', 'gya-cta-banner-style'),
            file_exists($insights_archive_css_path) ? filemtime($insights_archive_css_path) : $theme_version
        );
    }

    if (is_singular('insights')) {
        wp_enqueue_style(
            'gya-insight-detail-style',
            get_template_directory_uri() . '/assets/css/insight-detail.css',
            array('gya-main-style'),
            file_exists($insight_detail_css_path) ? filemtime($insight_detail_css_path) : $theme_version
        );
    }

    if (is_singular('gya_category')) {
        wp_enqueue_style(
            'gya-category-detail-style',
            get_template_directory_uri() . '/assets/css/category-detail.css',
            array('gya-main-style', 'gya-insights-style', 'gya-cta-banner-style'),
            file_exists($category_detail_css_path) ? filemtime($category_detail_css_path) : $theme_version
        );
    }

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

    if (gya_is_team_page_request()) {
        wp_enqueue_style(
            'gya-team-page-style',
            get_template_directory_uri() . '/assets/css/team-page.css',
            array('gya-main-style', 'gya-team-style'),
            file_exists($team_page_css_path) ? filemtime($team_page_css_path) : $theme_version
        );
    }

    if (gya_is_weare_page_request()) {
        wp_enqueue_style(
            'gya-weare-page-style',
            get_template_directory_uri() . '/assets/css/weare-page.css',
            array('gya-main-style', 'gya-team-style'),
            file_exists($weare_page_css_path) ? filemtime($weare_page_css_path) : $theme_version
        );
    }

    if ((is_front_page() || is_home()) && file_exists($intro_lottie_path)) {
        wp_enqueue_style(
            'gya-intro-loader-style',
            get_template_directory_uri() . '/assets/css/intro-loader.css',
            array('gya-main-style'),
            file_exists($intro_loader_css_path) ? filemtime($intro_loader_css_path) : $theme_version
        );

        wp_enqueue_script(
            'lottie-web',
            'https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.12.2/lottie.min.js',
            array(),
            '5.12.2',
            true
        );

        wp_enqueue_script(
            'gya-intro-loader',
            get_template_directory_uri() . '/assets/js/intro-loader.js',
            array('lottie-web'),
            file_exists($intro_loader_js_path) ? filemtime($intro_loader_js_path) : $theme_version,
            true
        );

        wp_localize_script(
            'gya-intro-loader',
            'gyaIntroLoader',
            array(
                'animationPath' => get_template_directory_uri() . '/assets/lottie/intro.json',
                'storageKey' => 'gyaIntroLoaderPlayed',
            )
        );
    }

    wp_enqueue_script(
        'gya-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        file_exists($js_path) ? filemtime($js_path) : $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'gya_enqueue_assets');

function gya_team_page_template($template)
{
    if (!gya_is_team_page_request()) {
        return $template;
    }

    $team_template = get_template_directory() . '/page-team.php';

    if (file_exists($team_template)) {
        global $wp_query;

        if ($wp_query) {
            $wp_query->is_404 = false;
        }

        status_header(200);
    }

    return file_exists($team_template) ? $team_template : $template;
}
add_filter('template_include', 'gya_team_page_template');

function gya_weare_page_template($template)
{
    if (!gya_is_weare_page_request()) {
        return $template;
    }

    $weare_template = get_template_directory() . '/page-weare.php';

    if (file_exists($weare_template)) {
        global $wp_query;

        if ($wp_query) {
            $wp_query->is_404 = false;
        }

        status_header(200);
    }

    return file_exists($weare_template) ? $weare_template : $template;
}
add_filter('template_include', 'gya_weare_page_template');

function gya_intro_loader_head_state()
{
    if (!(is_front_page() || is_home())) {
        return;
    }

    if (!file_exists(get_template_directory() . '/assets/lottie/intro.json')) {
        return;
    }

    ?>
    <script>
    (function () {
      try {
        if (window.sessionStorage && window.sessionStorage.getItem('gyaIntroLoaderPlayed') === 'true') {
          document.documentElement.classList.add('gya-intro-loader-played');
        }
      } catch (error) {}
    })();
    </script>
    <?php
}
add_action('wp_head', 'gya_intro_loader_head_state', 1);

function gya_intro_loader_markup()
{
    if (!(is_front_page() || is_home())) {
        return;
    }

    if (!file_exists(get_template_directory() . '/assets/lottie/intro.json')) {
        return;
    }

    ?>
    <div class="page-loader" id="page-loader" aria-hidden="true">
        <div class="page-loader__animation" id="page-loader-lottie"></div>
    </div>
    <?php
}
add_action('wp_body_open', 'gya_intro_loader_markup');


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

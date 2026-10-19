<?php
if (!defined('ABSPATH')) {
    exit;
}

/** Routes rendered by the theme without a published WordPress page. */
function gya_get_virtual_page()
{
    global $wp;
    if (is_admin() || get_queried_object() instanceof WP_Post) {
        return null;
    }
    $routes = array(
        'acceso' => array('title' => 'Acceso', 'template' => 'page-access.php'),
        'areas' => array('title' => 'Áreas', 'template' => 'page-areas.php'),
        'weare' => array('title' => 'La firma', 'template' => 'page-weare.php'),
        'team' => array('title' => 'Nuestro equipo', 'template' => 'page-team.php'),
        'contact' => array('title' => 'Contacto', 'template' => 'page-contact.php'),
        'privacy' => array('title' => 'Aviso de privacidad', 'template' => 'page-privacy.php'),
        'aviso-de-privacidad' => array('title' => 'Aviso de privacidad', 'template' => 'page-privacy.php'),
        'cookies' => array('title' => 'Política de cookies', 'template' => 'page-cookies.php'),
        'politica-de-cookies' => array('title' => 'Política de cookies', 'template' => 'page-cookies.php'),
    );
    $path = isset($wp->request) ? trim((string) $wp->request, '/') : '';
    if (!isset($routes[$path]) || !file_exists(get_template_directory() . '/' . $routes[$path]['template'])) {
        return null;
    }
    return $routes[$path];
}

// Resolve before WordPress and SEO plugins prepare their 404 metadata.
add_filter('pre_handle_404', function ($preempt, $query) {
    if (!gya_get_virtual_page()) {
        return $preempt;
    }
    $query->is_404 = false;
    // These routes have no queried post. Singular flags make body_class()
    // dereference a missing post and inject PHP warnings into the body tag.
    $query->is_single = false;
    $query->is_page = false;
    $query->is_singular = false;
    $query->is_attachment = false;
    $query->is_home = false;
    status_header(200);
    return true;
}, 10, 2);

function gya_virtual_page_title($title)
{
    $page = gya_get_virtual_page();
    return $page ? $page['title'] . ' - ' . get_bloginfo('name') : $title;
}
add_filter('pre_get_document_title', 'gya_virtual_page_title', 99);
add_filter('rank_math/frontend/title', 'gya_virtual_page_title', 99);

add_filter('rank_math/frontend/canonical', function ($canonical) {
    global $wp;
    return gya_get_virtual_page() ? home_url('/' . trim($wp->request, '/') . '/') : $canonical;
});

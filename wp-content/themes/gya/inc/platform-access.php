<?php
if (!defined('ABSPATH')) {
    exit;
}

function gya_platform_links()
{
    return array(
        'courses' => 'https://capacitaciongya.educacionitel.com/',
        'monday' => 'https://gya-team.monday.com/',
    );
}

function gya_is_access_page_request()
{
    global $wp;
    return is_page('acceso') || (isset($wp->request) && trim($wp->request, '/') === 'acceso');
}

function gya_access_page_template($template)
{
    if (!gya_is_access_page_request()) {
        return $template;
    }
    global $wp_query;
    $wp_query->is_404 = false;
    status_header(200);
    return get_template_directory() . '/page-access.php';
}
add_filter('template_include', 'gya_access_page_template');


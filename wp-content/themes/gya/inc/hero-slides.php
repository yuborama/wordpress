<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_register_hero_slide_post_type() {
    if (post_type_exists('hero_slide')) {
        return;
    }

    register_post_type(
        'hero_slide',
        array(
            'labels' => array(
                'name' => __('Hero Slides', 'gya'),
                'singular_name' => __('Hero Slide', 'gya'),
                'menu_name' => __('Hero Slides', 'gya'),
                'add_new' => __('Añadir slide', 'gya'),
                'add_new_item' => __('Añadir nuevo slide', 'gya'),
                'edit_item' => __('Editar slide', 'gya'),
                'new_item' => __('Nuevo slide', 'gya'),
                'view_item' => __('Ver slide', 'gya'),
                'search_items' => __('Buscar slides', 'gya'),
                'not_found' => __('No se encontraron slides', 'gya'),
                'not_found_in_trash' => __('No hay slides en la papelera', 'gya'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_icon' => 'dashicons-images-alt2',
            'supports' => array('title', 'thumbnail', 'page-attributes'),
            'capability_type' => 'post',
            'has_archive' => false,
            'rewrite' => false,
        )
    );
}
add_action('init', 'gya_register_hero_slide_post_type');

function gya_get_hero_slides_from_posts() {
    $query = new WP_Query(
        array(
            'post_type' => 'hero_slide',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'hero_is_active',
                    'value' => '1',
                    'compare' => '=',
                ),
            ),
        )
    );

    if (!$query->have_posts()) {
        return array();
    }

    $slides = array();

    while ($query->have_posts()) {
        $query->the_post();

        $post_id = get_the_ID();
        $image_url = get_the_post_thumbnail_url($post_id, 'full');

        $slides[] = array(
            'eyebrow' => gya_get_post_field_value('hero_tag', $post_id),
            'title' => gya_get_post_field_value('hero_tittle', $post_id, gya_get_post_field_value('hero_title', $post_id, get_the_title($post_id))),
            'strong' => '',
            'body' => gya_get_post_field_value('hero_description', $post_id),
            'cta' => gya_get_post_field_value('hero_button_text', $post_id),
            'href' => gya_get_post_field_value('hero_button_url', $post_id, '#contacto'),
            'image' => $image_url ? $image_url : '',
            'position' => 'center center',
        );
    }

    wp_reset_postdata();

    return $slides;
}

function gya_register_hero_slide_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(
        array(
            'key' => 'group_gya_hero_slide_fields',
            'title' => 'Hero Slide',
            'fields' => array(
                array(
                    'key' => 'field_gya_slide_hero_tag',
                    'label' => 'Etiqueta',
                    'name' => 'hero_tag',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_gya_slide_hero_title',
                    'label' => 'Título',
                    'name' => 'hero_title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_gya_slide_hero_description',
                    'label' => 'Descripción',
                    'name' => 'hero_description',
                    'type' => 'textarea',
                    'rows' => 3,
                ),
                array(
                    'key' => 'field_gya_slide_hero_button_text',
                    'label' => 'Texto del botón',
                    'name' => 'hero_button_text',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_gya_slide_hero_button_url',
                    'label' => 'URL del botón',
                    'name' => 'hero_button_url',
                    'type' => 'url',
                ),
                array(
                    'key' => 'field_gya_slide_hero_is_active',
                    'label' => 'Activo',
                    'name' => 'hero_is_active',
                    'type' => 'true_false',
                    'ui' => 1,
                    'default_value' => 1,
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'hero_slide',
                    ),
                ),
            ),
            'position' => 'normal',
            'style' => 'default',
            'active' => true,
        )
    );
}

function gya_home_hero_shortcode() {
    ob_start();

    get_template_part(
        'template-parts/hero',
        null,
        array(
            'data' => gya_get_landing_data(),
            'page_id' => get_queried_object_id(),
        )
    );

    return ob_get_clean();
}
add_shortcode('gya_home_hero', 'gya_home_hero_shortcode');

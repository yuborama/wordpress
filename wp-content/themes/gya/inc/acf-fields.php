<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_register_acf_landing_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    $fields = array(
        array(
            'key' => 'field_gya_tab_hero',
            'label' => 'Hero',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
        ),
        array(
            'key' => 'field_gya_hero_title',
            'label' => 'Hero Titulo',
            'name' => 'gya_hero_title',
            'type' => 'text',
            'default_value' => 'Claridad estrategica',
        ),
        array(
            'key' => 'field_gya_hero_strong',
            'label' => 'Hero Subtitulo destacado',
            'name' => 'gya_hero_strong',
            'type' => 'text',
            'default_value' => 'para empresas en crecimiento.',
        ),
        array(
            'key' => 'field_gya_hero_body',
            'label' => 'Hero Texto',
            'name' => 'gya_hero_body',
            'type' => 'textarea',
            'rows' => 3,
        ),
        array(
            'key' => 'field_gya_hero_cta_text',
            'label' => 'Hero CTA texto',
            'name' => 'gya_hero_cta_text',
            'type' => 'text',
            'default_value' => 'Diagnóstico estratégico',
        ),
        array(
            'key' => 'field_gya_hero_cta_url',
            'label' => 'Hero CTA URL',
            'name' => 'gya_hero_cta_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_gya_hero_image',
            'label' => 'Hero Imagen principal',
            'name' => 'gya_hero_image',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
    );

    $fields[] = array(
        'key' => 'field_gya_tab_stats',
        'label' => 'Metricas',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );

    for ($i = 1; $i <= 4; $i++) {
        $fields[] = array(
            'key' => 'field_gya_stat_' . $i . '_value',
            'label' => 'Metrica ' . $i . ' valor',
            'name' => 'gya_stat_' . $i . '_value',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_stat_' . $i . '_label',
            'label' => 'Metrica ' . $i . ' etiqueta',
            'name' => 'gya_stat_' . $i . '_label',
            'type' => 'text',
        );
    }

    $fields[] = array(
        'key' => 'field_gya_tab_solutions',
        'label' => 'Soluciones',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );
    $fields[] = array(
        'key' => 'field_gya_solutions_heading',
        'label' => 'Titulo de seccion Soluciones',
        'name' => 'gya_solutions_heading',
        'type' => 'text',
    );

    for ($i = 1; $i <= 4; $i++) {
        $fields[] = array(
            'key' => 'field_gya_solution_' . $i . '_title',
            'label' => 'Solucion ' . $i . ' titulo',
            'name' => 'gya_solution_' . $i . '_title',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_solution_' . $i . '_body',
            'label' => 'Solucion ' . $i . ' texto',
            'name' => 'gya_solution_' . $i . '_body',
            'type' => 'textarea',
            'rows' => 2,
        );
    }

    $fields[] = array(
        'key' => 'field_gya_tab_services',
        'label' => 'Servicios',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );
    $fields[] = array(
        'key' => 'field_gya_services_heading',
        'label' => 'Titulo de seccion Servicios',
        'name' => 'gya_services_heading',
        'type' => 'text',
    );

    for ($i = 1; $i <= 3; $i++) {
        $fields[] = array(
            'key' => 'field_gya_service_' . $i . '_title',
            'label' => 'Servicio ' . $i . ' titulo',
            'name' => 'gya_service_' . $i . '_title',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_service_' . $i . '_body',
            'label' => 'Servicio ' . $i . ' texto',
            'name' => 'gya_service_' . $i . '_body',
            'type' => 'textarea',
            'rows' => 2,
        );
        $fields[] = array(
            'key' => 'field_gya_service_' . $i . '_image',
            'label' => 'Servicio ' . $i . ' imagen',
            'name' => 'gya_service_' . $i . '_image',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
        );
    }

    $fields[] = array(
        'key' => 'field_gya_tab_insights',
        'label' => 'Insights',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );
    $fields[] = array(
        'key' => 'field_gya_insights_heading',
        'label' => 'Titulo de seccion Insights',
        'name' => 'gya_insights_heading',
        'type' => 'text',
    );

    for ($i = 1; $i <= 3; $i++) {
        $fields[] = array(
            'key' => 'field_gya_insight_' . $i . '_tag',
            'label' => 'Insight ' . $i . ' categoria',
            'name' => 'gya_insight_' . $i . '_tag',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_insight_' . $i . '_title',
            'label' => 'Insight ' . $i . ' titulo',
            'name' => 'gya_insight_' . $i . '_title',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_insight_' . $i . '_body',
            'label' => 'Insight ' . $i . ' texto',
            'name' => 'gya_insight_' . $i . '_body',
            'type' => 'textarea',
            'rows' => 2,
        );
        $fields[] = array(
            'key' => 'field_gya_insight_' . $i . '_author',
            'label' => 'Insight ' . $i . ' autor',
            'name' => 'gya_insight_' . $i . '_author',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_insight_' . $i . '_image',
            'label' => 'Insight ' . $i . ' imagen',
            'name' => 'gya_insight_' . $i . '_image',
            'type' => 'image',
            'return_format' => 'url',
            'preview_size' => 'medium',
            'library' => 'all',
        );
    }

    $fields[] = array(
        'key' => 'field_gya_tab_cta',
        'label' => 'CTA',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );
    $fields[] = array(
        'key' => 'field_gya_cta_title',
        'label' => 'CTA Titulo',
        'name' => 'gya_cta_title',
        'type' => 'text',
        'default_value' => 'Mas que servicios, construimos relaciones.',
    );
    $fields[] = array(
        'key' => 'field_gya_cta_body',
        'label' => 'CTA Texto',
        'name' => 'gya_cta_body',
        'type' => 'textarea',
        'rows' => 3,
    );
    $fields[] = array(
        'key' => 'field_gya_cta_link_text',
        'label' => 'CTA Link texto',
        'name' => 'gya_cta_link_text',
        'type' => 'text',
        'default_value' => 'Hablemos de tu empresa',
    );
    $fields[] = array(
        'key' => 'field_gya_cta_link_url',
        'label' => 'CTA Link URL',
        'name' => 'gya_cta_link_url',
        'type' => 'url',
    );
    $fields[] = array(
        'key' => 'field_gya_cta_image',
        'label' => 'CTA Imagen',
        'name' => 'gya_cta_image',
        'type' => 'image',
        'return_format' => 'url',
        'preview_size' => 'medium',
        'library' => 'all',
    );

    $fields[] = array(
        'key' => 'field_gya_tab_team',
        'label' => 'Equipo',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );
    $fields[] = array(
        'key' => 'field_gya_team_heading',
        'label' => 'Titulo de seccion Equipo',
        'name' => 'gya_team_heading',
        'type' => 'text',
    );

    for ($i = 1; $i <= 4; $i++) {
        $fields[] = array(
            'key' => 'field_gya_team_' . $i . '_name',
            'label' => 'Integrante ' . $i . ' nombre',
            'name' => 'gya_team_' . $i . '_name',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_team_' . $i . '_role',
            'label' => 'Integrante ' . $i . ' puesto',
            'name' => 'gya_team_' . $i . '_role',
            'type' => 'text',
        );
    }

    $fields[] = array(
        'key' => 'field_gya_tab_header_footer',
        'label' => 'Header y Footer',
        'name' => '',
        'type' => 'tab',
        'placement' => 'top',
    );
    $fields[] = array(
        'key' => 'field_gya_header_cta_text',
        'label' => 'Header boton texto',
        'name' => 'gya_header_cta_text',
        'type' => 'text',
            'default_value' => 'Diagnóstico estratégico',
    );
    $fields[] = array(
        'key' => 'field_gya_header_cta_url',
        'label' => 'Header boton URL',
        'name' => 'gya_header_cta_url',
        'type' => 'url',
    );

    for ($i = 1; $i <= 3; $i++) {
        $fields[] = array(
            'key' => 'field_gya_footer_legal_' . $i . '_text',
            'label' => 'Footer legal link ' . $i . ' texto',
            'name' => 'gya_footer_legal_' . $i . '_text',
            'type' => 'text',
        );
        $fields[] = array(
            'key' => 'field_gya_footer_legal_' . $i . '_url',
            'label' => 'Footer legal link ' . $i . ' URL',
            'name' => 'gya_footer_legal_' . $i . '_url',
            'type' => 'url',
        );
    }

    $fields[] = array(
        'key' => 'field_gya_footer_text_1',
        'label' => 'Footer texto legal 1',
        'name' => 'gya_footer_text_1',
        'type' => 'textarea',
        'rows' => 3,
    );
    $fields[] = array(
        'key' => 'field_gya_footer_text_2',
        'label' => 'Footer texto legal 2',
        'name' => 'gya_footer_text_2',
        'type' => 'textarea',
        'rows' => 3,
    );
    $fields[] = array(
        'key' => 'field_gya_footer_copyright',
        'label' => 'Footer copyright',
        'name' => 'gya_footer_copyright',
        'type' => 'text',
    );

    acf_add_local_field_group(array(
        'key' => 'group_gya_landing_content',
        'title' => 'GYA Landing Content',
        'fields' => $fields,
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'position' => 'normal',
        'style' => 'default',
        'active' => true,
    ));
}
add_action('acf/init', 'gya_register_acf_landing_fields');

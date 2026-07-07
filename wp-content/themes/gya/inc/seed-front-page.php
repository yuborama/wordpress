<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_seed_front_page_fields() {
    if (!is_admin()) {
        return;
    }

    if (!function_exists('update_field') || !function_exists('get_field')) {
        return;
    }

    if (get_option('gya_front_page_seeded') === '1') {
        return;
    }

    $front_page_id = (int) get_option('page_on_front');
    if ($front_page_id <= 0) {
        return;
    }

    $data = gya_get_landing_data();

    $seed_values = array(
        'gya_hero_title' => $data['hero_slides'][0]['title'],
        'gya_hero_strong' => $data['hero_slides'][0]['strong'],
        'gya_hero_body' => $data['hero_slides'][0]['body'],
        'gya_hero_cta_text' => $data['hero_slides'][0]['cta'],
        'gya_hero_cta_url' => $data['hero_slides'][0]['href'],
        'gya_cta_title' => 'Más que servicios, construimos relaciones.',
        'gya_cta_body' => 'G&A es una firma boutique que acompaña a empresas con claridad, experiencia y atención personalizada.',
        'gya_cta_link_text' => 'Hablemos de tu empresa',
        'gya_cta_link_url' => '#contacto',
        'gya_solutions_heading' => 'Acompañamos cada área clave de tu empresa.',
        'gya_services_heading' => 'Soluciones a los retos que realmente impactan tu negocio.',
        'gya_insights_heading' => 'Información clave para tomar mejores decisiones.',
        'gya_team_heading' => 'Profesionales que entienden tu negocio y hablan tu idioma.',
        'gya_header_cta_text' => 'Diagnóstico estratégico',
        'gya_header_cta_url' => '#contacto',
        'gya_footer_legal_1_text' => 'Términos de uso',
        'gya_footer_legal_1_url' => '#terminos',
        'gya_footer_legal_2_text' => 'Aviso de privacidad',
        'gya_footer_legal_2_url' => '#privacidad',
        'gya_footer_legal_3_text' => 'Aviso de manejo de cookies',
        'gya_footer_legal_3_url' => '#cookies',
        'gya_footer_text_1' => 'G&A Gómez y Asociados (G&A) es una firma especializada en servicios fiscales, legales, financieros y de consultoría empresarial. La prestación de servicios se realiza conforme a la naturaleza y alcance de cada proyecto, bajo criterios de independencia profesional y cumplimiento normativo.',
        'gya_footer_text_2' => 'La información publicada en este sitio tiene carácter informativo y no representa una opinión profesional definitiva ni sustituye asesoría especializada para casos concretos.',
        'gya_footer_copyright' => 'G&A Gómez y Asociados, S.C.',
    );

    foreach ($data['stats'] as $index => $stat) {
        $n = $index + 1;
        $seed_values['gya_stat_' . $n . '_value'] = isset($stat['value']) ? $stat['value'] : '';
        $seed_values['gya_stat_' . $n . '_label'] = isset($stat['label']) ? $stat['label'] : '';
        $seed_values['gya_stat_' . $n . '_icon'] = isset($stat['icon']) ? $stat['icon'] : '';
    }

    foreach ($data['solutions'] as $index => $solution) {
        $n = $index + 1;
        $seed_values['gya_solution_' . $n . '_title'] = $solution['title'];
        $seed_values['gya_solution_' . $n . '_body'] = $solution['body'];
    }

    foreach ($data['services'] as $index => $service) {
        $n = $index + 1;
        $seed_values['gya_service_' . $n . '_title'] = $service['title'];
        $seed_values['gya_service_' . $n . '_body'] = $service['body'];
    }

    foreach ($data['insights'] as $index => $insight) {
        $n = $index + 1;
        $seed_values['gya_insight_' . $n . '_tag'] = $insight['tag'];
        $seed_values['gya_insight_' . $n . '_title'] = $insight['title'];
        $seed_values['gya_insight_' . $n . '_body'] = $insight['body'];
        $seed_values['gya_insight_' . $n . '_author'] = $insight['author'];
    }

    foreach ($data['team'] as $index => $member) {
        $n = $index + 1;
        $seed_values['gya_team_' . $n . '_name'] = $member['name'];
        $seed_values['gya_team_' . $n . '_role'] = $member['role'];
    }

    foreach ($seed_values as $field_name => $seed_value) {
        $current_value = get_field($field_name, $front_page_id);
        if ($current_value === null || $current_value === false || $current_value === '') {
            update_field($field_name, $seed_value, $front_page_id);
        }
    }

    update_option('gya_front_page_seeded', '1');
}
add_action('admin_init', 'gya_seed_front_page_fields');

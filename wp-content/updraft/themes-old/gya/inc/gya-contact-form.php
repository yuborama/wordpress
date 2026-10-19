<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_handle_contact_form()
{
    if (!isset($_POST['gya_contact_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['gya_contact_nonce'])), 'gya_contact_form')) {
        wp_send_json_error(array('message' => 'Solicitud inválida.'), 403);
    }

    $required_fields = array('name', 'position', 'email', 'company', 'message');

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_send_json_error(array('message' => 'Por favor completa todos los campos obligatorios.'), 400);
        }
    }

    $email = sanitize_email(wp_unslash($_POST['email']));

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'El correo electrónico no es válido.'), 400);
    }

    $data = array(
        'area' => sanitize_text_field(wp_unslash($_POST['area'] ?? '')),
        'name' => sanitize_text_field(wp_unslash($_POST['name'] ?? '')),
        'position' => sanitize_text_field(wp_unslash($_POST['position'] ?? '')),
        'email' => $email,
        'phone' => sanitize_text_field(wp_unslash($_POST['phone'] ?? '')),
        'company' => sanitize_text_field(wp_unslash($_POST['company'] ?? '')),
        'message' => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
    );

    $result = gya_send_email_with_resend($data);

    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => 'No se pudo enviar el formulario. Intenta nuevamente.'), 500);
    }

    wp_send_json_success(array('message' => 'Tu solicitud fue enviada correctamente.'));
}
add_action('wp_ajax_gya_contact_form', 'gya_handle_contact_form');
add_action('wp_ajax_nopriv_gya_contact_form', 'gya_handle_contact_form');

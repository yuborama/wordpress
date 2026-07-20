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

    $file = null;

    if (!empty($_FILES['document']['name'])) {
        $validation = gya_validate_contact_file($_FILES['document']);

        if (is_wp_error($validation)) {
            wp_send_json_error(array('message' => $validation->get_error_message()), 400);
        }

        $file = $_FILES['document'];
    }

    $result = gya_send_email_with_resend($data, $file);

    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => 'No se pudo enviar el formulario. Intenta nuevamente.'), 500);
    }

    wp_send_json_success(array('message' => 'Tu solicitud fue enviada correctamente.'));
}
add_action('wp_ajax_gya_contact_form', 'gya_handle_contact_form');
add_action('wp_ajax_nopriv_gya_contact_form', 'gya_handle_contact_form');

function gya_validate_contact_file($file)
{
    $max_size = 10 * 1024 * 1024;

    if (!empty($file['error']) && $file['error'] !== UPLOAD_ERR_OK) {
        return new WP_Error('gya_file_upload_error', 'No se pudo cargar el archivo.');
    }

    if (!empty($file['size']) && $file['size'] > $max_size) {
        return new WP_Error('gya_file_too_large', 'El archivo no puede superar los 10 MB.');
    }

    $allowed_mimes = array(
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
    );

    $filetype = wp_check_filetype_and_ext($file['tmp_name'], $file['name'], $allowed_mimes);

    if (empty($filetype['ext']) || empty($filetype['type'])) {
        return new WP_Error('gya_invalid_file_type', 'Formato no permitido. Usa PDF, Excel, Word o imágenes.');
    }

    return true;
}

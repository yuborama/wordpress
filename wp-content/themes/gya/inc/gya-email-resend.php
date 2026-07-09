<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_get_resend_api_key()
{
    if (defined('GYA_RESEND_API_KEY') && GYA_RESEND_API_KEY) {
        return GYA_RESEND_API_KEY;
    }

    return get_option('gya_resend_api_key', '');
}

function gya_send_email_with_resend($data, $file = null)
{
    $api_key = gya_get_resend_api_key();
    $from = get_option('gya_email_from', '');
    $to = get_option('gya_email_to', '');
    $subject = get_option('gya_email_subject', 'Nueva solicitud de diagnóstico');

    if (!$api_key || !$from || !$to) {
        return new WP_Error('gya_email_config_missing', 'Falta configurar la API Key, remitente o destinatario.');
    }

    $payload = array(
        'from' => $from,
        'to' => array($to),
        'subject' => $subject,
        'html' => gya_build_contact_email_html($data),
        'reply_to' => !empty($data['email']) ? $data['email'] : null,
    );

    if ($file && !empty($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) {
        $file_content = file_get_contents($file['tmp_name']);

        if ($file_content !== false) {
            $payload['attachments'] = array(
                array(
                    'filename' => sanitize_file_name($file['name']),
                    'content' => base64_encode($file_content),
                ),
            );
        }
    }

    $payload = array_filter(
        $payload,
        function ($value) {
            return $value !== null && $value !== '';
        }
    );

    $response = wp_remote_post(
        'https://api.resend.com/emails',
        array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json',
            ),
            'body' => wp_json_encode($payload),
            'timeout' => 30,
        )
    );

    if (is_wp_error($response)) {
        return $response;
    }

    $status_code = wp_remote_retrieve_response_code($response);

    if ($status_code < 200 || $status_code >= 300) {
        return new WP_Error('gya_resend_error', 'No se pudo enviar el correo.');
    }

    return $body;
}

function gya_build_contact_email_html($data)
{
    $fields = array(
        'Área de interés' => $data['area'] ?? '',
        'Nombre completo' => $data['name'] ?? '',
        'Puesto' => $data['position'] ?? '',
        'Correo electrónico' => $data['email'] ?? '',
        'Teléfono / WhatsApp' => $data['phone'] ?? '',
        'Compañía / Organización' => $data['company'] ?? '',
        'Ingresos anuales' => $data['income'] ?? '',
    );

    $rows = '';

    foreach ($fields as $label => $value) {
        $rows .= '<p><strong>' . esc_html($label) . ':</strong> ' . esc_html($value) . '</p>';
    }

    $message = nl2br(esc_html($data['message'] ?? ''));

    return '
        <h2>Nueva solicitud de diagnóstico</h2>
        ' . $rows . '
        <hr>
        <p><strong>Necesidad:</strong></p>
        <p>' . $message . '</p>
    ';
}

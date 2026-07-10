<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_register_email_settings_page()
{
    add_menu_page(
        'Configuración GYA',
        'GYA Config',
        'manage_options',
        'gya-email-settings',
        'gya_render_email_settings_page',
        'dashicons-admin-generic',
        60
    );
}
add_action('admin_menu', 'gya_register_email_settings_page');

function gya_social_networks()
{
    return array(
        'facebook' => array(
            'label' => 'Facebook',
            'option' => 'gya_social_facebook',
            'icon' => 'facebook.svg',
            'placeholder' => 'https://facebook.com/gya',
        ),
        'linkedin' => array(
            'label' => 'LinkedIn',
            'option' => 'gya_social_linkedin',
            'icon' => 'linkedin.svg',
            'placeholder' => 'https://linkedin.com/company/gya',
        ),
        'youtube' => array(
            'label' => 'YouTube',
            'option' => 'gya_social_youtube',
            'icon' => 'youtube.svg',
            'placeholder' => 'https://youtube.com/@gya',
        ),
        'whatsapp' => array(
            'label' => 'WhatsApp',
            'option' => 'gya_social_whatsapp',
            'icon' => 'whatsapp.svg',
            'placeholder' => 'https://wa.me/5210000000000',
        ),
        'tiktok' => array(
            'label' => 'TikTok',
            'option' => 'gya_social_tiktok',
            'icon' => 'tiktok.svg',
            'placeholder' => 'https://tiktok.com/@gya',
        ),
    );
}

function gya_register_email_settings()
{
    register_setting('gya_email_settings_group', 'gya_resend_api_key');
    register_setting('gya_email_settings_group', 'gya_email_from');
    register_setting('gya_email_settings_group', 'gya_email_to');
    register_setting('gya_email_settings_group', 'gya_email_subject');

    foreach (gya_social_networks() as $network) {
        register_setting(
            'gya_email_settings_group',
            $network['option'],
            array(
                'sanitize_callback' => 'esc_url_raw',
            )
        );
    }
}
add_action('admin_init', 'gya_register_email_settings');

function gya_render_email_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $api_key = get_option('gya_resend_api_key', '');
    $from = get_option('gya_email_from', '');
    $to = get_option('gya_email_to', '');
    $subject = get_option('gya_email_subject', 'Nueva solicitud de diagnóstico');
    ?>
    <div class="wrap">
        <h1>Configuración GYA</h1>

        <form method="post" action="options.php">
            <?php settings_fields('gya_email_settings_group'); ?>

            <h2>Emails</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="gya_resend_api_key">API Key de Resend</label></th>
                    <td>
                        <input type="password" name="gya_resend_api_key" id="gya_resend_api_key" value="<?php echo esc_attr($api_key); ?>" class="regular-text" autocomplete="off">
                        <p class="description">También puedes definir <code>GYA_RESEND_API_KEY</code> en <code>wp-config.php</code>.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="gya_email_from">Correo remitente</label></th>
                    <td>
                        <input type="text" name="gya_email_from" id="gya_email_from" value="<?php echo esc_attr($from); ?>" class="regular-text" placeholder="G&A <contacto@tudominio.com>">
                        <p class="description">El dominio del remitente debe estar verificado en Resend.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="gya_email_to">Correo destinatario</label></th>
                    <td>
                        <input type="email" name="gya_email_to" id="gya_email_to" value="<?php echo esc_attr($to); ?>" class="regular-text" placeholder="admin@tudominio.com">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="gya_email_subject">Asunto por defecto</label></th>
                    <td>
                        <input type="text" name="gya_email_subject" id="gya_email_subject" value="<?php echo esc_attr($subject); ?>" class="regular-text">
                    </td>
                </tr>
            </table>

            <h2>Redes sociales</h2>
            <p class="description">Estas URLs se muestran en el footer cuando están configuradas.</p>

            <table class="form-table" role="presentation">
                <?php foreach (gya_social_networks() as $network) : ?>
                    <?php $value = get_option($network['option'], ''); ?>
                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($network['option']); ?>"><?php echo esc_html($network['label']); ?></label></th>
                        <td>
                            <input type="url" name="<?php echo esc_attr($network['option']); ?>" id="<?php echo esc_attr($network['option']); ?>" value="<?php echo esc_attr($value); ?>" class="regular-text" placeholder="<?php echo esc_attr($network['placeholder']); ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <?php submit_button('Guardar configuración'); ?>
        </form>
    </div>
    <?php
}

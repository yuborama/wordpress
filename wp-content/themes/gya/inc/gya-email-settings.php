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

function gya_enqueue_config_media($hook_suffix)
{
    if ($hook_suffix !== 'toplevel_page_gya-email-settings') {
        return;
    }

    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'gya_enqueue_config_media');

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
    register_setting(
        'gya_email_settings_group',
        'gya_contact_phone',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    register_setting(
        'gya_email_settings_group',
        'gya_hero_duration_seconds',
        array(
            'sanitize_callback' => 'absint',
        )
    );
    register_setting(
        'gya_email_settings_group',
        'gya_carousel_duration_seconds',
        array(
            'sanitize_callback' => 'absint',
        )
    );
    register_setting(
        'gya_email_settings_group',
        'gya_relations_image_id',
        array(
            'sanitize_callback' => 'absint',
        )
    );
    register_setting(
        'gya_email_settings_group',
        'gya_contact_image_id',
        array(
            'sanitize_callback' => 'absint',
        )
    );

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

function gya_get_duration_ms($option_name, $default_seconds = 10)
{
    $seconds = absint(get_option($option_name, $default_seconds));

    if ($seconds < 1) {
        $seconds = absint($default_seconds);
    }

    return $seconds * 1000;
}

function gya_render_email_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $api_key = get_option('gya_resend_api_key', '');
    $from = get_option('gya_email_from', '');
    $to = get_option('gya_email_to', '');
    $subject = get_option('gya_email_subject', 'Nueva solicitud de diagnóstico');
    $phone = get_option('gya_contact_phone', '');
    $hero_duration = absint(get_option('gya_hero_duration_seconds', 10));
    $carousel_duration = absint(get_option('gya_carousel_duration_seconds', 10));
    $relations_image_id = absint(get_option('gya_relations_image_id', 0));
    $relations_image_url = $relations_image_id ? wp_get_attachment_image_url($relations_image_id, 'medium') : '';
    $contact_image_id = absint(get_option('gya_contact_image_id', 0));
    $contact_image_url = $contact_image_id ? wp_get_attachment_image_url($contact_image_id, 'medium') : '';
    ?>
    <div class="wrap">
        <h1>Configuración GYA</h1>

        <form method="post" action="options.php">
            <?php settings_fields('gya_email_settings_group'); ?>

            <h2>Página de inicio</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Más que servicios</th>
                    <td>
                        <input type="hidden" name="gya_relations_image_id" id="gya_relations_image_id" value="<?php echo esc_attr((string) $relations_image_id); ?>">
                        <div id="gya_relations_image_preview" style="margin-bottom: 10px;">
                            <?php if ($relations_image_url) : ?>
                                <img src="<?php echo esc_url($relations_image_url); ?>" alt="" style="display: block; max-width: 300px; height: auto;">
                            <?php endif; ?>
                        </div>
                        <button type="button" class="button gya-select-image" data-target="gya_relations_image_id">Seleccionar imagen</button>
                        <button type="button" class="button gya-remove-image" data-target="gya_relations_image_id"<?php echo $relations_image_id ? '' : ' style="display:none;"'; ?>>Quitar imagen</button>
                        <p class="description">Imagen de la sección “Más que servicios, construimos relaciones”.</p>
                    </td>
                </tr>
            </table>

            <h2>Página de contacto</h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row">Imagen del formulario</th>
                    <td>
                        <input type="hidden" name="gya_contact_image_id" id="gya_contact_image_id" value="<?php echo esc_attr((string) $contact_image_id); ?>">
                        <div id="gya_contact_image_preview" style="margin-bottom: 10px;">
                            <?php if ($contact_image_url) : ?>
                                <img src="<?php echo esc_url($contact_image_url); ?>" alt="" style="display: block; max-width: 300px; height: auto;">
                            <?php endif; ?>
                        </div>
                        <button type="button" class="button gya-select-image" data-target="gya_contact_image_id">Seleccionar imagen</button>
                        <button type="button" class="button gya-remove-image" data-target="gya_contact_image_id"<?php echo $contact_image_id ? '' : ' style="display:none;"'; ?>>Quitar imagen</button>
                        <p class="description">Imagen vertical que aparece al lado derecho del formulario de contacto.</p>
                    </td>
                </tr>
            </table>

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
                <tr>
                    <th scope="row"><label for="gya_contact_phone">Teléfono de contacto</label></th>
                    <td>
                        <input type="text" name="gya_contact_phone" id="gya_contact_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" placeholder="+52 55 0000 0000">
                        <p class="description">Se usa en enlaces de teléfono del sitio, como el detalle del equipo.</p>
                    </td>
                </tr>
            </table>

            <h2>Animaciones</h2>
            <p class="description">Configura la duración automática de banners y carruseles en segundos.</p>

            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="gya_hero_duration_seconds">Duración del hero</label></th>
                    <td>
                        <input type="number" min="1" step="1" name="gya_hero_duration_seconds" id="gya_hero_duration_seconds" value="<?php echo esc_attr((string) ($hero_duration ?: 10)); ?>" class="small-text"> segundos
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="gya_carousel_duration_seconds">Duración de carruseles</label></th>
                    <td>
                        <input type="number" min="1" step="1" name="gya_carousel_duration_seconds" id="gya_carousel_duration_seconds" value="<?php echo esc_attr((string) ($carousel_duration ?: 10)); ?>" class="small-text"> segundos
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
    <script>
        jQuery(function ($) {
            $('.gya-select-image').on('click', function (event) {
                event.preventDefault();

                var targetId = $(this).data('target');
                var $imageId = $('#' + targetId);
                var $preview = $('#' + targetId.replace('_id', '_preview'));
                var $removeButton = $('.gya-remove-image[data-target="' + targetId + '"]');
                var mediaFrame = wp.media({
                    title: 'Seleccionar imagen',
                    button: { text: 'Usar esta imagen' },
                    library: { type: 'image' },
                    multiple: false
                });

                mediaFrame.on('select', function () {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    var previewUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;

                    $imageId.val(attachment.id);
                    $preview.html($('<img>', {
                        src: previewUrl,
                        alt: '',
                        css: { display: 'block', maxWidth: '300px', height: 'auto' }
                    }));
                    $removeButton.show();
                });

                mediaFrame.open();
            });

            $('.gya-remove-image').on('click', function (event) {
                event.preventDefault();

                var targetId = $(this).data('target');

                $('#' + targetId).val('');
                $('#' + targetId.replace('_id', '_preview')).empty();
                $(this).hide();
            });
        });
    </script>
    <?php
}

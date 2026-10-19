<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();

$cta_title = gya_get_field_value('gya_cta_title', 'Más que servicios, construimos relaciones.', $page_id);
$cta_body = gya_get_field_value('gya_cta_body', 'G&A es una firma boutique que acompaña a empresas con claridad, experiencia y atención personalizada.', $page_id);
$cta_link_text = gya_get_field_value('gya_cta_link_text', 'Hablemos de tu empresa', $page_id);
$cta_link_url = gya_get_field_value('gya_cta_link_url', '/contact', $page_id);
$upload_dir = wp_upload_dir();
$cta_banner_image = trailingslashit($upload_dir['baseurl']) . '2026/07/Banner-contacto.png';

?>
<section class="cta-shell" id="nosotros">
    <div class="shell">
        <article class="cta-banner" style="background-image:url('<?php echo esc_url($cta_banner_image); ?>');">
            <div class="cta-copy">
                <h2><?php echo esc_html($cta_title); ?></h2>
                <p><?php echo esc_html($cta_body); ?></p>
                <a class="outline-link" href="<?php echo esc_url($cta_link_url); ?>"><?php echo esc_html($cta_link_text); ?> <span>&rsaquo;</span></a>
            </div>
        </article>
    </div>
</section>

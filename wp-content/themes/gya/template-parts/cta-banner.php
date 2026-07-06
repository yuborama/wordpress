<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();

$cta_title = gya_get_field_value('gya_cta_title', 'Más que servicios, construimos relaciones.', $page_id);
$cta_body = gya_get_field_value('gya_cta_body', 'G&A es una firma boutique que acompaña a empresas con claridad, experiencia y atención personalizada.', $page_id);
$cta_link_text = gya_get_field_value('gya_cta_link_text', 'Hablemos de tu empresa', $page_id);
$cta_link_url = gya_get_field_value('gya_cta_link_url', '#contacto', $page_id);
$cta_image = gya_get_field_value('gya_cta_image', gya_asset_uri('assets/images/insightsCardTeam.jpg'), $page_id);
$banner_bg = gya_asset_uri('assets/images/insightsBanner.jpg');
?>
<section class="cta-shell" id="nosotros">
    <div class="shell">
        <article class="cta-banner">
            <div class="cta-copy" style="background-image:url('<?php echo esc_url($banner_bg); ?>');">
                <h2><?php echo esc_html($cta_title); ?></h2>
                <p><?php echo esc_html($cta_body); ?></p>
                <a class="outline-link" href="<?php echo esc_url($cta_link_url); ?>"><?php echo esc_html($cta_link_text); ?> <span>&rsaquo;</span></a>
            </div>
            <div class="cta-photo" style="background-image:url('<?php echo esc_url($cta_image); ?>');"></div>
        </article>
    </div>
</section>

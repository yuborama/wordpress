<?php
$front_page_id = (int) get_option('page_on_front');
$footer_legal_links = array(
    array(
        'text' => gya_get_field_value('gya_footer_legal_2_text', 'Aviso de privacidad', $front_page_id),
        'url' => gya_get_field_value('gya_footer_legal_2_url', '#privacidad', $front_page_id),
    ),
    array(
        'text' => gya_get_field_value('gya_footer_legal_3_text', 'Aviso de manejo de cookies', $front_page_id),
        'url' => gya_get_field_value('gya_footer_legal_3_url', '#cookies', $front_page_id),
    ),
);
$footer_text_1 = gya_get_field_value('gya_footer_text_1', 'G&A Gómez y Asociados (G&A) es una firma especializada en servicios fiscales, legales, financieros y de consultoría empresarial. La prestación de servicios se realiza conforme a la naturaleza y alcance de cada proyecto, bajo criterios de independencia profesional y cumplimiento normativo.', $front_page_id);
$footer_text_2 = gya_get_field_value('gya_footer_text_2', 'La información publicada en este sitio tiene carácter informativo y no representa una opinión profesional definitiva ni sustituye asesoría especializada para casos concretos.', $front_page_id);
$footer_copyright = gya_get_field_value('gya_footer_copyright', 'G&A Gómez y Asociados, S.C.', $front_page_id);

$footer_address = 'Anillo Perif. 3332 piso 1201, Jardines del Pedregal, Álvaro Obregón, 01900 Ciudad de México, CDMX';
$footer_phone = '+52 55 57 40 38 76';
$footer_phone_href = preg_replace('/[^\d+]/', '', $footer_phone);

foreach ($footer_legal_links as &$legal_link) {
    if (!empty($legal_link['url']) && $legal_link['url'] === '#privacidad') {
        $legal_link['url'] = home_url('/aviso-de-privacidad/');
    }

    if (!empty($legal_link['url']) && $legal_link['url'] === '#cookies') {
        $legal_link['url'] = home_url('/cookies/');
    }
}
unset($legal_link);

$footer_social_links = array();
if (function_exists('gya_social_networks')) {
    foreach (gya_social_networks() as $network_key => $network) {
        if ($network_key === 'whatsapp') {
            continue;
        }

        $url = get_option($network['option'], '');

        if (!empty($url)) {
            $footer_social_links[] = array(
                'label' => $network['label'],
                'url' => $url,
                'icon' => get_template_directory_uri() . '/assets/images/icons/social/' . $network['icon'],
            );
        }
    }
}
$whatsapp_url = get_option('gya_social_whatsapp', '');

$has_legal_links = false;
foreach ($footer_legal_links as $legal_link) {
    if (!empty($legal_link['text']) && !empty($legal_link['url'])) {
        $has_legal_links = true;
        break;
    }
}
?>
<footer class="site-footer" id="contacto">
    <div class="shell">
        <a class="footer-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Inicio GYA">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/logo.svg'); ?>" alt="G&amp;A">
        </a>
        <div class="footer-line"></div>
        <nav class="footer-nav" aria-label="Footer">
            <?php if ($has_legal_links) : ?>
                <ul class="menu">
                    <?php foreach ($footer_legal_links as $legal_link) : ?>
                        <?php if (!empty($legal_link['text']) && !empty($legal_link['url'])) : ?>
                            <li><a href="<?php echo esc_url($legal_link['url']); ?>"><?php echo esc_html($legal_link['text']); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'menu',
                        'fallback_cb' => 'gya_footer_menu_fallback',
                    )
                );
                ?>
            <?php endif; ?>
            <?php if (!empty($footer_social_links)) : ?>
                <div class="footer-social" aria-label="Redes sociales">
                    <?php foreach ($footer_social_links as $social_link) : ?>
                        <a href="<?php echo esc_url($social_link['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_link['label']); ?>">
                            <img src="<?php echo esc_url($social_link['icon']); ?>" alt="">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </nav>
        <div class="footer-line"></div>
        <div class="footer-body">
            <address class="footer-contact" aria-label="Dirección">
                <span class="footer-contact-row">
                    <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                        <path d="M12 21s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                        <circle cx="12" cy="9" r="2.4" fill="none" stroke="currentColor" stroke-width="2" />
                    </svg>
                    <span><?php echo esc_html($footer_address); ?></span>
                </span>
                <a class="footer-contact-row" href="tel:<?php echo esc_attr($footer_phone_href); ?>">
                    <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true">
                        <path d="M7 4h3l1.5 4-2 1.2c1 2 2.3 3.3 4.3 4.3l1.2-2 4 1.5v3c0 1.1-.9 2-2 2C10.4 19 5 13.6 5 7c0-1.1.9-2 2-2z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                    </svg>
                    <span><?php echo esc_html($footer_phone); ?></span>
                </a>
            </address>
            <div class="footer-copy">
                <p><?php echo esc_html($footer_text_1); ?></p>
                <p><?php echo esc_html($footer_text_2); ?></p>
                <small>&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html($footer_copyright); ?></small>
            </div>
        </div>
    </div>
</footer>
<?php if (!empty($whatsapp_url)) : ?>
    <a class="floating-whatsapp" href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/social/whatsapp.svg'); ?>" alt="">
    </a>
<?php endif; ?>
<?php wp_footer(); ?>
</body>
</html>

<?php
$front_page_id = (int) get_option('page_on_front');
$footer_legal_links = array(
    array(
        'text' => gya_get_field_value('gya_footer_legal_1_text', 'Términos de uso', $front_page_id),
        'url' => gya_get_field_value('gya_footer_legal_1_url', '#terminos', $front_page_id),
    ),
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

foreach ($footer_legal_links as &$legal_link) {
    if (!empty($legal_link['url']) && $legal_link['url'] === '#privacidad') {
        $legal_link['url'] = home_url('/aviso-de-privacidad/');
    }
}
unset($legal_link);

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
        </nav>
        <div class="footer-line"></div>
        <p><?php echo esc_html($footer_text_1); ?></p>
        <p><?php echo esc_html($footer_text_2); ?></p>
        <small>&copy; <?php echo esc_html(date_i18n('Y')); ?> <?php echo esc_html($footer_copyright); ?></small>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

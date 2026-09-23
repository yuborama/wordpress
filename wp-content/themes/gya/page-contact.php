<?php

if (!defined('ABSPATH')) {
    exit;
}

$areas = get_posts(array(
    'post_type' => 'gya_category',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
));

$upload_dir = wp_upload_dir();
$contact_image_id = absint(get_option('gya_contact_image_id', 0));
$contact_image = $contact_image_id ? wp_get_attachment_image_url($contact_image_id, 'full') : '';

if (!$contact_image) {
    $contact_image = trailingslashit($upload_dir['baseurl']) . '2026/07/EPT.png';
}
$building_image = get_template_directory_uri() . '/assets/images/contact-building.png';
$address = 'Anillo Perif. 3332 piso 1201, Jardines del Pedregal, Álvaro Obregón, 01900 Ciudad de México, CDMX';
$phone = '(+52) 55 57 40 38 76';
$phone_href = preg_replace('/[^0-9+]/', '', $phone);

get_header();
?>
<main class="contact-page">
    <section class="contact-section" aria-labelledby="contact-title">
        <div class="contact-layout">
            <div class="contact-copy">
                <header class="contact-heading">
                    <h1 id="contact-title">CONTACTO</h1>
                    <p>Cuéntanos brevemente qué necesitas y un especialista de G&amp;A te contactará para orientarte.</p>
                </header>

                <form id="gya-contact-form" class="contact-form" enctype="multipart/form-data" novalidate>
                    <?php wp_nonce_field('gya_contact_form', 'gya_contact_nonce'); ?>
                    <label><span>Área de interés</span><select name="area"><option value="">Área de interés</option><?php foreach ($areas as $area) : ?><option value="<?php echo esc_attr(get_the_title($area)); ?>"><?php echo esc_html(get_the_title($area)); ?></option><?php endforeach; ?></select></label>
                    <label><span>Nombre completo*</span><input type="text" name="name" placeholder="Nombre completo*" autocomplete="name" required></label>
                    <label><span>Puesto*</span><input type="text" name="position" placeholder="Puesto*" autocomplete="organization-title" required></label>
                    <label><span>Correo electrónico*</span><input type="email" name="email" placeholder="Correo electrónico*" autocomplete="email" required></label>
                    <label><span>Teléfono / WhatsApp</span><input type="tel" name="phone" placeholder="Teléfono / WhatsApp" autocomplete="tel"></label>
                    <label><span>Compañía / Organización*</span><input type="text" name="company" placeholder="Compañía / Organización*" autocomplete="organization" required></label>

                    <label class="contact-file">
                        <span class="contact-file__button">Adjuntar documento</span>
                        <input type="file" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.webp">
                    </label>
                    <p class="contact-file-help">Formatos permitidos: PDF, Excel, Word e imágenes. Tamaño máximo: 10 MB.</p>
                    <p class="contact-file-name" data-file-name></p>
                    <label><span>Describe tu necesidad</span><textarea name="message" placeholder="Describe tu necesidad" required></textarea></label>

                    <button class="contact-submit" type="submit"><span>SOLICITAR DIAGNÓSTICO</span><span class="contact-submit__arrow" aria-hidden="true">→</span></button>
                    <p class="contact-message" id="gya-contact-message" role="status" aria-live="polite"></p>
                </form>
            </div>

            <div class="contact-visual" aria-hidden="true">
                <img src="<?php echo esc_url($contact_image); ?>" alt="">
            </div>
        </div>
    </section>

    <section class="contact-facilities" aria-labelledby="facilities-title">
        <div class="shell">
            <h2 id="facilities-title">NUESTRAS INSTALACIONES</h2>
            <div class="contact-facilities__grid">
                <img src="<?php echo esc_url($building_image); ?>" alt="Edificio de las oficinas de G&amp;A">
                <address class="contact-address">
                    <p><?php echo esc_html($address); ?></p>
                    <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                </address>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>

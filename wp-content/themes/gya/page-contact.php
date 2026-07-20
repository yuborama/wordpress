<?php

if (!defined('ABSPATH')) {
    exit;
}

$areas = get_posts(
    array(
        'post_type' => 'gya_category',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    )
);

$upload_dir = wp_upload_dir();
$uploads_base = trailingslashit($upload_dir['baseurl']) . '2026/07/';
$office_image = $uploads_base . 'office.jpg';
$network_image = $uploads_base . 'network-bg.png';

$director_query = new WP_Query(
    array(
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'ASC',
        'no_found_rows' => true,
    )
);

$director = array(
    'name' => 'José Luis Gómez González',
    'position' => 'Socio Director',
    'image' => $uploads_base . 'team1.jpg',
);

if ($director_query->have_posts()) {
    $director_query->the_post();

    $director_id = get_the_ID();
    $director_image = gya_get_post_field_value('image', $director_id, '');
    $director_image_url = '';

    if (is_array($director_image) && isset($director_image['url'])) {
        $director_image_url = $director_image['url'];
    } elseif (is_numeric($director_image)) {
        $director_image_url = wp_get_attachment_image_url((int) $director_image, 'large');
    } elseif (is_string($director_image)) {
        $director_image_url = $director_image;
    }

    if (!$director_image_url && has_post_thumbnail($director_id)) {
        $director_image_url = get_the_post_thumbnail_url($director_id, 'large');
    }

    $director = array(
        'name' => gya_get_post_field_value('name', $director_id, get_the_title()),
        'position' => gya_get_post_field_value('position', $director_id, 'Socio Director'),
        'image' => $director_image_url ?: $director['image'],
    );

    wp_reset_postdata();
}


get_header();
?>
<main class="contact-page">
    <section class="contact-section">
        <div class="shell contact-layout">
            <div class="contact-copy">
                <header class="contact-heading">
                    <h1>Hablemos <strong>de tu empresa</strong></h1>
                    <p>Cuéntanos brevemente qué necesitas y un especialista de G&amp;A te contactará para orientarte.</p>
                </header>

                <form id="gya-contact-form" class="contact-form" enctype="multipart/form-data" novalidate>
                    <?php wp_nonce_field('gya_contact_form', 'gya_contact_nonce'); ?>

                    <label>
                        <span>Área de interés</span>
                        <select name="area">
                            <option value="">Área de interés</option>
                            <?php foreach ($areas as $area) : ?>
                                <option value="<?php echo esc_attr(get_the_title($area)); ?>"><?php echo esc_html(get_the_title($area)); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span>Nombre completo*</span>
                        <input type="text" name="name" placeholder="Nombre completo*" required>
                    </label>

                    <label>
                        <span>Puesto*</span>
                        <input type="text" name="position" placeholder="Puesto*" required>
                    </label>

                    <label>
                        <span>Correo electrónico*</span>
                        <input type="email" name="email" placeholder="Correo electrónico*" required>
                    </label>

                    <label>
                        <span>Teléfono / WhatsApp</span>
                        <input type="text" name="phone" placeholder="Teléfono / WhatsApp">
                    </label>

                    <label>
                        <span>Compañía / Organización*</span>
                        <input type="text" name="company" placeholder="Compañía / Organización*" required>
                    </label>

                    <label class="contact-file">
                        <span class="contact-file__button">Adjuntar documento</span>
                        <input type="file" name="document" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.webp">
                    </label>

                    <p class="contact-file-help">Formatos permitidos: PDF, Excel, Word e imágenes. Tamaño máximo: 10 MB.</p>
                    <p class="contact-file-name" data-file-name></p>

                    <label>
                        <span>Describe tu necesidad</span>
                        <textarea name="message" placeholder="Describe tu necesidad" required></textarea>
                    </label>

                    <button class="contact-submit" type="submit">Solicitar diagnóstico</button>
                    <p class="contact-message" id="gya-contact-message" role="status" aria-live="polite"></p>
                </form>
            </div>

            <aside class="contact-director">
                <div class="contact-director-card">
                    <div class="contact-director-card__bg" style="background-image:url('<?php echo esc_url($office_image); ?>');"></div>
                    <div class="contact-director-card__network" style="background-image:url('<?php echo esc_url($network_image); ?>');"></div>
                    <?php if (!empty($director['image'])) : ?>
                        <img src="<?php echo esc_url($director['image']); ?>" alt="<?php echo esc_attr($director['name']); ?>">
                    <?php endif; ?>
                    <div class="contact-quote">
                        <p>"Las decisiones más importantes no deben basarse en suposiciones. Cuando los procesos se miden correctamente, los números muestran el camino."</p>
                        <h2><?php echo esc_html($director['name']); ?></h2>
                        <span><?php echo esc_html($director['position']); ?></span>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</main>
<?php
get_footer();

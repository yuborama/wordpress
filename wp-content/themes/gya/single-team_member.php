<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $member_id = get_the_ID();
    $name = gya_get_post_field_value('name', $member_id, get_the_title());
    $position = gya_get_post_field_value('position', $member_id, '');
    $description = gya_get_post_field_value('description', $member_id, '');
    $phrase = gya_get_post_field_value('phrase', $member_id, '');
    $image = gya_get_post_field_value('image', $member_id, '');
    $image_url = '';

    if (is_array($image) && isset($image['url'])) {
        $image_url = $image['url'];
    } elseif (is_numeric($image)) {
        $image_url = wp_get_attachment_image_url((int) $image, 'full');
    } elseif (is_string($image)) {
        $image_url = $image;
    }

    if (!$image_url && has_post_thumbnail($member_id)) {
        $image_url = get_the_post_thumbnail_url($member_id, 'full');
    }

    if ($phrase === '') {
        $phrase = 'Las decisiones más importantes no deben basarse en suposiciones. Cuando los procesos se miden correctamente, los números muestran el camino.';
    }

    $upload_dir = wp_upload_dir();
    $uploads_base = trailingslashit($upload_dir['baseurl']) . '2026/07/';
    $office_image = $uploads_base . 'cardservice3-scaled.jpg';
    $network_image = $uploads_base . 'network-bg.png';
    $contact_email = sanitize_email(get_option('gya_email_to', ''));
    $whatsapp_url = get_option('gya_social_whatsapp', '');
    $whatsapp_icon = get_template_directory_uri() . '/assets/images/icons/social/whatsapp.svg';
    ?>
    <main class="team-detail">
        <section class="team-detail-section">
            <div class="shell team-detail-layout">
                <article class="team-detail-copy">
                    <h1><?php echo esc_html($name); ?></h1>
                    <?php if (!empty($position)) : ?>
                        <p class="team-detail-position"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                    <div class="team-detail-actions">
                        <?php if (!empty($contact_email)) : ?>
                            <a class="team-detail-action" href="mailto:<?php echo esc_attr($contact_email); ?>" aria-label="Enviar correo">
                        <?php else : ?>
                            <span class="team-detail-action" aria-hidden="true">
                        <?php endif; ?>
                            <svg viewBox="0 0 24 24" focusable="false">
                                <path d="M4 6h16v12H4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                <path d="m4 7 8 6 8-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                            </svg>
                        <?php if (!empty($contact_email)) : ?>
                            </a>
                        <?php else : ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($whatsapp_url)) : ?>
                            <a class="team-detail-action" href="<?php echo esc_url($whatsapp_url); ?>" target="_blank" rel="noopener" aria-label="Abrir WhatsApp">
                                <img src="<?php echo esc_url($whatsapp_icon); ?>" alt="">
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="team-detail-description">
                        <?php
                        if (!empty($description)) {
                            echo wp_kses_post(wpautop($description));
                        } else {
                            the_content();
                        }
                        ?>
                    </div>
                </article>

                <aside class="team-detail-media">
                    <div class="team-detail-card">
                        <div class="team-detail-card__bg" style="background-image:url('<?php echo esc_url($office_image); ?>');"></div>
                        <div class="team-detail-card__network" style="background-image:url('<?php echo esc_url($network_image); ?>');"></div>
                        <?php if (!empty($image_url)) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>">
                        <?php endif; ?>
                        <div class="team-detail-quote">
                            <p>"<?php echo esc_html($phrase); ?>"</p>
                            <h2><?php echo esc_html($name); ?></h2>
                            <?php if (!empty($position)) : ?>
                                <span><?php echo esc_html($position); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </main>
    <?php
endwhile;

get_footer();

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

    $contact_email = sanitize_email(get_option('gya_email_to', ''));
    $contact_phone = get_option('gya_contact_phone', '');
    $contact_phone_href = preg_replace('/[^0-9+]/', '', $contact_phone);
    ?>
    <main class="team-detail">
        <section class="team-detail-section" aria-labelledby="team-member-name">
            <div class="team-detail-layout">
                <figure class="team-detail-portrait">
                    <?php if ($image_url) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>">
                    <?php endif; ?>
                </figure>

                <article class="team-detail-copy">
                    <h1 id="team-member-name"><?php echo esc_html($name); ?></h1>
                    <?php if ($position) : ?>
                        <p class="team-detail-position"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>

                    <div class="team-detail-actions" aria-label="Datos de contacto">
                        <?php if ($contact_email) : ?>
                            <a class="team-detail-action" href="mailto:<?php echo esc_attr($contact_email); ?>" aria-label="Enviar correo a <?php echo esc_attr($name); ?>">
                        <?php else : ?>
                            <span class="team-detail-action" aria-hidden="true">
                        <?php endif; ?>
                            <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M3.5 5.5h17v13h-17zM4.5 6.5l7.5 6 7.5-6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>
                        <?php echo $contact_email ? '</a>' : '</span>'; ?>

                        <?php if ($contact_phone_href) : ?>
                            <a class="team-detail-action" href="tel:<?php echo esc_attr($contact_phone_href); ?>" aria-label="Llamar a <?php echo esc_attr($name); ?>">
                        <?php else : ?>
                            <span class="team-detail-action" aria-hidden="true">
                        <?php endif; ?>
                            <svg viewBox="0 0 24 24" focusable="false" aria-hidden="true"><path d="M7.2 3.5H4.5c-.6 0-1 .5-1 1.1.2 8.8 7.1 15.7 15.9 15.9.6 0 1.1-.4 1.1-1v-2.7l-4.1-.9-1.1 2.2a14.1 14.1 0 0 1-9.4-9.4l2.2-1.1-.9-4.1Z" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <?php echo $contact_phone_href ? '</a>' : '</span>'; ?>
                    </div>

                    <div class="team-detail-description">
                        <?php
                        if ($description) {
                            echo wp_kses_post(wpautop($description));
                        } else {
                            the_content();
                        }
                        ?>
                    </div>
                </article>
            </div>
        </section>
    </main>
    <?php
endwhile;

get_footer();

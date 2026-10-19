<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $service_id = get_the_ID();
    $title = gya_get_post_field_value('title', $service_id, get_the_title());
    $short_description = gya_get_post_field_value('short_description', $service_id, '');
    $long_description = gya_get_post_field_value('long_description', $service_id, '');
    $image = gya_get_post_field_value('image', $service_id, '');
    $image_url = '';

    if (is_array($image) && isset($image['url'])) {
        $image_url = $image['url'];
    } elseif (is_numeric($image)) {
        $image_url = wp_get_attachment_image_url((int) $image, 'full');
    } elseif (is_string($image)) {
        $image_url = $image;
    }

    if (!$image_url && has_post_thumbnail($service_id)) {
        $image_url = get_the_post_thumbnail_url($service_id, 'full');
    }

    if (!$image_url) {
        $upload_dir = wp_upload_dir();
        $image_url = trailingslashit($upload_dir['baseurl']) . '2026/07/network-bg.png';
    }
    ?>
    <main class="service-detail">
        <section class="service-detail-hero">
            <div class="service-detail-hero__image" style="background-image:url('<?php echo esc_url($image_url); ?>');"></div>
            <div class="shell service-detail-hero__inner">
                <span class="service-detail-hero__eyebrow">Lo que nos distingue</span>
                <h1><?php echo esc_html($title); ?></h1>
                <?php if (!empty($short_description)) : ?>
                    <p><?php echo esc_html($short_description); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <section class="service-detail-content">
            <div class="shell service-detail-content__inner">
                <div class="service-detail-body">
                    <?php
                    if (!empty($long_description)) {
                        echo wp_kses_post($long_description);
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            </div>
        </section>

        <?php get_template_part('template-parts/cta-banner'); ?>
    </main>
    <?php
endwhile;

get_footer();

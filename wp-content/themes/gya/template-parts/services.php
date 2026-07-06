<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$services_heading = gya_get_field_value('gya_services_heading', 'Soluciones a los retos que realmente impactan tu negocio.', $page_id);
$upload_dir = wp_upload_dir();
$services_bg = trailingslashit($upload_dir['baseurl']) . '2026/06/hero-image-scaled.jpg';

$services_query = new WP_Query(
    array(
        'post_type' => 'como_ayudamos',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
    )
);

$services = array();

if ($services_query->have_posts()) {
    while ($services_query->have_posts()) {
        $services_query->the_post();

        $service_id = get_the_ID();
        $title = gya_get_post_field_value('title', $service_id, get_the_title());
        $body = gya_get_post_field_value('short_description', $service_id, '');

        if ($body === '') {
            $body = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $service_id, '')), 22, '...');
        }

        $image = gya_get_post_field_value('image', $service_id, '');
        $image_url = '';

        if (is_array($image) && isset($image['url'])) {
            $image_url = $image['url'];
        } elseif (is_numeric($image)) {
            $image_url = wp_get_attachment_image_url((int) $image, 'large');
        } elseif (is_string($image)) {
            $image_url = $image;
        }

        if (!$image_url && has_post_thumbnail($service_id)) {
            $image_url = get_the_post_thumbnail_url($service_id, 'large');
        }

        $services[] = array(
            'title' => $title,
            'body' => $body,
            'image' => $image_url ? $image_url : '',
        );
    }

    wp_reset_postdata();
}
?>
<section class="section dark-section" id="servicios" style="background-image:url('<?php echo esc_url($services_bg); ?>');">
    <div class="shell">
        <header class="section-header section-header-light">
            <span>CÓMO AYUDAMOS</span>
            <h2><?php echo esc_html($services_heading); ?></h2>
        </header>
        <div class="services-grid">
            <?php foreach ($services as $service) : ?>
                <article class="service-card">
                    <div class="card-photo" style="background-image:url('<?php echo esc_url($service['image']); ?>');"></div>
                    <div class="service-copy">
                        <h3><?php echo esc_html($service['title']); ?> <span>&rsaquo;</span></h3>
                        <p><?php echo esc_html($service['body']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <a class="outline-link centered services-cta" href="#servicios">Ver servicios especializados</a>
    </div>
</section>

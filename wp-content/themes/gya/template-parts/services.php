<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = isset($args['data']) ? $args['data'] : gya_get_landing_data();
$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$services = isset($data['services']) ? $data['services'] : array();
$services_heading = gya_get_field_value('gya_services_heading', 'Soluciones a los retos que realmente impactan tu negocio.', $page_id);
$services = gya_get_fixed_items_from_acf($services, 'gya_service', array('title', 'body', 'image'), 3, $page_id);
?>
<section class="section dark-section" id="servicios">
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
    </div>
</section>

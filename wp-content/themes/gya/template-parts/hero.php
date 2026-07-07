<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = isset($args['data']) ? $args['data'] : gya_get_landing_data();
$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$slides = isset($data['hero_slides']) ? $data['hero_slides'] : array();
$stats = isset($data['stats']) ? $data['stats'] : array();
$upload_dir = wp_upload_dir();
$network_image = trailingslashit($upload_dir['baseurl']) . '2026/07/hero-image-scaled.jpg';
$post_slides = gya_get_hero_slides_from_posts();

if (!empty($post_slides)) {
    $slides = $post_slides;
}

if (empty($post_slides) && !empty($slides[0])) {
    $slides[0]['title'] = gya_get_field_value('gya_hero_title', $slides[0]['title'], $page_id);
    $slides[0]['strong'] = gya_get_field_value('gya_hero_strong', $slides[0]['strong'], $page_id);
    $slides[0]['body'] = gya_get_field_value('gya_hero_body', $slides[0]['body'], $page_id);
    $slides[0]['cta'] = gya_get_field_value('gya_hero_cta_text', $slides[0]['cta'], $page_id);
    $slides[0]['href'] = gya_get_field_value('gya_hero_cta_url', $slides[0]['href'], $page_id);
    $slides[0]['image'] = gya_get_field_value('gya_hero_image', $slides[0]['image'], $page_id);
}

$stats = gya_get_fixed_items_from_acf($stats, 'gya_stat', array('value', 'label'), 4, $page_id);
?>
<section class="hero-section js-hero" aria-labelledby="hero-title">
    <div class="hero-media" aria-hidden="true">
        <?php foreach ($slides as $index => $slide): ?>
            <?php if (!empty($slide['image'])): ?>
                <div class="hero-office-image<?php echo $index === 0 ? ' is-active' : ''; ?>"
                    style="background-image:url('<?php echo esc_url($slide['image']); ?>'); background-position: <?php echo esc_attr(isset($slide['position']) ? $slide['position'] : 'center center'); ?>;"
                    data-hero-slide="<?php echo esc_attr((string) $index); ?>"></div>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="hero-network-image" style="background-image:url('<?php echo esc_url($network_image); ?>');"></div>
    </div>

    <button class="circle-arrow hero-prev" type="button" aria-label="Anterior">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/arrow.svg'); ?>" alt="">
    </button>
    <button class="circle-arrow hero-next" type="button" aria-label="Siguiente">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/arrow.svg'); ?>" alt="">
    </button>

    <div class="shell hero-content" aria-live="polite">
        <?php foreach ($slides as $index => $slide): ?>
            <div class="hero-copy<?php echo $index === 0 ? ' is-active' : ''; ?>"
                data-hero-copy="<?php echo esc_attr((string) $index); ?>">
                <?php if (!empty($slide['eyebrow'])): ?>
                    <span class="eyebrow"><?php echo esc_html($slide['eyebrow']); ?></span>
                <?php endif; ?>
                <?php if (!empty($slide['title'])): ?>
                    <h1 id="<?php echo $index === 0 ? 'hero-title' : ''; ?>">
                        <?php echo esc_html($slide['title']); ?>
                        <?php if (!empty($slide['strong'])): ?>
                            <strong><?php echo esc_html($slide['strong']); ?></strong>
                        <?php endif; ?>
                    </h1>
                <?php endif; ?>
                <?php if (!empty($slide['body'])): ?>
                    <p><?php echo esc_html($slide['body']); ?></p>
                <?php endif; ?>
                <?php if (!empty($slide['cta']) && !empty($slide['href'])): ?>
                    <a class="outline-link" href="<?php echo esc_url($slide['href']); ?>"><?php echo esc_html($slide['cta']); ?>
                        <span>&rsaquo;</span></a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="stats-band" aria-label="Indicadores">
    <div class="shell stats-grid">
        <?php foreach ($stats as $stat): ?>
            <article>
                <div>
                    <strong><?php echo esc_html($stat['value']); ?></strong>
                    <span><?php echo esc_html($stat['label']); ?></span>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

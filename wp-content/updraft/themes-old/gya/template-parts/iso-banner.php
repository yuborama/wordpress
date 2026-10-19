<?php

if (!defined('ABSPATH')) {
    exit;
}

$variant = isset($args['variant']) ? sanitize_key((string) $args['variant']) : 'iso';

$banners = array(
    'iso' => array(
        'title' => 'Calidad que se respalda en procesos',
        'body' => 'Nuestra certificacion ISO 9001:2015 refleja nuestro enfoque por trabajar con procesos claros y mejora continua.',
        'image' => 'ISO.png',
    ),
    'revista' => array(
        'title' => 'Reconocidos entre las grandes firmas fiscalistas de Mexico',
        'body' => 'Por segundo ano consecutivo, la revista Defensa Fiscal reconocio a G&A como una de las firmas fiscalistas destacadas del pais.',
        'image' => 'REVISTA.png',
    ),
);

$banner = isset($banners[$variant]) ? $banners[$variant] : $banners['iso'];
$words = preg_split('/\s+/', $banner['title']);
$highlighted_title = esc_html($banner['title']);

if ($variant === 'iso') {
    $highlighted_title = 'Calidad que se <span>respalda en procesos</span>';
} elseif ($variant === 'revista') {
    $highlighted_title = 'Reconocidos entre las grandes firmas fiscalistas de Mexico';
}

$image_url = get_template_directory_uri() . '/assets/images/iso/' . $banner['image'];
?>
<section class="iso-banner-shell iso-banner-shell--<?php echo esc_attr($variant); ?>">
    <div class="shell">
        <article class="iso-banner">
            <div class="iso-banner__copy">
                <h2><?php echo wp_kses($highlighted_title, array('span' => array())); ?></h2>
                <p><?php echo esc_html($banner['body']); ?></p>
                <a class="primary-button iso-banner__button" href="<?php echo esc_url(home_url('/weare/')); ?>">
                    Conoce mas sobre G&A <span>&rsaquo;</span>
                </a>
            </div>
            <div class="iso-banner__media">
                <img src="<?php echo esc_url($image_url); ?>" alt="">
            </div>
        </article>
    </div>
</section>

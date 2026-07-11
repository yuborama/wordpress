<?php

if (!defined('ABSPATH')) {
    exit;
}

$upload_dir = wp_upload_dir();
$uploads_base = trailingslashit($upload_dir['baseurl']) . '2026/07/';
$network_image = $uploads_base . 'network-bg.png';
$office_image = $uploads_base . 'office.jpg';
$office_alt_image = $uploads_base . 'office3.png';

$director_query = new WP_Query(
    array(
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'ASC',
        ),
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
        'image' => $director_image_url,
    );

    wp_reset_postdata();
}

$feature_cards = array(
    array(
        'type' => 'tracking',
        'image' => 'seguimiento.svg',
        'title' => 'Tecnología y seguimiento',
        'body' => 'Integramos herramientas y metodologías de trabajo que nos permiten dar seguimiento a proyectos, centralizar información clave y mantener una comunicación más clara durante cada etapa del servicio.',
    ),
    array(
        'type' => 'iso',
        'image' => 'iso.svg',
        'title' => 'Calidad certificada',
        'body' => 'Nuestra firma evalúa y fortalece continuamente sus procesos mediante un Sistema de Calidad ISO 9001:2015, con el objetivo de ofrecer un servicio más sólido, ordenado y confiable.',
    ),
    array(
        'type' => 'defensa',
        'image' => 'defensa.svg',
        'title' => 'Reconocimiento',
        'body' => 'G&A fue reconocida por segundo año consecutivo por la revista Defensa Fiscal como una de las Grandes Firmas de Fiscalistas en México, reflejo de la experiencia y especialización de nuestro equipo.',
    ),
);

$feature_image_base = get_template_directory_uri() . '/assets/images/nosotros/';
$sponsor_base = get_template_directory_uri() . '/assets/images/sponsor/';
$clients = array(
    array('name' => 'Vix', 'logo' => 'vix_Logo.svg'),
    array('name' => 'Pfizer', 'logo' => 'pfizer_Logo.svg'),
    array('name' => 'DSV', 'logo' => 'dvs_Logo.svg'),
    array('name' => 'Senator International', 'logo' => 'senator_Logo.svg'),
    array('name' => 'Maersk', 'logo' => 'maersk_Logo.svg'),
    array('name' => 'AIT Home Delivery', 'logo' => 'ait_Logo.svg'),
    array('name' => 'Fracht Group', 'logo' => 'fracht_Logo.svg'),
);

get_header();
?>
<main class="weare-page">
    <section class="weare-hero">
        <div class="weare-hero__office" style="background-image:url('<?php echo esc_url($office_image); ?>');"></div>
        <div class="weare-hero__network" style="background-image:url('<?php echo esc_url($network_image); ?>');"></div>
        <?php if (!empty($director['image'])) : ?>
            <img class="weare-hero__person" src="<?php echo esc_url($director['image']); ?>" alt="<?php echo esc_attr($director['name']); ?>">
        <?php endif; ?>
        <div class="shell weare-hero__inner">
            <div class="weare-hero__copy">
                <span>NOSOTROS</span>
                <h1>Una firma boutique con <strong>visión estratégica y atención cercana</strong></h1>
                <p>En G&A acompañamos a empresas con soluciones fiscales, legales, financieras y corporativas diseñadas para dar claridad, orden y dirección a sus operaciones.</p>
                <p><strong>Más de 15 años de experiencia respaldan la trayectoria de nuestros socios y especialistas en la atención de empresas nacionales e internacionales.</strong></p>
            </div>
        </div>
    </section>

    <section class="weare-features">
        <div class="shell weare-features__grid">
            <?php foreach ($feature_cards as $feature) : ?>
                <article class="weare-feature-card">
                    <div class="weare-feature-mark weare-feature-mark--<?php echo esc_attr($feature['type']); ?>" aria-hidden="true">
                        <img src="<?php echo esc_url($feature_image_base . $feature['image']); ?>" alt="">
                    </div>
                    <h2><?php echo esc_html($feature['title']); ?></h2>
                    <p><?php echo esc_html($feature['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <?php get_template_part('template-parts/team', null, array('page_id' => (int) get_option('page_on_front'))); ?>

    <section class="weare-clients" style="background-image:url('<?php echo esc_url($network_image); ?>');">
        <div class="shell">
            <header class="weare-section-header weare-section-header--light">
                <span>NUESTROS CLIENTES</span>
                <h2>La confianza de nuestros clientes respalda nuestro trabajo</h2>
            </header>
            <div class="weare-client-list">
                <?php foreach ($clients as $client) : ?>
                    <span class="weare-client-logo">
                        <img src="<?php echo esc_url($sponsor_base . $client['logo']); ?>" alt="<?php echo esc_attr($client['name']); ?>">
                    </span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="weare-message">
        <div class="shell">
            <article class="weare-message-card">
                <div class="weare-message-card__bg" style="background-image:url('<?php echo esc_url($office_alt_image); ?>');"></div>
                <div class="weare-message-card__copy">
                    <h2>Mensaje de nuestro <strong>Socio Director</strong></h2>
                    <p>“Nuestro trabajo no se limita a resolver una obligación o atender un tema puntual. Buscamos acompañar a cada empresa con cercanía, criterio y una visión integral que le permita tomar mejores decisiones y crecer con mayor seguridad.”</p>
                    <h3><?php echo esc_html($director['name']); ?></h3>
                    <span><?php echo esc_html($director['position']); ?></span>
                </div>
                <?php if (!empty($director['image'])) : ?>
                    <img class="weare-message-card__person" src="<?php echo esc_url($director['image']); ?>" alt="<?php echo esc_attr($director['name']); ?>">
                <?php endif; ?>
            </article>
        </div>
    </section>
</main>
<?php
get_footer();

<?php

if (!defined('ABSPATH')) {
    exit;
}

$upload_dir = wp_upload_dir();
$upload_base = trailingslashit($upload_dir['baseurl']) . '2026/07/';
$area_images = array(
    'Fiscal y Financiero' => $upload_base . 'cardservice1.jpg',
    'Legal' => $upload_base . 'BANNER-2.png',
    'Auditoría' => $upload_base . 'cardservice3.jpg',
    'Nóminas' => $upload_base . 'office2.jpg',
    'EPT' => $upload_base . 'EPT.png',
    'T.I.' => $upload_base . 'insightsCardTeam.jpg',
);
$areas = array();
$areas_query = new WP_Query(
    array(
        'post_type' => 'gya_category',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'ASC',
        ),
        'no_found_rows' => true,
    )
);

if ($areas_query->have_posts()) {
    while ($areas_query->have_posts()) {
        $areas_query->the_post();

        $area_id = get_the_ID();
        $title = get_the_title();
        $description = gya_get_post_field_value('short_description', $area_id, '');

        if ($description === '') {
            $description = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $area_id, '')), 18, '...');
        }

        $featured_image = has_post_thumbnail($area_id) ? get_the_post_thumbnail_url($area_id, 'large') : '';
        $areas[] = array(
            'title' => $title,
            'description' => $description,
            'url' => get_permalink($area_id),
            'image' => $featured_image ?: (isset($area_images[$title]) ? $area_images[$title] : $upload_base . 'office.jpg'),
        );
    }

    wp_reset_postdata();
}

if (empty($areas)) {
    $areas = array(
        array('title' => 'Fiscal y Financiero', 'description' => 'Estrategias fiscales, cumplimiento y optimización financiera para operar con mayor claridad y seguridad.', 'url' => '#', 'image' => $area_images['Fiscal y Financiero']),
        array('title' => 'Legal', 'description' => 'Asesoría legal estratégica para acompañar el crecimiento y operación de tu empresa.', 'url' => '#', 'image' => $area_images['Legal']),
        array('title' => 'Auditoría', 'description' => 'Auditoría financiera, fiscal y operativa con enfoque en transparencia, control y reducción de riesgos.', 'url' => '#', 'image' => $area_images['Auditoría']),
        array('title' => 'Nóminas', 'description' => 'Apoyamos a las empresas en la administración y cumplimiento de sus procesos de nómina y seguridad social.', 'url' => '#', 'image' => $area_images['Nóminas']),
        array('title' => 'EPT', 'description' => 'Acompañamos al cumplimiento de obligaciones en materia de estudios de precios de transferencia.', 'url' => '#', 'image' => $area_images['EPT']),
        array('title' => 'T.I.', 'description' => 'Soluciones a la medida para atender necesidades específicas de negocio.', 'url' => '#', 'image' => $area_images['T.I.']),
    );
}

get_header();
?>
<main class="home-redesign areas-page">
    <section class="gya-areas gya-grid-bg" aria-labelledby="areas-title">
        <div class="gya-design-shell">
            <h1 id="areas-title">ÁREAS</h1>
            <div class="gya-areas__grid">
                <?php foreach ($areas as $area) : ?>
                    <a class="gya-area-card" href="<?php echo esc_url($area['url']); ?>">
                        <img src="<?php echo esc_url($area['image']); ?>" alt="<?php echo esc_attr($area['title']); ?>" loading="lazy">
                        <span><?php echo esc_html($area['title']); ?></span>
                        <p><?php echo esc_html($area['description']); ?></p>
                        <i aria-hidden="true">→</i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="gya-relations gya-grid-bg" aria-labelledby="relations-title">
        <div class="gya-design-shell gya-relations__grid">
            <div class="gya-relations__copy">
                <h2 id="relations-title">Más que servicios, construimos relaciones.</h2>
                <p>G&amp;A es una firma boutique que acompaña a empresas con claridad, experiencia y atención personalizada.</p>
                <a class="gya-orange-button" href="<?php echo esc_url(home_url('/weare/')); ?>">CONÓCENOS <span aria-hidden="true">→</span></a>
            </div>
            <img src="<?php echo esc_url($upload_base . 'office.jpg'); ?>" alt="Equipo de consultoría G&amp;A" loading="lazy">
        </div>
    </section>
</main>
<?php
get_footer();

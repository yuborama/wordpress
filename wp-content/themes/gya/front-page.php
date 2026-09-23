<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = gya_get_landing_data();
$page_id = get_queried_object_id();
$upload_dir = wp_upload_dir();
$upload_base = trailingslashit($upload_dir['baseurl']);
$relations_image_id = absint(get_option('gya_relations_image_id', 0));
$relations_image = $relations_image_id ? wp_get_attachment_image_url($relations_image_id, 'full') : '';

if (!$relations_image) {
    $relations_image = $upload_base . '2026/07/office.jpg';
}
$stats = gya_get_fixed_items_from_acf(isset($data['stats']) ? $data['stats'] : array(), 'gya_stat', array('value', 'label', 'icon'), 4, $page_id);
$hero_slides = function_exists('gya_get_hero_slides_from_posts') ? gya_get_hero_slides_from_posts() : array();

if (empty($hero_slides)) {
    $hero_slides[] = array(
        'eyebrow' => '',
        'title' => 'Estrategia y experiencia para decisiones que generan valor.',
        'body' => 'G&A es una firma boutique de consultoría y asesoría empresarial que integra experiencia fiscal, financiera, jurídica y corporativa para acompañar a las empresas con claridad, certeza y visión estratégica.',
        'cta' => 'LA FIRMA',
        'href' => home_url('/weare/'),
        'image' => $upload_base . '2026/07/cardservice3.jpg',
    );
}

foreach ($hero_slides as &$hero_slide) {
    if (empty($hero_slide['image'])) {
        $hero_slide['image'] = $upload_base . '2026/07/cardservice3.jpg';
    }
}
unset($hero_slide);

$area_images = array(
    'Fiscal y Financiero' => $upload_base . '2026/07/cardservice1.jpg',
    'Legal' => $upload_base . '2026/07/BANNER-2.png',
    'Auditoría' => $upload_base . '2026/07/cardservice3.jpg',
    'Nóminas' => $upload_base . '2026/07/office2.jpg',
    'EPT' => $upload_base . '2026/07/EPT.png',
    'T.I.' => $upload_base . '2026/07/insightsCardTeam.jpg',
);

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

$areas = array();

if ($areas_query->have_posts()) {
    while ($areas_query->have_posts()) {
        $areas_query->the_post();

        $area_id = get_the_ID();
        $title = get_the_title();
        $description = gya_get_post_field_value('short_description', $area_id, '');

        if ($description === '') {
            $description = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $area_id, '')), 18, '...');
        }

        $image = has_post_thumbnail($area_id) ? get_the_post_thumbnail_url($area_id, 'large') : '';

        $areas[] = array(
            'title' => $title,
            'description' => $description,
            'url' => get_permalink($area_id),
            'image' => $image ? $image : (isset($area_images[$title]) ? $area_images[$title] : $upload_base . '2026/07/office.jpg'),
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
        array('title' => 'EPT', 'description' => 'Acompañamos el cumplimiento de obligaciones en materia de estudios de precios de transferencia.', 'url' => '#', 'image' => $area_images['EPT']),
        array('title' => 'T.I.', 'description' => 'Soluciones a la medida para atender necesidades específicas de negocio.', 'url' => '#', 'image' => $area_images['T.I.']),
    );
}

$clients = array(
    array('name' => 'Vix', 'logo' => get_template_directory_uri() . '/assets/images/sponsor/vix_Logo.svg'),
    array('name' => 'Pfizer', 'logo' => get_template_directory_uri() . '/assets/images/sponsor/pfizer_Logo.svg'),
    array('name' => 'DSV', 'logo' => get_template_directory_uri() . '/assets/images/sponsor/dvs_Logo.svg'),
    array('name' => 'Maersk', 'logo' => get_template_directory_uri() . '/assets/images/sponsor/maersk_Logo.svg'),
);

get_header();
?>
<main class="home-redesign">
    <section class="gya-hero" aria-labelledby="hero-title" data-gya-hero>
        <div class="gya-hero__media-stack" aria-hidden="true">
            <?php foreach ($hero_slides as $index => $slide) : ?>
                <?php if (!empty($slide['image'])) : ?>
                    <div
                        class="gya-hero__media <?php echo $index === 0 ? 'is-active' : ''; ?>"
                        style="background-image:url('<?php echo esc_url($slide['image']); ?>');"
                        data-gya-hero-media="<?php echo esc_attr((string) $index); ?>"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <div class="gya-design-shell gya-hero__content" aria-live="polite">
            <?php foreach ($hero_slides as $index => $slide) : ?>
                <div class="gya-hero__slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-gya-hero-slide="<?php echo esc_attr((string) $index); ?>">
                    <?php if (!empty($slide['eyebrow'])) : ?>
                        <span class="gya-hero__eyebrow"><?php echo esc_html($slide['eyebrow']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($slide['title'])) : ?>
                        <h1<?php echo $index === 0 ? ' id="hero-title"' : ''; ?>><?php echo esc_html($slide['title']); ?></h1>
                    <?php endif; ?>
                    <?php if (!empty($slide['body'])) : ?>
                        <p><?php echo esc_html($slide['body']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($slide['cta']) && !empty($slide['href'])) : ?>
                        <a class="gya-orange-button" href="<?php echo esc_url($slide['href']); ?>"><?php echo esc_html($slide['cta']); ?> <span aria-hidden="true">→</span></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="gya-stats" aria-label="Indicadores">
        <div class="gya-design-shell gya-stats__grid">
            <?php foreach ($stats as $stat) : ?>
                <article>
                    <strong><?php echo esc_html($stat['value']); ?></strong>
                    <span><?php echo esc_html($stat['label']); ?></span>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="gya-areas gya-grid-bg" id="areas">
        <div class="gya-design-shell">
            <h2>ÁREAS</h2>
            <div class="gya-areas__grid">
                <?php foreach (array_slice($areas, 0, 6) as $area) : ?>
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

    <section class="gya-relations gya-grid-bg" id="nosotros">
        <div class="gya-design-shell gya-relations__grid">
            <div class="gya-relations__copy">
                <h2>Más que servicios, construimos relaciones.</h2>
                <p>G&amp;A es una firma boutique que acompaña a empresas con claridad, experiencia y atención personalizada.</p>
                <a class="gya-orange-button" href="<?php echo esc_url(home_url('/contact/')); ?>">CONÓCENOS <span aria-hidden="true">→</span></a>
            </div>
            <img src="<?php echo esc_url($relations_image); ?>" alt="Equipo de consultoría G&amp;A" loading="lazy">
        </div>
    </section>

    <section class="gya-distinguish gya-grid-bg" id="servicios">
        <div class="gya-design-shell">
            <h2>LO QUE NOS DISTINGUE</h2>
            <div class="gya-distinguish__grid">
                <article>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/nosotros/seguimiento.svg'); ?>" alt="">
                    <h3>TECNOLOGÍA Y SEGUIMIENTO</h3>
                    <p>Integramos herramientas y metodologías de trabajo que nos permiten dar seguimiento a proyectos, centralizar información clave y mantener una comunicación más clara durante cada etapa del servicio.</p>
                </article>
                <article>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/nosotros/iso.svg'); ?>" alt="">
                    <h3>CALIDAD CERTIFICADA</h3>
                    <p>Nuestra firma evalúa y fortalece continuamente sus procesos mediante un Sistema de Calidad ISO 9001:2015, con el objetivo de ofrecer un servicio más sólido, ordenado y confiable.</p>
                </article>
                <article>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/nosotros/defensa.svg'); ?>" alt="">
                    <h3>RECONOCIMIENTO</h3>
                    <p>G&amp;A fue reconocida por segundo año consecutivo por la revista Defensa Fiscal como una de las Grandes Firmas de Fiscalistas en México, reflejo de la experiencia y especialización de nuestro equipo.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="gya-clients gya-grid-bg" aria-labelledby="clients-title">
        <div class="gya-design-shell">
            <h2 id="clients-title">Nuestros clientes</h2>
            <div class="gya-clients__logos">
                <?php foreach ($clients as $client) : ?>
                    <img src="<?php echo esc_url($client['logo']); ?>" alt="<?php echo esc_attr($client['name']); ?>">
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();

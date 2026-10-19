<?php
if (!defined('ABSPATH')) {
    exit;
}

$asset_base = get_template_directory_uri() . '/assets/images/';
$weare_hero_image_id = absint(get_option('gya_firma_image_id', 0));
$weare_hero_image = $weare_hero_image_id ? wp_get_attachment_image_url($weare_hero_image_id, 'full') : '';
if (!$weare_hero_image) {
    $weare_hero_image = get_the_post_thumbnail_url(get_queried_object_id(), 'full');
}

$stats = array(
    array('value' => '+15', 'label' => 'Años de experiencia'),
    array('value' => '+140', 'label' => 'Soluciones especializadas'),
    array('value' => '+7', 'label' => 'Áreas de especialización'),
    array('value' => '+40', 'label' => 'Especialistas y consultores'),
);
$specialties = array(
    array(
        'title' => 'Freight Forward',
        'image' => 'firma-freight.jpg',
        'body' => 'Conocemos la aplicación de tasas de IVA en servicios de transporte nacional e internacional, así como la operación de agentes de carga, incoterms y las disposiciones aplicables a su actividad.',
    ),
    array(
        'title' => 'Shelter empresarial',
        'image' => 'firma-shelter.jpg',
        'body' => 'Acompañamos a empresas extranjeras y nuevos negocios en su establecimiento y operación en México, brindando soporte en aspectos legales y fiscales para facilitar el inicio y desarrollo de sus operaciones.',
    ),
);
$experience = array(
    array(
        'title' => 'ISO 9001:2015',
        'image' => 'nosotros/iso.svg',
        'body' => 'Contamos con un Sistema de Gestión de la Calidad implementado y certificado bajo la Norma ISO 9001:2015, orientado a la calidad, satisfacción de nuestros clientes y mejora continua.',
    ),
    array(
        'title' => 'Estándares internacionales de calidad',
        'image' => 'nosotros/quality-badge.svg',
        'body' => 'Realizamos revisiones semestrales de nuestras áreas de servicios profesionales conforme a las Normas Internacionales de Gestión de Calidad ISQM-1 e ISQM-2.',
    ),
    array(
        'title' => 'Visibilidad y control de nuestros procesos',
        'image' => 'nosotros/seguimiento.svg',
        'body' => 'Integramos herramientas digitales de gestión para dar seguimiento a proyectos, procesos y actividades, fortaleciendo la coordinación de nuestros equipos y la visibilidad del trabajo.',
    ),
);
$regions = array(
    'México' => array('Ciudad de México', 'León, Guanajuato'),
    'América' => array('Estados Unidos', 'Colombia', 'Argentina', 'Brasil', 'Perú', 'Ecuador', 'Chile', 'Panamá', 'Guatemala'),
    'Europa' => array('República Checa', 'Reino Unido', 'Francia', 'España', 'Suiza', 'Polonia'),
);

get_header();
?>
<main class="weare-page">
    <section class="weare-hero" aria-labelledby="firma-title">
        <div class="weare-hero__inner">
            <div class="weare-hero__copy">
                <span class="weare-eyebrow">LA FIRMA</span>
                <h1 id="firma-title">Estrategia, experiencia y respaldo para decisiones que generan valor.</h1>
                <p>Acompañamos a nuestros clientes con soluciones especializadas, atención personalizada y una visión integral de sus necesidades, respaldados por una cultura de calidad y mejora continua.</p>
            </div>
            <?php if ($weare_hero_image) : ?>
                <img class="weare-hero__image" src="<?php echo esc_url($weare_hero_image); ?>" alt="Equipo de G&amp;A trabajando en conjunto" fetchpriority="high">
            <?php endif; ?>
        </div>
    </section>

    <?php get_template_part('template-parts/stats', null, array(
        'stats' => $stats,
        'heading' => 'Una firma construida sobre experiencia y especialización.',
    )); ?>

    <section class="weare-specialties" aria-labelledby="specialties-title">
        <div class="gya-design-shell weare-specialties__grid">
            <div class="weare-section-copy">
                <h2 id="specialties-title">Conocemos el negocio detrás de cada operación.</h2>
                <p>Nuestra experiencia nos permite comprender no solo los requerimientos técnicos de nuestros clientes, sino también las particularidades de sectores que requieren conocimiento especializado.</p>
            </div>
            <?php foreach ($specialties as $specialty) : ?>
                <article class="weare-specialty">
                    <img src="<?php echo esc_url($asset_base . $specialty['image']); ?>" alt="<?php echo esc_attr($specialty['title']); ?>" loading="lazy">
                    <div>
                        <h3><?php echo esc_html($specialty['title']); ?></h3>
                        <p><?php echo esc_html($specialty['body']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="gya-distinguish weare-experience" aria-labelledby="experience-title">
        <div class="gya-design-shell">
            <h2 id="experience-title">LA EXPERIENCIA IMPORTA.</h2>
            <div class="gya-distinguish__grid">
                <?php foreach ($experience as $feature) : ?>
                    <article>
                        <img class="<?php echo $feature['image'] === 'nosotros/quality-badge.svg' ? 'weare-quality-badge' : ''; ?>" src="<?php echo esc_url($asset_base . $feature['image']); ?>" alt="" loading="lazy">
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['body']); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="weare-presence" aria-labelledby="presence-title">
        <div class="gya-design-shell">
            <div class="weare-presence__grid">
                <div class="weare-section-copy">
                    <span class="weare-eyebrow">PRESENCIA</span>
                    <h2 id="presence-title">Con una visión que cruza fronteras.</h2>
                    <p>Nuestra operación continúa creciendo para acompañar las necesidades de nuestros clientes dentro y fuera de México.</p>
                </div>
                <img class="weare-map" src="<?php echo esc_url($asset_base . 'firma-presence.svg'); ?>" alt="Presencia en México, América y Europa" loading="lazy">
            </div>
            <div class="weare-regions">
                <?php foreach ($regions as $region => $locations) : ?>
                    <div>
                        <h3><?php echo esc_html($region); ?></h3>
                        <ul>
                            <?php foreach ($locations as $location) : ?>
                                <li><?php echo esc_html($location); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/clients', null, array('section_class' => 'gya-clients weare-clients')); ?>
    <?php get_template_part('template-parts/relations-section'); ?>
</main>
<?php get_footer(); ?>

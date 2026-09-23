<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php
$front_page_id = (int) get_option('page_on_front');
$header_cta_text = gya_get_field_value('gya_header_cta_text', 'Diagnóstico estratégico', $front_page_id);
$header_cta_url = gya_get_field_value('gya_header_cta_url', '#contacto', $front_page_id);
if ($header_cta_url === '#contacto') {
    $header_cta_url = home_url('/contact/');
}
$header_iso_badge_path = get_template_directory() . '/assets/images/icons/iso9001.svg';
$header_iso_badge_url = get_template_directory_uri() . '/assets/images/icons/iso9001.svg';
$header_solution_items = get_posts(
    array(
        'post_type' => 'gya_category',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'ASC',
        ),
    )
);
$header_is_insights_active = is_post_type_archive('insights') || is_singular('insights');
$header_logo_path = get_template_directory() . '/assets/images/icons/logo.svg';
$header_logo_markup = '';

$header_is_areas_request = function_exists('gya_is_areas_page_request') && gya_is_areas_page_request();
$header_is_team_request = function_exists('gya_is_team_page_request') && gya_is_team_page_request();
$header_is_category_request = is_singular('gya_category');
$header_is_contact_request = function_exists('gya_is_contact_page_request') && gya_is_contact_page_request();
$header_is_member_request = is_singular('team_member');
$header_is_privacy_request = function_exists('gya_is_privacy_page_request') && gya_is_privacy_page_request();

if ((is_front_page() || $header_is_areas_request || $header_is_team_request || $header_is_category_request || $header_is_contact_request || $header_is_member_request || $header_is_privacy_request) && file_exists($header_logo_path)) {
    $header_logo_markup = file_get_contents($header_logo_path);
    $header_logo_markup = str_replace('fill="white"', 'fill="#062236"', $header_logo_markup);
    $header_logo_markup = str_replace('<svg ', '<svg role="img" aria-label="G&amp;A" ', $header_logo_markup);
}

$header_social_links = array();
if (function_exists('gya_social_networks')) {
    $header_networks = gya_social_networks();

    foreach (array('facebook', 'linkedin', 'tiktok', 'youtube') as $network_key) {
        if (!isset($header_networks[$network_key])) {
            continue;
        }

        $network = $header_networks[$network_key];
        $network_url = get_option($network['option'], '');

        if (!empty($network_url)) {
            $header_social_links[] = array(
                'label' => $network['label'],
                'url' => $network_url,
                'icon' => get_template_directory_uri() . '/assets/images/icons/social/' . $network['icon'],
            );
        }
    }
}
?>
<header class="site-header" id="top">
    <div class="shell header-inner">
        <a class="logo-mark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Inicio GYA">
            <?php if ($header_logo_markup !== '') : ?>
                <?php echo $header_logo_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted local SVG. ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/logo.svg'); ?>" alt="G&amp;A">
            <?php endif; ?>
        </a>

        <nav class="desktop-nav" aria-label="Principal">
            <ul class="header-menu">
                <li class="header-menu-item header-menu-item--dropdown">
                    <a class="header-menu-link" href="<?php echo esc_url(home_url('/areas/')); ?>" aria-haspopup="true">
                        Áreas
                        <span class="header-menu-chevron" aria-hidden="true"></span>
                    </a>

                    <?php if (!empty($header_solution_items)) : ?>
                        <div class="header-dropdown">
                            <?php foreach ($header_solution_items as $solution_item) : ?>
                                <a href="<?php echo esc_url(get_permalink($solution_item->ID)); ?>">
                                    <?php echo esc_html(get_the_title($solution_item)); ?>
                                    <span aria-hidden="true">›</span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </li>
                <li class="header-menu-item">
                    <a class="header-menu-link <?php echo $header_is_insights_active ? 'is-active' : ''; ?>" href="<?php echo esc_url(get_post_type_archive_link('insights') ?: home_url('/insights/')); ?>">Insights</a>
                </li>
                <li class="header-menu-item">
                    <a class="header-menu-link" href="<?php echo esc_url(home_url('/#servicios')); ?>">Lo que nos distingue</a>
                </li>
                <li class="header-menu-item header-menu-item--dropdown">
                    <a class="header-menu-link" href="<?php echo esc_url(home_url('/#nosotros')); ?>" aria-haspopup="true">
                        Nosotros
                        <span class="header-menu-chevron" aria-hidden="true"></span>
                    </a>

                    <div class="header-dropdown header-dropdown--compact">
                        <a href="<?php echo esc_url(home_url('/weare/')); ?>">
                            Quiénes somos
                            <span aria-hidden="true">›</span>
                        </a>
                        <a href="<?php echo esc_url(home_url('/team/')); ?>">
                            Nuestro equipo
                            <span aria-hidden="true">›</span>
                        </a>
                    </div>
                </li>
            </ul>
        </nav>

        <div class="header-tools">
            <a class="primary-link" href="<?php echo esc_url($header_cta_url); ?>"><?php echo esc_html($header_cta_text); ?></a>
        </div>

        <button class="mobile-menu-toggle" type="button" aria-label="Abrir menú" aria-controls="mobile-menu" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <?php if (!empty($header_social_links)) : ?>
            <div class="header-social" aria-label="Redes sociales">
                <?php foreach ($header_social_links as $social_link) : ?>
                    <a href="<?php echo esc_url($social_link['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_link['label']); ?>">
                        <img src="<?php echo esc_url($social_link['icon']); ?>" alt="">
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php if (file_exists($header_iso_badge_path)) : ?>
        <div class="header-iso-ribbon" aria-label="Certificación ISO 9001">
            <img src="<?php echo esc_url($header_iso_badge_url); ?>" alt="ISO 9001">
        </div>
    <?php endif; ?>
</header>

<div class="mobile-menu-backdrop" data-menu-close></div>
<div class="mobile-menu-panel" id="mobile-menu" aria-hidden="true">
    <div class="mobile-menu-head">
        <a class="mobile-menu-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Inicio GYA">
            <?php if ($header_logo_markup !== '') : ?>
                <?php echo $header_logo_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Trusted local SVG. ?>
            <?php else : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/logo.svg'); ?>" alt="G&amp;A">
            <?php endif; ?>
        </a>
        <button class="mobile-menu-close" type="button" aria-label="Cerrar menú">×</button>
    </div>

    <nav class="mobile-menu-nav" aria-label="Menú móvil">
        <a class="<?php echo is_front_page() ? 'is-current' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">INICIO</a>
        <a class="<?php echo ($header_is_areas_request || $header_is_category_request) ? 'is-current' : ''; ?>" href="<?php echo esc_url(home_url('/areas/')); ?>">ÁREAS</a>
        <a class="<?php echo ($header_is_team_request || $header_is_member_request) ? 'is-current' : ''; ?>" href="<?php echo esc_url(home_url('/team/')); ?>">NUESTRO EQUIPO</a>
        <a class="mobile-menu-cta <?php echo $header_is_contact_request ? 'is-current' : ''; ?>" href="<?php echo esc_url(home_url('/contact/')); ?>">CONTACTO <span aria-hidden="true">→</span></a>

        <strong>NUESTRAS REDES</strong>
        <div class="mobile-menu-social">
            <?php if (!empty($header_social_links)) : ?>
                <?php foreach ($header_social_links as $social_link) : ?>
                    <a href="<?php echo esc_url($social_link['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_link['label']); ?>">
                        <img src="<?php echo esc_url($social_link['icon']); ?>" alt="">
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </nav>
</div>

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
$header_is_insights_active = is_post_type_archive('insights') || is_singular('insights');
$header_logo_path = get_template_directory() . '/assets/images/icons/logo.svg';
$header_logo_markup = '';

$header_is_areas_request = function_exists('gya_is_areas_page_request') && gya_is_areas_page_request();
$header_is_team_request = function_exists('gya_is_team_page_request') && gya_is_team_page_request();
$header_is_firma_request = function_exists('gya_is_weare_page_request') && gya_is_weare_page_request();
$header_is_category_request = is_singular('gya_category');
$header_is_contact_request = function_exists('gya_is_contact_page_request') && gya_is_contact_page_request();
$header_is_member_request = is_singular('team_member');
$header_is_privacy_request = (function_exists('gya_is_privacy_page_request') && gya_is_privacy_page_request())
    || (function_exists('gya_is_cookies_page_request') && gya_is_cookies_page_request());

if (file_exists($header_logo_path)) {
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
</header>
<?php if (!(is_front_page() || $header_is_areas_request || $header_is_team_request || $header_is_category_request || $header_is_contact_request || $header_is_member_request || $header_is_privacy_request)) : ?>
    <div class="site-header-spacer" aria-hidden="true"></div>
<?php endif; ?>

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
        <a class="<?php echo $header_is_firma_request ? 'is-current' : ''; ?>" href="<?php echo esc_url(home_url('/weare/')); ?>">LA FIRMA</a>
        <a href="https://capacitaciongya.educacionitel.com/">CURSOS</a>
        <a class="<?php echo $header_is_insights_active ? 'is-current' : ''; ?>" href="<?php echo esc_url(get_post_type_archive_link('insights')); ?>">CONTENIDOS</a>
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

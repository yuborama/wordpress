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
?>
<header class="site-header" id="top">
    <div class="shell header-inner">
        <a class="logo-mark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Inicio GYA">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/logo.svg'); ?>" alt="G&amp;A">
        </a>

        <nav class="desktop-nav" aria-label="Principal">
            <ul class="header-menu">
                <li class="header-menu-item header-menu-item--dropdown">
                    <a class="header-menu-link" href="<?php echo esc_url(home_url('/#soluciones')); ?>" aria-haspopup="true">
                        Soluciones
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
                    <a class="header-menu-link" href="<?php echo esc_url(home_url('/#servicios')); ?>">Cómo ayudamos</a>
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
    </div>
    <?php if (file_exists($header_iso_badge_path)) : ?>
        <div class="header-iso-ribbon" aria-label="Certificación ISO 9001">
            <img src="<?php echo esc_url($header_iso_badge_url); ?>" alt="ISO 9001">
        </div>
    <?php endif; ?>
</header>

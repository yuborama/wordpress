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
?>
<header class="site-header" id="top">
    <div class="shell header-inner">
        <a class="logo-mark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Inicio GYA">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/logo.svg'); ?>" alt="G&amp;A">
        </a>

        <nav class="desktop-nav" aria-label="Principal">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'menu',
                    'fallback_cb' => 'gya_primary_menu_fallback',
                )
            );
            ?>
        </nav>

        <div class="header-tools">
            <a class="primary-link" href="<?php echo esc_url($header_cta_url); ?>"><?php echo esc_html($header_cta_text); ?></a>
        </div>
    </div>
</header>

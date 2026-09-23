<?php

if (!defined('ABSPATH')) {
    exit;
}

$portrait = wp_parse_args(
    isset($args) && is_array($args) ? $args : array(),
    array(
        'class' => '',
        'image_url' => '',
        'alt' => '',
        'loading' => 'lazy',
    )
);

$background_id = absint(get_option('gya_team_background_image_id', 0));
$background_url = $background_id ? wp_get_attachment_image_url($background_id, 'full') : '';
$portrait_class = trim('team-portrait ' . $portrait['class']);
$loading = $portrait['loading'] === 'eager' ? 'eager' : 'lazy';
?>
<div class="<?php echo esc_attr($portrait_class); ?>">
    <?php if ($background_url) : ?>
        <img class="team-portrait__background" src="<?php echo esc_url($background_url); ?>" alt="" aria-hidden="true">
    <?php endif; ?>
    <?php if ($portrait['image_url']) : ?>
        <img class="team-portrait__person" src="<?php echo esc_url($portrait['image_url']); ?>" alt="<?php echo esc_attr($portrait['alt']); ?>" loading="<?php echo esc_attr($loading); ?>">
    <?php endif; ?>
</div>

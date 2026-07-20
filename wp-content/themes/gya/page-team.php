<?php

if (!defined('ABSPATH')) {
    exit;
}

$team_query = new WP_Query(
    array(
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
        'no_found_rows' => true,
    )
);

$team_members = array();

if ($team_query->have_posts()) {
    while ($team_query->have_posts()) {
        $team_query->the_post();

        $member_id = get_the_ID();
        $name = gya_get_post_field_value('name', $member_id, get_the_title());
        $position = gya_get_post_field_value('position', $member_id, '');
        $order = gya_get_post_field_value('order', $member_id, '');
        $image = gya_get_post_field_value('image', $member_id, '');
        $image_url = '';

        if (is_array($image) && isset($image['url'])) {
            $image_url = $image['url'];
        } elseif (is_numeric($image)) {
            $image_url = wp_get_attachment_image_url((int) $image, 'medium');
        } elseif (is_string($image)) {
            $image_url = $image;
        }

        if (!$image_url && has_post_thumbnail($member_id)) {
            $image_url = get_the_post_thumbnail_url($member_id, 'medium');
        }

        $name_parts = preg_split('/\s+/', trim($name));
        $initials = '';

        if (!empty($name_parts[0])) {
            $initials .= function_exists('mb_substr') ? mb_substr($name_parts[0], 0, 1) : substr($name_parts[0], 0, 1);
        }

        if (!empty($name_parts[1])) {
            $initials .= function_exists('mb_substr') ? mb_substr($name_parts[1], 0, 1) : substr($name_parts[1], 0, 1);
        }

        $team_members[] = array(
            'name' => $name,
            'position' => $position,
            'image' => $image_url ? $image_url : '',
            'initials' => $initials,
            'order' => is_numeric($order) ? (int) $order : PHP_INT_MAX,
            'date' => get_the_date('U'),
            'url' => get_permalink($member_id),
        );
    }

    wp_reset_postdata();
}

usort(
    $team_members,
    function ($a, $b) {
        if ($a['order'] === $b['order']) {
            return $a['date'] <=> $b['date'];
        }

        return $a['order'] <=> $b['order'];
    }
);

$upload_dir = wp_upload_dir();
$network_image = trailingslashit($upload_dir['baseurl']) . '2026/07/network-bg.png';
$hero_image = trailingslashit($upload_dir['baseurl']) . '2026/07/insightsCardTeam.jpg';
$whatsapp_url = get_option('gya_social_whatsapp', '');
$whatsapp_icon = get_template_directory_uri() . '/assets/images/icons/social/whatsapp.svg';

get_header();
?>
<main class="team-page">
    <section class="team-page-hero">
        <div class="team-page-hero__image" style="background-image:url('<?php echo esc_url($hero_image); ?>');"></div>
        <div class="team-page-hero__network" style="background-image:url('<?php echo esc_url($network_image); ?>');"></div>
        <div class="shell team-page-hero__inner">
            <div class="team-page-hero__copy">
                <span>NUESTRO EQUIPO</span>
                <h1>Profesionales que entienden <strong>tu negocio y hablan tu idioma.</strong></h1>
            </div>
        </div>
    </section>

    <section class="team-page-content">
        <div class="shell">
            <?php if (!empty($team_members)) : ?>
                <div class="team-page-grid">
                    <?php foreach ($team_members as $member) : ?>
                        <a class="team-card" href="<?php echo esc_url($member['url']); ?>">
                            <div class="avatar">
                                <?php if (!empty($member['image'])) : ?>
                                    <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                                <?php else : ?>
                                    <span><?php echo esc_html($member['initials']); ?></span>
                                <?php endif; ?>
                            </div>
                            <h3><?php echo esc_html($member['name']); ?></h3>
                            <?php if (!empty($member['position'])) : ?>
                                <p><?php echo esc_html($member['position']); ?></p>
                            <?php endif; ?>
                            <div class="contact-icons">
                                <span class="icon icon-mail">
                                    <svg viewBox="0 0 24 24" focusable="false">
                                        <path d="M4 6h16v12H4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                        <path d="m4 7 8 6 8-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <?php if (!empty($whatsapp_url)) : ?>
                                    <span class="icon icon-whatsapp js-whatsapp-action" role="link" tabindex="0" data-whatsapp-url="<?php echo esc_url($whatsapp_url); ?>" aria-label="Abrir WhatsApp">
                                        <img src="<?php echo esc_url($whatsapp_icon); ?>" alt="">
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="team-page-empty">No hay miembros del equipo publicados.</p>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
get_footer();

<?php

if (!defined('ABSPATH')) {
    exit;
}

$team_query = new WP_Query(
    array(
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => array('menu_order' => 'ASC', 'title' => 'ASC'),
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
        $image = gya_get_post_field_value('image', $member_id, '');
        $image_url = '';

        if (is_array($image) && isset($image['url'])) {
            $image_url = $image['url'];
        } elseif (is_numeric($image)) {
            $image_url = wp_get_attachment_image_url((int) $image, 'large');
        } elseif (is_string($image)) {
            $image_url = $image;
        }

        if (!$image_url && has_post_thumbnail($member_id)) {
            $image_url = get_the_post_thumbnail_url($member_id, 'large');
        }

        $member_categories = wp_get_post_terms($member_id, 'team_category', array('fields' => 'slugs'));
        $group = !is_wp_error($member_categories) && !empty($member_categories) ? $member_categories[0] : 'colaboradores';

        $team_members[] = array(
            'name' => $name,
            'position' => $position,
            'image' => $image_url,
            'group' => $group,
            'url' => get_permalink($member_id),
        );
    }

    wp_reset_postdata();
}

$team_groups = array(
    'socios' => 'SOCIOS',
    'directores' => 'DIRECTORES',
    'gerentes' => 'GERENTES',
    'colaboradores' => 'COLABORADORES',
);
?>
<div class="team-directory" data-team-directory data-active-group="gerentes">
    <div class="team-directory__filters" role="tablist" aria-label="Filtrar equipo por puesto">
        <?php foreach ($team_groups as $group_key => $group_label) : ?>
            <button
                class="team-directory__filter <?php echo $group_key === 'gerentes' ? 'is-active' : ''; ?>"
                type="button"
                role="tab"
                aria-selected="<?php echo $group_key === 'gerentes' ? 'true' : 'false'; ?>"
                data-team-filter="<?php echo esc_attr($group_key); ?>">
                <?php echo esc_html($group_label); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($team_members)) : ?>
        <div class="team-directory__grid" aria-live="polite">
            <?php foreach ($team_members as $member) : ?>
                <a class="team-profile-card" href="<?php echo esc_url($member['url']); ?>" data-team-member="<?php echo esc_attr($member['group']); ?>">
                    <?php
                    get_template_part(
                        'template-parts/team-portrait',
                        null,
                        array(
                            'class' => 'team-profile-card__media',
                            'image_url' => $member['image'],
                            'alt' => $member['name'],
                        )
                    );
                    ?>
                    <div class="team-profile-card__body">
                        <h2><?php echo esc_html($member['name']); ?></h2>
                        <?php if ($member['position']) : ?>
                            <p><?php echo esc_html($member['position']); ?></p>
                        <?php endif; ?>
                        <span aria-hidden="true">→</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <p class="team-directory__empty" data-team-empty hidden>No hay integrantes publicados en esta categoría.</p>
    <?php else : ?>
        <p class="team-directory__empty">No hay miembros del equipo publicados.</p>
    <?php endif; ?>
</div>

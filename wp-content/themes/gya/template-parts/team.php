<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = isset($args['data']) ? $args['data'] : gya_get_landing_data();
$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$team = isset($data['team']) ? $data['team'] : array();
$team_heading = gya_get_field_value('gya_team_heading', 'Profesionales que entienden tu negocio y hablan tu idioma.', $page_id);
$team = gya_get_fixed_items_from_acf($team, 'gya_team', array('name', 'role'), 4, $page_id);
?>
<section class="section light-section" id="equipo">
    <div class="shell">
        <header class="section-header">
            <span>NUESTRO EQUIPO</span>
            <h2><?php echo esc_html($team_heading); ?></h2>
        </header>
        <div class="team-grid">
            <?php foreach ($team as $member) : ?>
                <article class="team-card">
                    <h3><?php echo esc_html($member['name']); ?></h3>
                    <p><?php echo esc_html($member['role']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
        <a class="primary-button" href="#contacto">Explora nuestro equipo y experiencia</a>
    </div>
</section>

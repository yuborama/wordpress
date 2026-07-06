<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = isset($args['data']) ? $args['data'] : gya_get_landing_data();
$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$solutions = isset($data['solutions']) ? $data['solutions'] : array();
$solutions_heading = gya_get_field_value('gya_solutions_heading', 'Acompañamos cada área clave de tu empresa.', $page_id);
$solutions = gya_get_fixed_items_from_acf($solutions, 'gya_solution', array('title', 'body'), 4, $page_id);
?>
<section class="section light-section" id="soluciones">
    <div class="shell">
        <header class="section-header">
            <span>SOLUCIONES INTEGRALES</span>
            <h2><?php echo esc_html($solutions_heading); ?></h2>
        </header>
        <div class="solutions-page">
            <?php foreach ($solutions as $solution) : ?>
                <article class="solution-card">
                    <h3><?php echo esc_html($solution['title']); ?> <span>&rsaquo;</span></h3>
                    <p><?php echo esc_html($solution['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

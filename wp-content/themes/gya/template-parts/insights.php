<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = isset($args['data']) ? $args['data'] : gya_get_landing_data();
$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$insights = isset($data['insights']) ? $data['insights'] : array();
$insights_heading = gya_get_field_value('gya_insights_heading', 'Información clave para tomar mejores decisiones.', $page_id);
$insights = gya_get_fixed_items_from_acf($insights, 'gya_insight', array('tag', 'title', 'body', 'author', 'image'), 3, $page_id);
?>
<section class="section light-section" id="insights">
    <div class="shell">
        <header class="section-header">
            <span>INSIGHTS</span>
            <h2><?php echo esc_html($insights_heading); ?></h2>
        </header>
        <div class="insights-grid">
            <?php foreach ($insights as $insight) : ?>
                <article class="insight-card">
                    <div class="insight-photo" style="background-image:url('<?php echo esc_url($insight['image']); ?>');"></div>
                    <div class="insight-copy">
                        <span class="tag"><?php echo esc_html($insight['tag']); ?></span>
                        <h3><?php echo esc_html($insight['title']); ?> <span>&rsaquo;</span></h3>
                        <p><?php echo esc_html($insight['body']); ?></p>
                        <small><?php echo esc_html($insight['author']); ?></small>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

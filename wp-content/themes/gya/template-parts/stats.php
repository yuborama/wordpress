<?php
if (!defined('ABSPATH')) {
    exit;
}

$stats = isset($args['stats']) ? $args['stats'] : array();
$stats_heading = isset($args['heading']) ? $args['heading'] : '';
?>
<section class="gya-stats" aria-label="Indicadores">
    <?php if ($stats_heading !== '') : ?>
        <h2 class="gya-design-shell gya-stats__heading"><?php echo esc_html($stats_heading); ?></h2>
    <?php endif; ?>
    <div class="gya-design-shell gya-stats__grid">
        <?php foreach ($stats as $stat) : ?>
            <article>
                <strong><?php echo esc_html($stat['value']); ?></strong>
                <span><?php echo esc_html($stat['label']); ?></span>
            </article>
        <?php endforeach; ?>
    </div>
</section>

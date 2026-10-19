<?php

if (!defined('ABSPATH')) {
    exit;
}

$data = gya_get_landing_data();
$page_id = (int) get_option('page_on_front');

get_header();
?>
<main>
    <?php get_template_part('template-parts/hero', null, array('data' => $data, 'page_id' => $page_id)); ?>
    <?php get_template_part('template-parts/solutions', null, array('data' => $data, 'page_id' => $page_id)); ?>
    <?php get_template_part('template-parts/services', null, array('data' => $data, 'page_id' => $page_id)); ?>
    <?php get_template_part('template-parts/insights', null, array('data' => $data, 'page_id' => $page_id)); ?>
    <?php get_template_part('template-parts/cta-banner', null, array('page_id' => $page_id)); ?>
    <?php get_template_part('template-parts/team', null, array('data' => $data, 'page_id' => $page_id)); ?>
</main>
<?php
get_footer();


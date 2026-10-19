<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="team-directory-page">
    <section class="team-directory-page__content" aria-label="Nuestro equipo">
        <div class="shell">
            <?php get_template_part('template-parts/team'); ?>
        </div>
    </section>
</main>
<?php
get_footer();

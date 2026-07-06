<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="section light-section">
    <div class="shell">
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article <?php post_class(); ?>>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No hay contenido disponible.</p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();

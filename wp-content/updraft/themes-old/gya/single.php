<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="section light-section">
    <div class="shell">
        <?php while (have_posts()) : the_post(); ?>
            <article <?php post_class('blog-post'); ?>>
                <h1><?php the_title(); ?></h1>
                <p><small><?php echo esc_html(get_the_date()); ?></small></p>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="blog-post-thumbnail"><?php the_post_thumbnail('large'); ?></div>
                <?php endif; ?>
                <?php the_content(); ?>
            </article>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();

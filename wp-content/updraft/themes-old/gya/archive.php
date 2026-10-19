<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main class="section light-section">
    <div class="shell">
        <header class="section-header">
            <span>BLOG</span>
            <h2><?php the_archive_title(); ?></h2>
        </header>

        <?php if (have_posts()) : ?>
            <div class="blog-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="blog-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium_large'); ?></a>
                        <?php endif; ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="archive-pagination">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p>No se encontraron entradas.</p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();

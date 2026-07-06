<?php

if (!defined('ABSPATH')) {
    exit;
}

$latest_posts = new WP_Query(
    array(
        'post_type' => 'post',
        'posts_per_page' => 3,
    )
);
?>
<section class="section light-section" id="blog">
    <div class="shell">
        <header class="section-header">
            <span>BLOG</span>
            <h2>Ultimos articulos</h2>
        </header>

        <div class="blog-grid">
            <?php if ($latest_posts->have_posts()) : ?>
                <?php while ($latest_posts->have_posts()) : $latest_posts->the_post(); ?>
                    <article class="blog-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium_large'); ?>
                            </a>
                        <?php endif; ?>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <p>No hay articulos todavia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

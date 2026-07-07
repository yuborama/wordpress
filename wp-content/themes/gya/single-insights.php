<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $insight_id = get_the_ID();
    $title = gya_get_post_field_value('title', $insight_id, get_the_title());
    $short_description = gya_get_post_field_value('short_description', $insight_id, '');
    $long_description = gya_get_post_field_value('long_description', $insight_id, '');
    $featured_image = has_post_thumbnail($insight_id) ? get_the_post_thumbnail_url($insight_id, 'full') : '';
    $upload_dir = wp_upload_dir();
    $network_image = trailingslashit($upload_dir['baseurl']) . '2026/07/network-bg.png';

    $tags = gya_get_post_field_value('tags', $insight_id, array());
    $tag = is_array($tags) ? reset($tags) : $tags;
    $tag_id = $tag instanceof WP_Post ? $tag->ID : (int) $tag;
    $tag_name = $tag_id ? get_the_title($tag_id) : '';

    $author_posts = gya_get_post_field_value('person_in_charge', $insight_id, array());
    $author_post = is_array($author_posts) ? reset($author_posts) : $author_posts;
    $author_id = $author_post instanceof WP_Post ? $author_post->ID : (int) $author_post;
    $author_name = $author_id ? gya_get_post_field_value('name', $author_id, get_the_title($author_id)) : '';
    $author_image = $author_id ? gya_get_post_field_value('image', $author_id, '') : '';

    if (is_array($author_image) && isset($author_image['url'])) {
        $author_image = $author_image['url'];
    } elseif (is_numeric($author_image)) {
        $author_image = wp_get_attachment_image_url((int) $author_image, 'large');
    } elseif (!is_string($author_image)) {
        $author_image = '';
    }

    if (!$author_image && $author_id && has_post_thumbnail($author_id)) {
        $author_image = get_the_post_thumbnail_url($author_id, 'large');
    }
    ?>
    <main class="insight-detail">
        <section class="insight-detail-hero">
            <?php if (!empty($featured_image)) : ?>
                <div class="insight-detail-hero__image" style="background-image:url('<?php echo esc_url($featured_image); ?>');"></div>
            <?php endif; ?>
            <div class="shell insight-detail-hero__inner">
                <?php if (!empty($tag_name)) : ?>
                    <span class="insight-detail-hero__tag"><?php echo esc_html($tag_name); ?></span>
                <?php endif; ?>
                <h1><?php echo esc_html($title); ?></h1>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                <?php if (!empty($author_name)) : ?>
                    <div class="insight-detail-author">
                        <span>
                            <?php if (!empty($author_image)) : ?>
                                <img src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>">
                            <?php else : ?>
                                <?php echo esc_html(substr($author_name, 0, 1)); ?>
                            <?php endif; ?>
                        </span>
                        <small><?php echo esc_html($author_name); ?></small>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="insight-detail-content">
            <div class="shell insight-detail-content__inner">
                <?php if (!empty($short_description)) : ?>
                    <p class="insight-detail-lead"><?php echo esc_html($short_description); ?></p>
                <?php endif; ?>

                <div class="insight-detail-body">
                    <?php
                    if (!empty($long_description)) {
                        echo wp_kses_post($long_description);
                    } else {
                        the_content();
                    }
                    ?>
                </div>
            </div>
        </section>

        <section class="insight-video-cta">
            <div class="shell">
                <article class="insight-video-card" style="background-image:url('<?php echo esc_url($network_image); ?>');">
                    <div class="insight-video-card__copy">
                        <h2>Nuestros especialistas te lo explican.</h2>
                        <p>Profundiza en este tema a traves de nuestras sesiones especializadas, donde compartimos experiencias, recomendaciones y casos practicos para ayudarte a tomar mejores decisiones.</p>
                        <a class="outline-link" href="https://www.youtube.com/" target="_blank" rel="noopener">Revisa nuestros cursos en YouTube <span>&rsaquo;</span></a>
                    </div>
                    <?php if (!empty($author_image)) : ?>
                        <img class="insight-video-card__person" src="<?php echo esc_url($author_image); ?>" alt="<?php echo esc_attr($author_name); ?>">
                    <?php endif; ?>
                    <span class="insight-video-card__youtube" aria-hidden="true"></span>
                </article>
            </div>
        </section>
    </main>
    <?php
endwhile;

get_footer();

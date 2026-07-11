<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('gya_category_detail_meta_query')) {
    function gya_category_detail_meta_query($post_id, $field_names) {
        $meta_query = array('relation' => 'OR');

        foreach ($field_names as $field_name) {
            $meta_query[] = array(
                'key' => $field_name,
                'value' => (string) $post_id,
                'compare' => '=',
            );
            $meta_query[] = array(
                'key' => $field_name,
                'value' => '"' . $post_id . '"',
                'compare' => 'LIKE',
            );
            $meta_query[] = array(
                'key' => $field_name,
                'value' => 'i:' . $post_id . ';',
                'compare' => 'LIKE',
            );
        }

        return $meta_query;
    }
}

if (!function_exists('gya_category_detail_author_data')) {
    function gya_category_detail_author_data($insight_id) {
        $author_posts = gya_get_post_field_value('person_in_charge', $insight_id, array());
        $author_post = is_array($author_posts) ? reset($author_posts) : $author_posts;
        $author_id = $author_post instanceof WP_Post ? $author_post->ID : (int) $author_post;
        $author_name = $author_id ? gya_get_post_field_value('name', $author_id, get_the_title($author_id)) : '';
        $author_image = $author_id ? gya_get_post_field_value('image', $author_id, '') : '';

        if (is_array($author_image) && isset($author_image['url'])) {
            $author_image = $author_image['url'];
        } elseif (is_numeric($author_image)) {
            $author_image = wp_get_attachment_image_url((int) $author_image, 'thumbnail');
        } elseif (!is_string($author_image)) {
            $author_image = '';
        }

        if (!$author_image && $author_id && has_post_thumbnail($author_id)) {
            $author_image = get_the_post_thumbnail_url($author_id, 'thumbnail');
        }

        return array(
            'name' => $author_name,
            'image' => $author_image,
            'initial' => $author_name !== '' ? substr($author_name, 0, 1) : '',
        );
    }
}

get_header();

while (have_posts()) :
    the_post();

    $category_id = get_the_ID();
    $category_title = get_the_title();
    $category_description = gya_get_post_field_value('short_description', $category_id, '');

    if ($category_description === '') {
        $category_description = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $category_id, '')), 24);
    }

    $upload_dir = wp_upload_dir();
    $fallback_hero_image = trailingslashit($upload_dir['baseurl']) . '2026/07/network-bg.png';
    $hero_image = has_post_thumbnail($category_id) ? get_the_post_thumbnail_url($category_id, 'full') : $fallback_hero_image;

    $subcategories_query = new WP_Query(
        array(
            'post_type' => 'gya_subcategory',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => array(
                'menu_order' => 'ASC',
                'date' => 'ASC',
            ),
            'meta_query' => gya_category_detail_meta_query(
                $category_id,
                array('parent_category')
            ),
            'no_found_rows' => true,
        )
    );

    $insights_query = new WP_Query(
        array(
            'post_type' => 'insights',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'meta_query' => gya_category_detail_meta_query($category_id, array('tags')),
            'no_found_rows' => true,
        )
    );
    ?>
    <main class="category-detail">
        <section class="category-detail-hero">
            <div class="category-detail-hero__image" style="background-image:url('<?php echo esc_url($hero_image); ?>');"></div>
            <div class="shell category-detail-hero__inner">
                <h1><?php echo esc_html($category_title); ?></h1>
                <?php if (!empty($category_description)) : ?>
                    <p><?php echo esc_html($category_description); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <section class="category-detail-section category-detail-solutions">
            <div class="shell">
                <span class="category-detail-eyebrow">SOLUCIONES</span>
                <?php if ($subcategories_query->have_posts()) : ?>
                    <div class="category-detail-solutions-grid">
                        <?php while ($subcategories_query->have_posts()) : $subcategories_query->the_post(); ?>
                            <?php
                            $subcategory_id = get_the_ID();
                            $subcategory_title = gya_get_post_field_value('title', $subcategory_id, get_the_title());
                            $subcategory_description = gya_get_post_field_value('description', $subcategory_id, '');
                            ?>
                            <article class="category-detail-solution-card">
                                <h2><?php echo esc_html($subcategory_title); ?> <span>&rsaquo;</span></h2>
                                <?php if (!empty($subcategory_description)) : ?>
                                    <p><?php echo esc_html($subcategory_description); ?></p>
                                <?php endif; ?>
                            </article>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </section>

        <?php if ($insights_query->have_posts()) : ?>
            <section class="category-detail-section category-detail-insights">
                <div class="shell">
                    <span class="category-detail-eyebrow">INSIGHTS</span>
                    <div class="insights-grid category-detail-insights-grid">
                        <?php while ($insights_query->have_posts()) : $insights_query->the_post(); ?>
                            <?php
                            $insight_id = get_the_ID();
                            $insight_title = gya_get_post_field_value('title', $insight_id, get_the_title());
                            $insight_body = gya_get_post_field_value('short_description', $insight_id, '');

                            if ($insight_body === '') {
                                $insight_body = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $insight_id, '')), 22, '...');
                            }

                            $author = gya_category_detail_author_data($insight_id);
                            ?>
                            <a class="insight-card" href="<?php echo esc_url(get_permalink($insight_id)); ?>">
                                <div class="insight-photo" style="background-image:url('<?php echo esc_url(has_post_thumbnail($insight_id) ? get_the_post_thumbnail_url($insight_id, 'large') : ''); ?>');"></div>
                                <div class="insight-copy">
                                    <span class="tag"><?php echo esc_html($category_title); ?></span>
                                    <h3><?php echo esc_html($insight_title); ?> <span>&rsaquo;</span></h3>
                                    <?php if (!empty($insight_body)) : ?>
                                        <p><?php echo esc_html($insight_body); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($author['name'])) : ?>
                                        <div class="author">
                                            <span>
                                                <?php if (!empty($author['image'])) : ?>
                                                    <img src="<?php echo esc_url($author['image']); ?>" alt="<?php echo esc_attr($author['name']); ?>">
                                                <?php else : ?>
                                                    <?php echo esc_html($author['initial']); ?>
                                                <?php endif; ?>
                                            </span>
                                            <small><?php echo esc_html($author['name']); ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endwhile; ?>
                    </div>
                    <a class="primary-button category-detail-insights-cta" href="<?php echo esc_url(get_post_type_archive_link('insights')); ?>">Explorar insights</a>
                </div>
            </section>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>

        <?php get_template_part('template-parts/cta-banner', null, array('page_id' => (int) get_option('page_on_front'))); ?>
    </main>
    <?php
endwhile;

get_footer();

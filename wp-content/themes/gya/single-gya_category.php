<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $category_id = get_the_ID();
    $category_title = get_the_title();
    $category_slug = get_post_field('post_name', $category_id);
    $category_description = gya_get_post_field_value('short_description', $category_id, '');

    if ($category_description === '') {
        $category_description = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $category_id, '')), 28, '...');
    }

    $upload_dir = wp_upload_dir();
    $upload_base = trailingslashit($upload_dir['baseurl']) . '2026/07/';
    $hero_fallbacks = array(
        'fiscal-y-financiero' => $upload_base . 'cardservice1.jpg',
        'legal' => $upload_base . 'BANNER-2.png',
        'auditoria' => $upload_base . 'cardservice3.jpg',
        'nominas' => $upload_base . 'office2.jpg',
        'ept' => $upload_base . 'EPT.png',
        't-i' => $upload_base . 'insightsCardTeam.jpg',
    );
    $hero_image = has_post_thumbnail($category_id) ? get_the_post_thumbnail_url($category_id, 'full') : '';

    if (!$hero_image) {
        $hero_image = isset($hero_fallbacks[$category_slug]) ? $hero_fallbacks[$category_slug] : $upload_base . 'BANNER-2.png';
    }

    $subcategories_query = new WP_Query(
        array(
            'post_type' => 'gya_subcategory',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => array(
                'menu_order' => 'ASC',
                'date' => 'ASC',
            ),
            'meta_query' => gya_relationship_meta_query('parent_category', $category_id),
            'no_found_rows' => true,
        )
    );
    ?>
    <main class="category-detail">
        <section class="category-detail-hero" aria-labelledby="category-title">
            <div class="category-detail-hero__image" style="background-image:url('<?php echo esc_url($hero_image); ?>');"></div>
            <div class="shell category-detail-hero__inner">
                <h1 id="category-title"><?php echo esc_html($category_title); ?></h1>
                <?php if ($category_description !== '') : ?>
                    <p><?php echo esc_html($category_description); ?></p>
                <?php endif; ?>
            </div>
        </section>

        <section class="category-detail-solutions" aria-labelledby="solutions-title">
            <div class="shell">
                <h2 class="category-detail-eyebrow" id="solutions-title">SOLUCIONES</h2>
                <?php if ($subcategories_query->have_posts()) : ?>
                    <div class="category-detail-solutions-grid">
                        <?php while ($subcategories_query->have_posts()) : ?>
                            <?php
                            $subcategories_query->the_post();
                            $subcategory_id = get_the_ID();
                            $subcategory_title = gya_get_post_field_value('title', $subcategory_id, get_the_title());
                            $subcategory_description = gya_get_post_field_value('description', $subcategory_id, '');
                            ?>
                            <a class="category-detail-solution-card" href="<?php echo esc_url(get_permalink($subcategory_id)); ?>">
                                <h3><?php echo esc_html($subcategory_title); ?></h3>
                                <?php if ($subcategory_description !== '') : ?>
                                    <p><?php echo esc_html($subcategory_description); ?></p>
                                <?php endif; ?>
                                <span aria-hidden="true">→</span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="category-detail-empty">No hay soluciones publicadas para esta área.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php
        get_template_part(
            'template-parts/relations-section',
            null,
            array(
                'section_class' => 'category-detail-relations',
                'inner_class' => 'shell category-detail-relations__grid',
                'copy_class' => '',
                'title_id' => 'category-relations-title',
            )
        );
        ?>
    </main>
    <?php
endwhile;

get_footer();

<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('gya_insights_archive_relationship_clause')) {
    function gya_insights_archive_relationship_clause($field_name, $post_id) {
        return array(
            'relation' => 'OR',
            array(
                'key' => $field_name,
                'value' => (string) $post_id,
                'compare' => '=',
            ),
            array(
                'key' => $field_name,
                'value' => '"' . $post_id . '"',
                'compare' => 'LIKE',
            ),
            array(
                'key' => $field_name,
                'value' => 'i:' . $post_id . ';',
                'compare' => 'LIKE',
            ),
        );
    }
}

if (!function_exists('gya_insights_archive_relationship_any_clause')) {
    function gya_insights_archive_relationship_any_clause($field_name, $post_ids) {
        $meta_query = array('relation' => 'OR');

        foreach ($post_ids as $post_id) {
            $meta_query[] = gya_insights_archive_relationship_clause($field_name, (int) $post_id);
        }

        return $meta_query;
    }
}

if (!function_exists('gya_insights_archive_author_data')) {
    function gya_insights_archive_author_data($insight_id) {
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

$selected_area = isset($_GET['area']) ? absint($_GET['area']) : 0;
$selected_category_value = isset($_GET['category']) ? sanitize_text_field(wp_unslash($_GET['category'])) : '';
$selected_category_ids = array_values(
    array_filter(
        array_map('absint', preg_split('/,/', $selected_category_value)),
        function ($category_id) {
            return $category_id > 0;
        }
    )
);
$paged = max(1, get_query_var('paged') ? (int) get_query_var('paged') : (int) get_query_var('page'));

$areas = get_posts(
    array(
        'post_type' => 'gya_category',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
    )
);

$subcategory_args = array(
    'post_type' => 'gya_subcategory',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'title',
    'order' => 'ASC',
);

if ($selected_area) {
    $subcategory_args['meta_query'] = gya_insights_archive_relationship_clause('parent_category', $selected_area);
}

$categories = get_posts($subcategory_args);
$category_options = array();

foreach ($categories as $category) {
    $category_title = gya_get_post_field_value('title', $category->ID, get_the_title($category));
    $category_key = sanitize_title($category_title);

    if (!isset($category_options[$category_key])) {
        $category_options[$category_key] = array(
            'title' => $category_title,
            'ids' => array(),
        );
    }

    $category_options[$category_key]['ids'][] = (int) $category->ID;
}

$meta_query = array();

if ($selected_area || !empty($selected_category_ids)) {
    $meta_query['relation'] = 'AND';

    if ($selected_area) {
        $meta_query[] = gya_insights_archive_relationship_clause('tags', $selected_area);
    }

    if (!empty($selected_category_ids)) {
        $meta_query[] = gya_insights_archive_relationship_any_clause('tags', $selected_category_ids);
    }
}

$insights_query_args = array(
    'post_type' => 'insights',
    'post_status' => 'publish',
    'posts_per_page' => 9,
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'DESC',
);

if (!empty($meta_query)) {
    $insights_query_args['meta_query'] = $meta_query;
}

$insights_query = new WP_Query($insights_query_args);
$upload_dir = wp_upload_dir();
$network_image = trailingslashit($upload_dir['baseurl']) . '2026/07/network-bg.png';
$hero_image = trailingslashit($upload_dir['baseurl']) . '2026/07/office.jpg';

get_header();
?>
<main class="insights-archive">
    <section class="insights-archive-hero">
        <div class="insights-archive-hero__image" style="background-image:url('<?php echo esc_url($hero_image); ?>');"></div>
        <div class="insights-archive-hero__network" style="background-image:url('<?php echo esc_url($network_image); ?>');"></div>
        <div class="shell insights-archive-hero__inner">
            <h1>Insights</h1>
            <p>Análisis, infografías y contenido especializado para ayudarte a entender los cambios que impactan tu empresa.</p>
        </div>
    </section>

    <section class="insights-archive-content">
        <div class="shell insights-archive-layout">
            <aside class="insights-archive-filters" aria-label="Filtros de insights">
                <form method="get" action="<?php echo esc_url(get_post_type_archive_link('insights')); ?>">
                    <label>
                        <span>Área</span>
                        <select name="area" onchange="this.form.category.value=''; this.form.submit()">
                            <option value="">Todas</option>
                            <?php foreach ($areas as $area) : ?>
                                <option value="<?php echo esc_attr((string) $area->ID); ?>" <?php selected($selected_area, $area->ID); ?>>
                                    <?php echo esc_html(get_the_title($area)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span>Categoría</span>
                        <select name="category" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            <?php foreach ($category_options as $category_option) : ?>
                                <?php $category_value = implode(',', array_unique($category_option['ids'])); ?>
                                <option value="<?php echo esc_attr($category_value); ?>" <?php selected($selected_category_value, $category_value); ?>>
                                    <?php echo esc_html($category_option['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </form>
            </aside>

            <div class="insights-archive-results">
                <?php if ($insights_query->have_posts()) : ?>
                    <div class="insights-grid insights-archive-grid">
                        <?php while ($insights_query->have_posts()) : $insights_query->the_post(); ?>
                            <?php
                            $insight_id = get_the_ID();
                            $title = gya_get_post_field_value('title', $insight_id, get_the_title());
                            $body = gya_get_post_field_value('short_description', $insight_id, '');

                            if ($body === '') {
                                $body = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $insight_id, '')), 22, '...');
                            }

                            $tags = gya_get_post_field_value('tags', $insight_id, array());
                            $tag = is_array($tags) ? reset($tags) : $tags;
                            $tag_id = $tag instanceof WP_Post ? $tag->ID : (int) $tag;
                            $author = gya_insights_archive_author_data($insight_id);
                            ?>
                            <a class="insight-card" href="<?php echo esc_url(get_permalink($insight_id)); ?>">
                                <div class="insight-photo" style="background-image:url('<?php echo esc_url(has_post_thumbnail($insight_id) ? get_the_post_thumbnail_url($insight_id, 'large') : ''); ?>');"></div>
                                <div class="insight-copy">
                                    <?php if ($tag_id) : ?>
                                        <span class="tag"><?php echo esc_html(get_the_title($tag_id)); ?></span>
                                    <?php endif; ?>
                                    <h3><?php echo esc_html($title); ?> <span>&rsaquo;</span></h3>
                                    <?php if (!empty($body)) : ?>
                                        <p><?php echo esc_html($body); ?></p>
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

                    <nav class="insights-archive-pagination" aria-label="Paginación de insights">
                        <?php
                        echo paginate_links(
                            array(
                                'total' => $insights_query->max_num_pages,
                                'current' => $paged,
                                'prev_text' => '<span aria-hidden="true">&larr;</span>',
                                'next_text' => '<span aria-hidden="true">&rarr;</span>',
                                'add_args' => array_filter(
                                    array(
                                        'area' => $selected_area ? $selected_area : null,
                                        'category' => $selected_category_value !== '' ? $selected_category_value : null,
                                    )
                                ),
                            )
                        );
                        ?>
                    </nav>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="insights-archive-empty">No se encontraron insights para los filtros seleccionados.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/cta-banner', null, array('page_id' => (int) get_option('page_on_front'))); ?>
</main>
<?php
get_footer();

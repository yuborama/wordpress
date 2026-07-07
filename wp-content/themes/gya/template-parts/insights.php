<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$insights_heading = gya_get_field_value('gya_insights_heading', 'Información clave para tomar mejores decisiones.', $page_id);

$insights_query = new WP_Query(
    array(
        'post_type' => 'insights',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
    )
);

$insights = array();

while ($insights_query->have_posts()) {
    $insights_query->the_post();

    $insight_id = get_the_ID();
    $title = gya_get_post_field_value('title', $insight_id, get_the_title());
    $body = gya_get_post_field_value('short_description', $insight_id, '');

    if ($body === '') {
        $body = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $insight_id, '')), 22, '...');
    }

    $tags = gya_get_post_field_value('tags', $insight_id, array());
    $tag = is_array($tags) ? reset($tags) : $tags;
    $tag_id = $tag instanceof WP_Post ? $tag->ID : (int) $tag;
    $author_posts = gya_get_post_field_value('person_in_charge', $insight_id, array());
    $author_post = is_array($author_posts) ? reset($author_posts) : $author_posts;
    $author_id = $author_post instanceof WP_Post ? $author_post->ID : (int) $author_post;
    $author = $author_id ? gya_get_post_field_value('name', $author_id, get_the_title($author_id)) : '';
    $author_image = $author_id ? gya_get_post_field_value('image', $author_id, '') : '';

    if (is_array($author_image) && isset($author_image['url'])) {
        $author_image = $author_image['url'];
    } elseif (is_numeric($author_image)) {
        $author_image = wp_get_attachment_image_url((int) $author_image, 'thumbnail');
    }

    $insights[] = array(
        'url' => get_permalink($insight_id),
        'tag' => $tag_id ? get_the_title($tag_id) : '',
        'title' => $title,
        'body' => $body,
        'author' => $author,
        'author_initial' => $author !== '' ? substr($author, 0, 1) : '',
        'author_image' => is_string($author_image) ? $author_image : '',
        'image' => has_post_thumbnail($insight_id) ? get_the_post_thumbnail_url($insight_id, 'large') : '',
    );
}

wp_reset_postdata();
?>
<section class="section light-section" id="insights">
    <div class="shell">
        <header class="section-header">
            <span>INSIGHTS</span>
            <h2><?php echo esc_html($insights_heading); ?></h2>
        </header>
        <div class="insights-grid">
            <?php foreach ($insights as $insight) : ?>
                <a class="insight-card" href="<?php echo esc_url($insight['url']); ?>">
                    <div class="insight-photo" style="background-image:url('<?php echo esc_url($insight['image']); ?>');"></div>
                    <div class="insight-copy">
                        <?php if (!empty($insight['tag'])) : ?>
                            <span class="tag"><?php echo esc_html($insight['tag']); ?></span>
                        <?php endif; ?>
                        <h3><?php echo esc_html($insight['title']); ?> <span>&rsaquo;</span></h3>
                        <?php if (!empty($insight['body'])) : ?>
                            <p><?php echo esc_html($insight['body']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($insight['author'])) : ?>
                            <div class="author">
                                <span>
                                    <?php if (!empty($insight['author_image'])) : ?>
                                        <img src="<?php echo esc_url($insight['author_image']); ?>" alt="<?php echo esc_attr($insight['author']); ?>">
                                    <?php else : ?>
                                        <?php echo esc_html($insight['author_initial']); ?>
                                    <?php endif; ?>
                                </span>
                                <small><?php echo esc_html($insight['author']); ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <a class="primary-button insights-cta" href="#insights">Explorar insights</a>
    </div>
</section>

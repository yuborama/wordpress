<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$insights_heading = gya_get_field_value('gya_insights_heading', 'Información clave para tomar mejores decisiones.', $page_id);

$carousel_autoplay_ms = function_exists('gya_get_duration_ms') ? gya_get_duration_ms('gya_carousel_duration_seconds', 10) : 10000;

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
        $author_image = wp_get_attachment_image_url((int) $author_image, 'medium');
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
        <div class="insights-slider js-insights-slider" data-insights-index="0" data-insights-autoplay="<?php echo esc_attr((string) $carousel_autoplay_ms); ?>">
            <div class="insights-grid">
                <?php foreach ($insights as $insight) : ?>
                    <div class="insights-slide">
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
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($insights) > 1) : ?>
                <div class="insights-dots" aria-label="Páginas de insights">
                    <?php foreach ($insights as $insight_index => $_insight) : ?>
                        <button
                            class="<?php echo $insight_index === 0 ? 'is-active' : ''; ?>"
                            type="button"
                            aria-label="<?php echo esc_attr(sprintf('Ir a insight %d', $insight_index + 1)); ?>"
                            <?php echo $insight_index === 0 ? 'aria-current="true"' : ''; ?>
                            data-insights-dot="<?php echo esc_attr((string) $insight_index); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <a class="primary-button insights-cta" href="<?php echo esc_url(get_post_type_archive_link('insights')); ?>">Explorar insights</a>
    </div>
</section>

<script>
(function () {
  var sliders = document.querySelectorAll('.js-insights-slider');
  if (!sliders.length) return;

  sliders.forEach(function (slider) {
    var track = slider.querySelector('.insights-grid');
    var slides = slider.querySelectorAll('.insights-slide');
    var dots = slider.querySelectorAll('[data-insights-dot]');
    var activeIndex = 0;
    var autoplayId = null;
    var autoplayMs = Number(slider.dataset.insightsAutoplay || 10000);

    if (!track || slides.length <= 1) return;

    function isCarouselMode() {
      return window.matchMedia && window.matchMedia('(max-width: 900px)').matches;
    }

    function setActiveSlide(index) {
      activeIndex = (index + slides.length) % slides.length;
      slider.dataset.insightsIndex = String(activeIndex);
      track.style.transform = isCarouselMode() ? 'translateX(-' + activeIndex * 100 + '%)' : '';

      dots.forEach(function (dot, dotIndex) {
        var isActive = dotIndex === activeIndex;
        dot.classList.toggle('is-active', isActive);

        if (isActive) {
          dot.setAttribute('aria-current', 'true');
        } else {
          dot.removeAttribute('aria-current');
        }
      });
    }

    function stopAutoplay() {
      if (autoplayId) {
        clearInterval(autoplayId);
        autoplayId = null;
      }
    }

    function startAutoplay() {
      stopAutoplay();

      if (!isCarouselMode() || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) {
        return;
      }

      autoplayId = setInterval(function () {
        setActiveSlide(activeIndex + 1);
      }, autoplayMs);
    }

    dots.forEach(function (dot) {
      dot.addEventListener('click', function () {
        setActiveSlide(Number(dot.dataset.insightsDot || 0));
        startAutoplay();
      });
    });

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);
    slider.addEventListener('focusin', stopAutoplay);
    slider.addEventListener('focusout', startAutoplay);
    window.addEventListener('resize', function () {
      setActiveSlide(isCarouselMode() ? activeIndex : 0);
      startAutoplay();
    });

    setActiveSlide(0);
    startAutoplay();
  });
})();
</script>

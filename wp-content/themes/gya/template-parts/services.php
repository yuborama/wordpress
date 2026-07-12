<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$services_heading = gya_get_field_value('gya_services_heading', 'La diferencia está en cómo trabajamos.', $page_id);
$upload_dir = wp_upload_dir();
$services_bg = trailingslashit($upload_dir['baseurl']) . '2026/07/network-bg.png';

$services_query = new WP_Query(
    array(
        'post_type' => 'como_ayudamos',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
        'no_found_rows' => true,
    )
);

$services = array();

if ($services_query->have_posts()) {
    while ($services_query->have_posts()) {
        $services_query->the_post();

        $service_id = get_the_ID();
        $title = gya_get_post_field_value('title', $service_id, get_the_title());
        $body = gya_get_post_field_value('short_description', $service_id, '');

        if ($body === '') {
            $body = wp_trim_words(wp_strip_all_tags(gya_get_post_field_value('long_description', $service_id, '')), 22, '...');
        }

        $image = gya_get_post_field_value('image', $service_id, '');
        $image_url = '';

        if (is_array($image) && isset($image['url'])) {
            $image_url = $image['url'];
        } elseif (is_numeric($image)) {
            $image_url = wp_get_attachment_image_url((int) $image, 'large');
        } elseif (is_string($image)) {
            $image_url = $image;
        }

        if (!$image_url && has_post_thumbnail($service_id)) {
            $image_url = get_the_post_thumbnail_url($service_id, 'large');
        }

        $services[] = array(
            'title' => $title,
            'body' => $body,
            'image' => $image_url ? $image_url : '',
            'url' => get_permalink($service_id),
        );
    }

    wp_reset_postdata();
}
?>
<section class="section dark-section" id="servicios" style="background-image:url('<?php echo esc_url($services_bg); ?>');">
    <div class="shell">
        <header class="section-header section-header-light">
            <span>LO QUE NOS DISTINGUE</span>
            <h2><?php echo esc_html($services_heading); ?></h2>
        </header>
        <div class="services-slider js-services-slider" data-services-index="0">
            <div class="services-grid">
                <?php foreach ($services as $service) : ?>
                    <div class="services-slide">
                        <a class="service-card" href="<?php echo esc_url($service['url']); ?>">
                            <div class="card-photo" style="background-image:url('<?php echo esc_url($service['image']); ?>');"></div>
                            <div class="service-copy">
                                <h3><?php echo esc_html($service['title']); ?> <span>&rsaquo;</span></h3>
                                <p><?php echo esc_html($service['body']); ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($services) > 1) : ?>
                <div class="services-dots" aria-label="Páginas de servicios">
                    <?php foreach ($services as $service_index => $_service) : ?>
                        <button
                            class="<?php echo $service_index === 0 ? 'is-active' : ''; ?>"
                            type="button"
                            aria-label="<?php echo esc_attr(sprintf('Ir a servicio %d', $service_index + 1)); ?>"
                            <?php echo $service_index === 0 ? 'aria-current="true"' : ''; ?>
                            data-services-dot="<?php echo esc_attr((string) $service_index); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
(function () {
  var sliders = document.querySelectorAll('.js-services-slider');
  if (!sliders.length) return;

  sliders.forEach(function (slider) {
    var track = slider.querySelector('.services-grid');
    var slides = slider.querySelectorAll('.services-slide');
    var dots = slider.querySelectorAll('[data-services-dot]');
    var activeIndex = 0;
    var autoplayId = null;
    var autoplayMs = Number(slider.dataset.servicesAutoplay || 6000);

    if (!track || slides.length <= 1) return;

    function isCarouselMode() {
      return window.matchMedia && window.matchMedia('(max-width: 900px)').matches;
    }

    function setActiveSlide(index) {
      activeIndex = (index + slides.length) % slides.length;
      slider.dataset.servicesIndex = String(activeIndex);
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
        setActiveSlide(Number(dot.dataset.servicesDot || 0));
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

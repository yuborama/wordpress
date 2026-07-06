<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$solutions_heading = gya_get_field_value('gya_solutions_heading', 'Acompañamos cada área clave de tu empresa.', $page_id);

$solutions_query = new WP_Query(
    array(
        'post_type' => 'gya_category',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => array(
            'menu_order' => 'ASC',
            'date' => 'ASC',
        ),
    )
);

$solutions = array();

while ($solutions_query->have_posts()) {
    $solutions_query->the_post();

    $solution_id = get_the_ID();
    $short_description = gya_get_post_field_value('short_description', $solution_id);
    $long_description = gya_get_post_field_value('long_description', $solution_id);
    $description = $short_description;

    if (empty($description) && !empty($long_description)) {
        $description = wp_trim_words(wp_strip_all_tags($long_description), 24);
    }

    $solutions[] = array(
        'title' => get_the_title(),
        'description' => $description,
    );
}

wp_reset_postdata();

$solution_pages = array_chunk($solutions, 4);
?>
<section class="section light-section" id="soluciones">
    <div class="shell">
        <header class="section-header">
            <span>SOLUCIONES INTEGRALES</span>
            <h2><?php echo esc_html($solutions_heading); ?></h2>
        </header>
        <?php if (!empty($solution_pages)) : ?>
            <div class="solutions-slider js-solutions-slider" data-solutions-index="0">
                <?php if (count($solution_pages) > 1) : ?>
                    <button class="solutions-rail solutions-rail-left" type="button" aria-label="Anterior" data-solutions-prev>&lsaquo;</button>
                <?php endif; ?>

                <div class="solutions-viewport">
                    <div class="solutions-track">
                        <?php foreach ($solution_pages as $page_index => $solution_page) : ?>
                            <div class="solutions-page" data-solutions-page="<?php echo esc_attr((string) $page_index); ?>">
                                <?php foreach ($solution_page as $solution) : ?>
                                    <article class="solution-card">
                                        <span class="solution-icon" aria-hidden="true">
                                            <svg viewBox="0 0 32 32" focusable="false">
                                                <path d="M7 25V11h5v14M14 25V7h5v18M21 25V15h5v10" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                <path d="M5 25h23" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                <circle cx="24" cy="8" r="3" fill="none" stroke="currentColor" stroke-width="2" />
                                            </svg>
                                        </span>
                                        <h3><?php echo esc_html($solution['title']); ?> <span>&rsaquo;</span></h3>
                                        <?php if (!empty($solution['description'])) : ?>
                                            <p><?php echo esc_html($solution['description']); ?></p>
                                        <?php endif; ?>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (count($solution_pages) > 1) : ?>
                    <button class="solutions-rail solutions-rail-right" type="button" aria-label="Siguiente" data-solutions-next>&rsaquo;</button>
                <?php endif; ?>
            </div>

            <?php if (count($solution_pages) > 1) : ?>
                <div class="solutions-dots" aria-label="Páginas de soluciones">
                    <?php foreach ($solution_pages as $page_index => $_solution_page) : ?>
                        <button
                            class="<?php echo $page_index === 0 ? 'is-active' : ''; ?>"
                            type="button"
                            aria-label="<?php echo esc_attr(sprintf('Ir a página %d', $page_index + 1)); ?>"
                            <?php echo $page_index === 0 ? 'aria-current="true"' : ''; ?>
                            data-solutions-dot="<?php echo esc_attr((string) $page_index); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<script>
(function () {
  var sliders = document.querySelectorAll('.js-solutions-slider');
  if (!sliders.length) return;

  sliders.forEach(function (slider) {
    var track = slider.querySelector('.solutions-track');
    var pages = slider.querySelectorAll('[data-solutions-page]');
    var prevButton = slider.querySelector('[data-solutions-prev]');
    var nextButton = slider.querySelector('[data-solutions-next]');
    var dotsContainer = slider.parentNode ? slider.parentNode.querySelector('.solutions-dots') : null;
    var dots = dotsContainer ? dotsContainer.querySelectorAll('[data-solutions-dot]') : [];
    var activeIndex = 0;

    if (!track || pages.length <= 1) return;

    function setActivePage(index) {
      activeIndex = (index + pages.length) % pages.length;
      slider.dataset.solutionsIndex = String(activeIndex);
      track.style.transform = 'translateX(-' + activeIndex * 100 + '%)';

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

    if (prevButton) {
      prevButton.addEventListener('click', function () {
        setActivePage(activeIndex - 1);
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        setActivePage(activeIndex + 1);
      });
    }

    dots.forEach(function (dot) {
      dot.addEventListener('click', function () {
        setActivePage(Number(dot.dataset.solutionsDot || 0));
      });
    });

    setActivePage(0);
  });
})();
</script>

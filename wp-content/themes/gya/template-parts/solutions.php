<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$solutions_heading = gya_get_field_value('gya_solutions_heading', 'Acompañamos cada área clave de tu empresa.', $page_id);

$carousel_autoplay_ms = function_exists('gya_get_duration_ms') ? gya_get_duration_ms('gya_carousel_duration_seconds', 10) : 10000;

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
    $icon = sanitize_file_name((string) gya_get_post_field_value('icon', $solution_id));
    $icon = preg_replace('/\.svg$/i', '', $icon);
    $description = $short_description;

    if (empty($description) && !empty($long_description)) {
        $description = wp_trim_words(wp_strip_all_tags($long_description), 24);
    }

    $solutions[] = array(
        'url' => get_permalink($solution_id),
        'title' => get_the_title(),
        'description' => $description,
        'icon' => $icon,
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
            <div class="solutions-slider js-solutions-slider" data-solutions-index="0" data-solutions-autoplay="<?php echo esc_attr((string) $carousel_autoplay_ms); ?>">
                <?php if (count($solutions) > 1) : ?>
                    <button class="solutions-rail solutions-rail-left" type="button" aria-label="Anterior" data-solutions-prev>
                        <span class="rail-arrow-icon" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>

                <div class="solutions-viewport">
                    <div class="solutions-track">
                        <?php foreach ($solution_pages as $page_index => $solution_page) : ?>
                            <div class="solutions-page" data-solutions-page="<?php echo esc_attr((string) $page_index); ?>">
                                <?php foreach ($solution_page as $solution) : ?>
                                    <a class="solution-card" href="<?php echo esc_url($solution['url']); ?>" data-solutions-card>
                                        <?php if (!empty($solution['icon'])) : ?>
                                            <span class="solution-icon" aria-hidden="true">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/solutions/' . $solution['icon'] . '.svg'); ?>" alt="">
                                            </span>
                                        <?php endif; ?>
                                        <h3><?php echo esc_html($solution['title']); ?> <span>&rsaquo;</span></h3>
                                        <?php if (!empty($solution['description'])) : ?>
                                            <p><?php echo esc_html($solution['description']); ?></p>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (count($solutions) > 1) : ?>
                    <button class="solutions-rail solutions-rail-right" type="button" aria-label="Siguiente" data-solutions-next>
                        <span class="rail-arrow-icon" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>
            </div>

            <?php if (count($solutions) > 1) : ?>
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
    var cards = track ? Array.prototype.slice.call(track.querySelectorAll('[data-solutions-card]')) : [];
    var pages = [];
    var prevButton = slider.querySelector('[data-solutions-prev]');
    var nextButton = slider.querySelector('[data-solutions-next]');
    var dotsContainer = slider.parentNode ? slider.parentNode.querySelector('.solutions-dots') : null;
    var dots = [];
    var activeIndex = 0;
    var cardsPerPage = 4;
    var autoplayMs = Number(slider.dataset.solutionsAutoplay || 10000);
    var autoplayId = null;
    var resizeId = null;

    if (!track || !cards.length) return;

    function getCardsPerPage() {
      if (window.matchMedia && window.matchMedia('(max-width: 560px)').matches) {
        return 1;
      }

      if (window.matchMedia && window.matchMedia('(max-width: 900px)').matches) {
        return 2;
      }

      return 4;
    }

    function updateControls() {
      var hasMultiplePages = pages.length > 1;

      if (prevButton) {
        prevButton.hidden = !hasMultiplePages;
      }

      if (nextButton) {
        nextButton.hidden = !hasMultiplePages;
      }

      if (dotsContainer) {
        dotsContainer.hidden = !hasMultiplePages;
      }
    }

    function bindDots() {
      dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
          setActivePage(Number(dot.dataset.solutionsDot || 0));
          restartAutoplay();
        });
      });
    }

    function buildDots() {
      if (!dotsContainer) return;

      dotsContainer.innerHTML = '';

      pages.forEach(function (_page, pageIndex) {
        var dot = document.createElement('button');
        dot.type = 'button';
        dot.dataset.solutionsDot = String(pageIndex);
        dot.setAttribute('aria-label', 'Ir a pagina ' + (pageIndex + 1));
        dotsContainer.appendChild(dot);
      });

      dots = Array.prototype.slice.call(dotsContainer.querySelectorAll('[data-solutions-dot]'));
      bindDots();
    }

    function buildPages(nextActiveIndex) {
      var previousFirstCardIndex = activeIndex * cardsPerPage;
      cardsPerPage = getCardsPerPage();
      track.innerHTML = '';

      cards.forEach(function (card, cardIndex) {
        if (cardIndex % cardsPerPage === 0) {
          var page = document.createElement('div');
          page.className = 'solutions-page';
          page.dataset.solutionsPage = String(Math.floor(cardIndex / cardsPerPage));
          track.appendChild(page);
        }

        track.lastElementChild.appendChild(card);
      });

      pages = Array.prototype.slice.call(slider.querySelectorAll('[data-solutions-page]'));
      buildDots();
      updateControls();
      setActivePage(typeof nextActiveIndex === 'number' ? nextActiveIndex : Math.floor(previousFirstCardIndex / cardsPerPage));
    }

    function setActivePage(index) {
      if (!pages.length) return;

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

    function stopAutoplay() {
      if (autoplayId) {
        clearInterval(autoplayId);
        autoplayId = null;
      }
    }

    function startAutoplay() {
      stopAutoplay();

      if (pages.length <= 1) {
        return;
      }

      if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
      }

      autoplayId = setInterval(function () {
        setActivePage(activeIndex + 1);
      }, autoplayMs);
    }

    function restartAutoplay() {
      startAutoplay();
    }

    if (prevButton) {
      prevButton.addEventListener('click', function () {
        setActivePage(activeIndex - 1);
        restartAutoplay();
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        setActivePage(activeIndex + 1);
        restartAutoplay();
      });
    }

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);
    slider.addEventListener('focusin', stopAutoplay);
    slider.addEventListener('focusout', startAutoplay);
    window.addEventListener('resize', function () {
      clearTimeout(resizeId);
      resizeId = setTimeout(function () {
        var nextCardsPerPage = getCardsPerPage();

        if (nextCardsPerPage !== cardsPerPage) {
          buildPages();
          restartAutoplay();
        }
      }, 150);
    });

    buildPages(0);
    startAutoplay();
  });
})();
</script>

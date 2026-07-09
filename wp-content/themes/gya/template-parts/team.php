<?php

if (!defined('ABSPATH')) {
    exit;
}

$page_id = isset($args['page_id']) ? (int) $args['page_id'] : get_queried_object_id();
$team_heading = gya_get_field_value('gya_team_heading', 'Profesionales que entienden tu negocio y hablan tu idioma.', $page_id);

$team_query = new WP_Query(
    array(
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
        'no_found_rows' => true,
    )
);

$team = array();

if ($team_query->have_posts()) {
    while ($team_query->have_posts()) {
        $team_query->the_post();

        $member_id = get_the_ID();
        $name = gya_get_post_field_value('name', $member_id, get_the_title());
        $position = gya_get_post_field_value('position', $member_id, '');
        $order = gya_get_post_field_value('order', $member_id, '');
        $image = gya_get_post_field_value('image', $member_id, '');
        $image_url = '';

        if (is_array($image) && isset($image['url'])) {
            $image_url = $image['url'];
        } elseif (is_numeric($image)) {
            $image_url = wp_get_attachment_image_url((int) $image, 'medium');
        } elseif (is_string($image)) {
            $image_url = $image;
        }

        if (!$image_url && has_post_thumbnail($member_id)) {
            $image_url = get_the_post_thumbnail_url($member_id, 'medium');
        }

        $name_parts = preg_split('/\s+/', trim($name));
        $initials = '';

        if (!empty($name_parts[0])) {
            $initials .= function_exists('mb_substr') ? mb_substr($name_parts[0], 0, 1) : substr($name_parts[0], 0, 1);
        }

        if (!empty($name_parts[1])) {
            $initials .= function_exists('mb_substr') ? mb_substr($name_parts[1], 0, 1) : substr($name_parts[1], 0, 1);
        }

        $team[] = array(
            'name' => $name,
            'position' => $position,
            'image' => $image_url ? $image_url : '',
            'initials' => $initials,
            'order' => is_numeric($order) ? (int) $order : PHP_INT_MAX,
            'date' => get_the_date('U'),
        );
    }

    wp_reset_postdata();
}

usort(
    $team,
    function ($a, $b) {
        if ($a['order'] === $b['order']) {
            return $a['date'] <=> $b['date'];
        }

        return $a['order'] <=> $b['order'];
    }
);

$team_pages = array_chunk($team, 4);
?>
<section class="section light-section" id="equipo">
    <div class="shell">
        <header class="section-header">
            <span>NUESTRO EQUIPO</span>
            <h2><?php echo esc_html($team_heading); ?></h2>
        </header>
        <?php if (!empty($team_pages)) : ?>
            <div class="team-slider js-team-slider" data-team-index="0">
                <?php if (count($team_pages) > 1) : ?>
                    <button class="team-rail team-rail-left" type="button" aria-label="Anterior" data-team-prev>
                        <span class="rail-arrow-icon" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>

                <div class="team-viewport">
                    <div class="team-track">
                        <?php foreach ($team_pages as $page_index => $team_page) : ?>
                            <div class="team-page" data-team-page="<?php echo esc_attr((string) $page_index); ?>">
                                <?php foreach ($team_page as $member) : ?>
                                    <article class="team-card">
                                        <div class="avatar">
                                            <?php if (!empty($member['image'])) : ?>
                                                <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>">
                                            <?php else : ?>
                                                <span><?php echo esc_html($member['initials']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <h3><?php echo esc_html($member['name']); ?></h3>
                                        <?php if (!empty($member['position'])) : ?>
                                            <p><?php echo esc_html($member['position']); ?></p>
                                        <?php endif; ?>
                                        <div class="contact-icons" aria-hidden="true">
                                            <span class="icon icon-mail">
                                                <svg viewBox="0 0 24 24" focusable="false">
                                                    <path d="M4 6h16v12H4z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                    <path d="m4 7 8 6 8-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <span class="icon icon-phone">
                                                <svg viewBox="0 0 24 24" focusable="false">
                                                    <path d="M7 4h3l1.5 4-2 1.2c1 2 2.3 3.3 4.3 4.3l1.2-2 4 1.5v3c0 1.1-.9 2-2 2C10.4 19 5 13.6 5 7c0-1.1.9-2 2-2z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if (count($team_pages) > 1) : ?>
                    <button class="team-rail team-rail-right" type="button" aria-label="Siguiente" data-team-next>
                        <span class="rail-arrow-icon" aria-hidden="true"></span>
                    </button>
                <?php endif; ?>
            </div>

            <?php if (count($team_pages) > 1) : ?>
                <div class="team-dots" aria-label="P&aacute;ginas de equipo">
                    <?php foreach ($team_pages as $page_index => $_team_page) : ?>
                        <button
                            class="<?php echo $page_index === 0 ? 'is-active' : ''; ?>"
                            type="button"
                            aria-label="<?php echo esc_attr(sprintf('Ir a pagina %d', $page_index + 1)); ?>"
                            <?php echo $page_index === 0 ? 'aria-current="true"' : ''; ?>
                            data-team-dot="<?php echo esc_attr((string) $page_index); ?>"></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <a class="primary-button team-cta" href="<?php echo esc_url(home_url('/team/')); ?>">Explora nuestro equipo y experiencia</a>
    </div>
</section>

<script>
(function () {
  var sliders = document.querySelectorAll('.js-team-slider');
  if (!sliders.length) return;

  sliders.forEach(function (slider) {
    var track = slider.querySelector('.team-track');
    var pages = slider.querySelectorAll('[data-team-page]');
    var prevButton = slider.querySelector('[data-team-prev]');
    var nextButton = slider.querySelector('[data-team-next]');
    var dotsContainer = slider.parentNode ? slider.parentNode.querySelector('.team-dots') : null;
    var dots = dotsContainer ? dotsContainer.querySelectorAll('[data-team-dot]') : [];
    var activeIndex = 0;

    if (!track || pages.length <= 1) return;

    function setActivePage(index) {
      activeIndex = (index + pages.length) % pages.length;
      slider.dataset.teamIndex = String(activeIndex);
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
        setActivePage(Number(dot.dataset.teamDot || 0));
      });
    });

    setActivePage(0);
  });
})();
</script>

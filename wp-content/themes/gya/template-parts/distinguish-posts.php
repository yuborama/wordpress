<?php
if (!defined('ABSPATH')) {
    exit;
}
$services = isset($args['services']) ? $args['services'] : array();
$section_id = isset($args['section_id']) ? $args['section_id'] : 'lo-que-nos-distingue';
$heading = isset($args['heading']) ? $args['heading'] : 'LO QUE NOS DISTINGUE';
$track_id = $section_id . '-track';
$title_id = $section_id . '-title';
?>
<section class="gya-posts" id="<?php echo esc_attr($section_id); ?>" aria-labelledby="<?php echo esc_attr($title_id); ?>">
    <div class="gya-design-shell">
        <h2 id="<?php echo esc_attr($title_id); ?>"><?php echo esc_html($heading); ?></h2>
        <?php if ($services) : ?>
            <div class="gya-posts__carousel">
                <button class="gya-posts__prev" type="button" aria-label="Artículos anteriores" aria-controls="<?php echo esc_attr($track_id); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/arrow.svg'); ?>" alt=""></button>
                <div class="gya-posts__track" id="<?php echo esc_attr($track_id); ?>" tabindex="0" aria-label="<?php echo esc_attr($heading); ?>">
                    <?php foreach ($services as $service) : ?>
                        <article class="gya-posts__card">
                            <a href="<?php echo esc_url($service['url']); ?>">
                                <?php if ($service['image']) : ?>
                                    <img src="<?php echo esc_url($service['image']); ?>" alt="" loading="lazy">
                                <?php endif; ?>
                                <div class="gya-posts__copy">
                                    <?php if (!empty($service['tag'])) : ?>
                                        <span class="gya-posts__tag"><?php echo esc_html($service['tag']); ?></span>
                                    <?php endif; ?>
                                    <h3><?php echo esc_html($service['title']); ?></h3>
                                    <p><?php echo esc_html(wp_strip_all_tags($service['body'])); ?></p>
                                    <?php if (!empty($service['author'])) : ?>
                                        <div class="gya-posts__author">
                                            <?php if (!empty($service['author_image'])) : ?>
                                                <img src="<?php echo esc_url($service['author_image']); ?>" alt="" loading="lazy">
                                            <?php endif; ?>
                                            <small><?php echo esc_html($service['author']); ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
                <button class="gya-posts__next" type="button" aria-label="Artículos siguientes" aria-controls="<?php echo esc_attr($track_id); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/arrow.svg'); ?>" alt=""></button>
            </div>
        <?php else : ?>
            <p>Próximamente publicaremos nuevos artículos.</p>
        <?php endif; ?>
    </div>
</section>
<script>
(function () {
    var track = document.getElementById(<?php echo wp_json_encode($track_id); ?>);
    if (!track) return;
    var previous = track.parentElement.querySelector('.gya-posts__prev');
    var next = track.parentElement.querySelector('.gya-posts__next');
    function update() {
        previous.disabled = track.scrollLeft <= 1;
        next.disabled = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;
    }
    function move(direction) {
        var card = track.querySelector('article');
        var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
        track.scrollBy({left: direction * (card.getBoundingClientRect().width + gap), behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'});
    }
    previous.addEventListener('click', function () { move(-1); });
    next.addEventListener('click', function () { move(1); });
    track.addEventListener('scroll', update);
    window.addEventListener('resize', update);
    update();
})();
</script>

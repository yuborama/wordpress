<?php

if (!defined('ABSPATH')) {
    exit;
}

$relations = wp_parse_args(
    isset($args) && is_array($args) ? $args : array(),
    array(
        'section_class' => 'gya-relations gya-grid-bg',
        'section_id' => '',
        'inner_class' => 'gya-design-shell gya-relations__grid',
        'copy_class' => 'gya-relations__copy',
        'title_id' => 'relations-title',
        'cta_url' => home_url('/weare/'),
    )
);

$relations_image_id = absint(get_option('gya_relations_image_id', 0));
$relations_image = $relations_image_id ? wp_get_attachment_image_url($relations_image_id, 'full') : '';

if (!$relations_image) {
    $upload_dir = wp_upload_dir();
    $relations_image = trailingslashit($upload_dir['baseurl']) . '2026/07/office.jpg';
}
?>
<section class="<?php echo esc_attr($relations['section_class']); ?>"<?php echo $relations['section_id'] !== '' ? ' id="' . esc_attr($relations['section_id']) . '"' : ''; ?> aria-labelledby="<?php echo esc_attr($relations['title_id']); ?>">
    <div class="<?php echo esc_attr($relations['inner_class']); ?>">
        <div<?php echo $relations['copy_class'] !== '' ? ' class="' . esc_attr($relations['copy_class']) . '"' : ''; ?>>
            <h2 id="<?php echo esc_attr($relations['title_id']); ?>">Más que servicios, construimos relaciones.</h2>
            <p>G&amp;A es una firma boutique que acompaña a empresas con claridad, experiencia y atención personalizada.</p>
            <a class="gya-orange-button" href="<?php echo esc_url($relations['cta_url']); ?>">CONÓCENOS <span aria-hidden="true">→</span></a>
        </div>
        <img src="<?php echo esc_url($relations_image); ?>" alt="Equipo de consultoría G&amp;A" loading="lazy">
    </div>
</section>

<?php
if (!defined('ABSPATH')) {
    exit;
}
$platforms = gya_platform_links();
$logo = file_get_contents(get_template_directory() . '/assets/images/icons/logo.svg');
$logo = str_replace('fill="white"', 'fill="#062236"', $logo);
get_header();
?>
<main class="gya-access">
    <section class="gya-access__card" aria-labelledby="access-title">
        <div class="gya-access__logo" role="img" aria-label="G&amp;A"><?php echo $logo; // Trusted local SVG. ?></div>
        <h1 id="access-title">BIENVENIDO</h1>
        <a class="gya-access__button" href="<?php echo esc_url($platforms['courses']); ?>" target="_blank" rel="noopener noreferrer">CURSOS</a>
        <a class="gya-access__button gya-access__button--orange" href="<?php echo esc_url($platforms['monday']); ?>" target="_blank" rel="noopener noreferrer">MONDAY</a>
    </section>
</main>
<?php get_footer(); ?>

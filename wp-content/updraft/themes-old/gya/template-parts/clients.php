<?php
if (!defined('ABSPATH')) {
    exit;
}

$client_logos = array(
    'Pfizer' => 'pfizer_Logo.svg',
    'DSV' => 'dvs_Logo.svg',
    'Maersk' => 'maersk_Logo.svg',
    'Crane Worldwide Logistics' => 'crane_Logo.svg',
    'Senator International' => 'senator_Logo.svg',
    'AIT Home Delivery' => 'ait_Logo.svg',
    'Fracht Group' => 'fracht_Logo.svg',
    'ViX' => 'vix_Logo.svg',
);
$clients_class = isset($args['section_class']) ? $args['section_class'] : 'gya-clients gya-grid-bg';
?>
<section class="<?php echo esc_attr($clients_class); ?>" aria-labelledby="clients-title">
    <div class="gya-design-shell">
        <h2 id="clients-title">Nuestros clientes</h2>
        <div class="gya-clients__logos">
            <?php foreach ($client_logos as $client_name => $client_logo) : ?>
                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/sponsor/' . $client_logo); ?>" alt="<?php echo esc_attr($client_name); ?>" loading="lazy">
            <?php endforeach; ?>
        </div>
    </div>
</section>

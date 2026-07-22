<?php

if (!defined('ABSPATH')) {
    exit;
}

$sections = array(
    array(
        'title' => '¿Qué son las cookies?',
        'content' => array(
            'Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita nuestro sitio web. Su finalidad es mejorar la experiencia de navegación, recordar sus preferencias, analizar el funcionamiento del sitio y, en algunos casos, personalizar el contenido mostrado.',
            'Las cookies no dañan su dispositivo ni permiten acceder a información distinta de aquella autorizada por el usuario o generada durante su navegación.',
        ),
    ),
    array(
        'title' => '¿Qué tipos de cookies utilizamos?',
        'content' => array(
            'A continuación se describen los tipos de cookies que pueden utilizarse en nuestro sitio web.',
        ),
    ),
    array(
        'title' => 'Cookies estrictamente necesarias',
        'content' => array(
            'Son indispensables para el funcionamiento del sitio web y permiten funciones básicas como la navegación, la seguridad y el acceso a determinadas secciones. Estas cookies no pueden deshabilitarse, ya que sin ellas el sitio no funcionaría correctamente.',
        ),
    ),
    array(
        'title' => 'Cookies de rendimiento y análisis',
        'content' => array(
            'Nos permiten conocer de forma estadística cómo interactúan los visitantes con nuestro sitio web, identificando las páginas más consultadas, el tiempo de navegación y otros indicadores que nos ayudan a mejorar continuamente nuestros servicios digitales.',
            'La información recopilada mediante estas cookies es agregada y no busca identificar personalmente a los usuarios.',
        ),
    ),
    array(
        'title' => 'Cookies de funcionalidad',
        'content' => array(
            'Permiten recordar las preferencias seleccionadas por el usuario, como el idioma, la región o determinadas configuraciones de navegación, con el objetivo de ofrecer una experiencia más personalizada.',
        ),
    ),
    array(
        'title' => 'Cookies de terceros',
        'content' => array(
            'Algunas funcionalidades del sitio pueden ser proporcionadas por terceros, como servicios de análisis, mapas, reproducción de video o redes sociales. Estos proveedores pueden instalar sus propias cookies conforme a sus respectivas políticas de privacidad.',
        ),
    ),
    array(
        'title' => '¿Cómo puede administrar las cookies?',
        'content' => array(
            'Al ingresar por primera vez a nuestro sitio web, podrá aceptar, rechazar o configurar el uso de las cookies que no sean estrictamente necesarias.',
            'En cualquier momento podrá modificar sus preferencias mediante el enlace "Configuración de Cookies", disponible en el pie de página del sitio.',
            'Asimismo, la mayoría de los navegadores permiten eliminar o bloquear cookies desde su configuración. Tenga en cuenta que deshabilitar determinadas cookies puede afectar algunas funcionalidades del sitio web.',
        ),
    ),
    array(
        'title' => 'Actualizaciones de esta política',
        'content' => array(
            'G&A podrá modificar la presente Política de Cookies cuando resulte necesario para reflejar cambios en la legislación aplicable, en los servicios ofrecidos o en las tecnologías utilizadas por el sitio web.',
            'La versión vigente será publicada en esta misma sección, indicando la fecha de su última actualización.',
        ),
    ),
    array(
        'title' => 'Contacto',
        'content' => array(
            'Si tiene preguntas sobre el uso de cookies o sobre el tratamiento de sus datos personales, puede ponerse en contacto con nosotros a través de los medios de contacto publicados en este sitio web o consultar nuestro Aviso de Privacidad.',
        ),
    ),
);

get_header();
?>
<main class="privacy-page">
    <section class="privacy-hero">
        <div class="shell privacy-hero__inner">
            <span>LEGAL</span>
            <h1>Política de cookies</h1>
            <p>Información sobre el uso de cookies, preferencias de navegación y tecnologías utilizadas en el sitio.</p>
        </div>
    </section>

    <section class="privacy-content">
        <div class="shell privacy-layout privacy-layout--single">
            <article class="privacy-article">
                <?php foreach ($sections as $section) : ?>
                    <section class="privacy-block">
                        <h2><?php echo esc_html($section['title']); ?></h2>

                        <?php foreach ($section['content'] as $paragraph) : ?>
                            <p><?php echo esc_html($paragraph); ?></p>
                        <?php endforeach; ?>
                    </section>
                <?php endforeach; ?>
            </article>
        </div>
    </section>
</main>
<?php
get_footer();

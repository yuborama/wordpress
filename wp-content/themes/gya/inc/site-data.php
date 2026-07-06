<?php

if (!defined('ABSPATH')) {
    exit;
}

function gya_asset_uri($path) {
    return trailingslashit(get_template_directory_uri()) . ltrim($path, '/');
}

function gya_get_landing_data() {
    return array(
        'nav_items' => array('Soluciones', 'Insights', 'Cómo ayudamos', 'Nosotros'),
        'hero_slides' => array(
            array(
                'eyebrow' => 'CONTACTO',
                'title' => 'Claridad estratégica',
                'strong' => 'para empresas en crecimiento.',
                'body' => 'Ayudamos a empresas a resolver retos fiscales, legales y financieros mediante soluciones claras, ágiles y personalizadas.',
                'cta' => 'Diagnóstico estratégico',
                'href' => '#contacto',
                'image' => gya_asset_uri('assets/images/office.jpg'),
            ),
            array(
                'eyebrow' => 'INSIGHTS',
                'title' => 'Información que genera',
                'strong' => 'mejores decisiones.',
                'body' => 'Accede a infografías, cursos y contenido especializado elaborado por nuestros expertos para mantenerte actualizado en temas fiscales, legales y financieros.',
                'cta' => 'Explorar insights',
                'href' => '#insights',
                'image' => gya_asset_uri('assets/images/office2.jpg'),
            ),
            array(
                'eyebrow' => 'NOSOTROS',
                'title' => 'Visibilidad y control',
                'strong' => 'de tus procesos.',
                'body' => 'Conoce cómo damos seguimiento a proyectos, requerimientos y tareas mediante herramientas de control que mejoran la comunicación y la ejecución.',
                'cta' => 'Conocer nuestra metodología',
                'href' => '#nosotros',
                'image' => gya_asset_uri('assets/images/office3.png'),
            ),
        ),
        'stats' => array(
            array('value' => '+ 15', 'label' => 'años de experiencia'),
            array('value' => '+140', 'label' => 'soluciones especializadas'),
            array('value' => '+7', 'label' => 'áreas de especialización'),
            array('value' => '+40', 'label' => 'especialistas y consultores'),
        ),
        'solutions' => array(
            array('title' => 'Fiscal y Financiero', 'body' => 'Estrategias fiscales, cumplimiento y optimización financiera para operar con mayor claridad y seguridad.'),
            array('title' => 'Auditoría', 'body' => 'Auditoría financiera, fiscal y operativa con enfoque en transparencia, control y reducción de riesgos.'),
            array('title' => 'Legal Corporativo', 'body' => 'Asesoría legal estratégica para acompañar el crecimiento y operación de tu empresa.'),
            array('title' => 'Expansión Internacional', 'body' => 'Acompañamiento estratégico para empresas extranjeras con operación o expansión en México.'),
        ),
        'services' => array(
            array(
                'title' => 'Recuperación de saldos a favor',
                'body' => 'Convertimos saldos a favor de IVA e ISR en liquidez para fortalecer la operación de tu empresa.',
                'image' => gya_asset_uri('assets/images/cardservice1.jpg'),
            ),
            array(
                'title' => 'Levantamiento de sellos digitales',
                'body' => 'Te ayudamos a recuperar la continuidad operativa de tu empresa mediante la reactivación de sellos digitales.',
                'image' => gya_asset_uri('assets/images/cardservice2.jpg'),
            ),
            array(
                'title' => 'Supervisión fiscal',
                'body' => 'Revisamos y fortalecemos el cumplimiento fiscal de tu empresa para reducir riesgos y brindar mayor seguridad operativa.',
                'image' => gya_asset_uri('assets/images/cardservice3.jpg'),
            ),
        ),
        'insights' => array(
            array(
                'tag' => 'AUDITORÍA',
                'title' => 'Cumplimiento y presentación ISSIF',
                'body' => 'Aspectos clave, validaciones y recomendaciones para cumplir correctamente con la presentación del ISSIF.',
                'author' => 'Lic. José Luis Gómez',
                'image' => gya_asset_uri('assets/images/insightsCard1.jpg'),
            ),
            array(
                'tag' => 'LEGAL CORPORATIVO',
                'title' => 'Obligaciones y avisos ante el RNIE',
                'body' => 'Conoce las principales actualizaciones y obligaciones relacionadas con el Registro Nacional de Inversiones Extranjeras.',
                'author' => 'Lic. Karla Jessica Salazar',
                'image' => gya_asset_uri('assets/images/insightsCard2.jpg'),
            ),
            array(
                'tag' => 'FISCAL Y FINANCIERO',
                'title' => 'Atender cartas invitación del SAT',
                'body' => 'Identifica riesgos, requerimientos frecuentes y recomendaciones para atender correctamente comunicaciones del SAT.',
                'author' => 'Lic. Salvador Vargas',
                'image' => gya_asset_uri('assets/images/insightsCard3.jpg'),
            ),
        ),
        'team' => array(
            array('name' => 'José Luis Gómez González', 'role' => 'Socio Director'),
            array('name' => 'Karla Jessica Salazar', 'role' => 'Gerente Jurídico'),
            array('name' => 'Frida Hernández Artiaga', 'role' => 'Gerente de Impuesto I'),
            array('name' => 'Salvador Vargas', 'role' => 'Gerente de Impuesto II'),
        ),
    );
}

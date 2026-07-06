# GYA Theme

Tema personalizado para migrar la landing de React a WordPress.

## Estructura

- `front-page.php`: portada principal (landing).
- `template-parts/`: secciones de la landing.
- `assets/css/main.css`: estilos globales.
- `assets/js/main.js`: interaccion de hero slider.
- `inc/site-data.php`: contenido fallback por defecto.
- `inc/acf-fields.php`: registro automatico de campos ACF para portada.
- `inc/seed-front-page.php`: llenado inicial automatico de campos ACF (solo una vez).

## Activacion

1. Ir a Apariencia > Temas.
2. Activar **GYA Theme**.
3. Ir a Ajustes > Lectura y definir portada estatica.

## Menus

- Crear y asignar menu a la ubicacion **Menu principal**.
- Crear y asignar menu a la ubicacion **Menu de footer**.

Si no hay menus asignados, el tema usa enlaces fallback.

## ACF (opcional pero recomendado)

1. Instalar y activar plugin **Advanced Custom Fields**.
2. Editar la pagina configurada como portada.
3. Veras el grupo **GYA Landing Content** para editar:
   - Hero (titulo, texto, CTA, imagen)
   - Metricas
   - Soluciones
   - Servicios
   - Insights
   - CTA
   - Equipo
   - Header y Footer

Si ACF no esta activo, el tema usa contenido por defecto de `inc/site-data.php`.

## Seed inicial de campos

- Al entrar al admin con ACF activo y con portada definida, el tema precarga los textos base en los campos vacios de esa portada.
- Este proceso corre una sola vez y guarda un flag interno (`gya_front_page_seeded`).

## Header y Footer editables

- Header:
   - `gya_header_cta_text`
   - `gya_header_cta_url`
- Footer:
   - `gya_footer_legal_1_text` / `gya_footer_legal_1_url`
   - `gya_footer_legal_2_text` / `gya_footer_legal_2_url`
   - `gya_footer_legal_3_text` / `gya_footer_legal_3_url`
   - `gya_footer_text_1`
   - `gya_footer_text_2`
   - `gya_footer_copyright`

## Imagenes

Coloca tus imagenes en `assets/images/` con estos nombres para igualar el diseño base:

- `office.jpg`
- `office2.jpg`
- `office3.png`
- `network-bg.png`
- `cardservice1.jpg`
- `cardservice2.jpg`
- `cardservice3.jpg`
- `insightsCard1.jpg`
- `insightsCard2.jpg`
- `insightsCard3.jpg`
- `insightsCardTeam.jpg`
- `insightsBanner.jpg`

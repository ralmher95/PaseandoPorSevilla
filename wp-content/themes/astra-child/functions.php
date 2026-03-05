<?php
if (!defined('ABSPATH')) exit;

// 1. CARGA DE ESTILOS BASE
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri(), array('parent-style'), time());
}, 10);

// 2. INYECCIÓN DIRECTA DE CSS (ESTO NO FALLA)
add_action('wp_head', function() {
    // Detectamos si la URL contiene "catas" o "cata"
    $url = $_SERVER['REQUEST_URI'];
    if ( strpos($url, '/catas/') !== false || strpos($url, '/cata/') !== false ) {
        ?>
        <style id="diseno-cata-directo">
            :root {
                --beige-claro: #f5efe6; --beige-medio: #e8dfd1;
                --marron-oscuro: #5a4636; --marron-medio: #7a5c47;
                --azul-ceramica: #3f6c7a; --azul-ceramica-hover: #2e5562; --blanco: #ffffff;
            }
            body { background-color: var(--beige-claro) !important; color: var(--marron-oscuro) !important; font-family: 'Georgia', serif; }
            .cata-header { background-color: var(--beige-medio); padding: 60px 0; text-align: center; }
            .cata-title { font-size: 2.5rem; color: var(--marron-oscuro); }
            .cata-price { display: inline-block; background-color: var(--blanco); padding: 15px 25px; border-radius: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
            .price-amount { font-size: 1.8rem; font-weight: bold; color: var(--azul-ceramica); }
            .detail-item { background-color: var(--blanco); padding: 20px; border-left: 5px solid var(--azul-ceramica); margin: 20px 0; border-radius: 8px; }
            .btn-reservar { background-color: var(--azul-ceramica); color: white !important; padding: 15px 30px; border-radius: 50px; text-decoration: none; display: inline-block; font-weight: bold; }
        </style>
        <?php
    }
}, 100);

// 3. FUNCIÓN PARA LISTAS
function format_cata_list($field) {
    if (empty($field)) return '';
    $output = '<ul class="cata-list" style="list-style:none; padding:0;">';
    $items = is_array($field) ? $field : explode("\n", str_replace("\r", "", $field));
    foreach ($items as $item) {
        if (trim($item)) $output .= '<li style="margin-bottom:10px; border-bottom:1px solid #e8dfd1;">• ' . esc_html(trim($item)) . '</li>';
    }
    $output .= '</ul>';
    return $output;
}

add_action('wp_enqueue_scripts', function() {
    // Si el archivo está en la RAIZ del tema hijo:
    if ( is_singular('paseo') ) {
        wp_enqueue_style(
            'ps-premium-style', 
            get_stylesheet_directory_uri() . '/paseo.css', // Ruta sin "assets/css/"
            array(), 
            time() 
        );
    }
}, 20);

if (is_post_type_archive('paseo')) {
        wp_enqueue_style(
            'ps-paseos-archive-style',
            get_stylesheet_directory_uri() . '/assets/css/paseos-archive.css',
            array(),
            '1.0'
        );
    }

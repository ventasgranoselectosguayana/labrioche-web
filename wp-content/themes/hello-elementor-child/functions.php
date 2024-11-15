<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'hello-elementor','hello-elementor','hello-elementor-theme-style','hello-elementor-header-footer' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 100 );

// Incluir Bootstrap CSS y JS desde CDN
function enqueue_bootstrap() {
    // Incluir Bootstrap CSS
    wp_enqueue_style(
        'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3'
    );

    // Incluir Bootstrap JS
    wp_enqueue_script(
        'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.3',
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

// END ENQUEUE PARENT ACTION
function removeKeywordsFromProductName($product) {
    $productName = $product->get_name();
    $keywordsToRemove = [
        'Nescafé® - ', 'Cachito - ','Saladito - ', 'Combo: 2 ', ' (unidad)','Croissant - ',
        'Café - Americano, ','Café - Con leche, ','Café - Marrón, ','Frappuccino - ',
        'Té - ','Cócteles - ', 'Frappé - ','Cerveza - Nacional, ','Refresco - Pepsi, ',
    ];
    $replacementString = ''; // o cualquier otra cadena de reemplazo deseada

    $newName = array_reduce($keywordsToRemove, function ($productName, $keyword) use ($replacementString) {
        return str_replace($keyword, $replacementString, $productName);
    }, $productName);

    return $newName;
}

function mostrar_precio_producto($atts) {
    $product_id = $atts['id']; // Obtiene el ID del producto del atributo "id"
    $product = wc_get_product($product_id);
    $productName = removeKeywordsFromProductName($product);

    if ($product instanceof WC_Product_Variable) {
        $variations = $product->get_available_variations();
        $min_price = null;
        $max_price = null;
        foreach ($variations as $variation) {
            $variation_id = $variation['variation_id'];
            $variation_product = wc_get_product($variation_id);
            $price = $variation_product->get_price();
            if ($min_price === null || $price < $min_price) {
                $min_price = $price;
            }
            if ($max_price === null || $price > $max_price) {
                $max_price = $price;
            }
        }
        if ($min_price !== null && $max_price !== null) {
            $beforePriceOne = ' ';
            $afterPriceOne = '"> - ';
            if(stripos($productName,'Pizza') !== false ){
                $beforePriceOne = ' <span class="pizza-size">P</span>';
                $afterPriceOne = '"> - <span class="pizza-size">G </span>';
            }else if(stripos($productName,'Refresco') !== false ){
                $beforePriceOne = ' <span class="ref-lt">1.5 LT</span>';
                $afterPriceOne = '"> <span class="ref-lt">| 2 LT </span>';
            }
            return '<div class="producto-nombre-precio gnp pnp' . $product_id . '"><span class="producto-nombre gn pn' . $product_id . '">' . $productName . $beforePriceOne . '</span><span class="producto-precio gp pp' . $product_id . '"><span class="formato-bs">$</span>' . $min_price . '<span class="sec-p'. $product_id . $afterPriceOne .'<span class="formato-bs">$</span>' . $max_price . '</span></span></span></div>';
            
        } else {
            return '<div class="producto-nombre-precio gnp pnp' . $product_id . '"><span class="producto-nombre gn pn' . $product_id . '">' . $productName . ' Sin precio</span></div>';
        }
    } elseif ($product instanceof WC_Product) {
        $beforeName = '">';
        if(stripos($productName,'s + 1 Malta') !== false ){
            $beforeName = '">2 ';
        }
        $price = $product->get_price();
        return '<div class="producto-nombre-precio gnp pnp' . $product_id . '"><span class="producto-nombre gn pn' . $product_id . $beforeName . $productName . '</span><span class="producto-precio gp pp' . $product_id . '"> <span class="formato-bs">$</span>' . $price . '</span></span></div>';
    } else {
        return '<div class="producto-nombre-precio gnp pnp' . $product_id . '"><span class="producto-nombre gn pn' . $product_id . '">No se encontró el producto con el ID ' . $product_id . '</span></div>';
    }
}
add_shortcode('precio_producto', 'mostrar_precio_producto');


function extras_shortcode() {
    global $wpdb;
  
    // Obtiene la tabla de opciones de productos
    $table_name = $wpdb->prefix . 'yith_wapo_addons';
  
    // Obtiene la fila de la tabla
    $row = $wpdb->get_row("SELECT * FROM $table_name");
  
    // Verifica si la fila es null
    if ($row === null) {
      return 'No se encontraron resultados';
    }
  
    // Obtiene los datos de la fila
    $settings = unserialize($row->settings);
    $options = unserialize($row->options);
  
    // Crea el HTML para mostrar los datos
    $output = '';
    foreach ($options['label'] as $key => $label) {
      $output .= '<div class="extra-nombre-precio gnp enp' . $key . '">';
      $output .= '<span class="extra-nombre gn en' . $key . '">' . $label . '</span>';
      $output .= '<span class="extra-precio gp ep' . $key . '"> <span class="formato-bs">$</span>' . $options['price'][$key] . '</span>';
      $output .= '</div>';
    }
  
    return $output;
  }
  
  add_shortcode('extras', 'extras_shortcode');
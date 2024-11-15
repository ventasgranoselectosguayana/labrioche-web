<?php
/*
Plugin Name: Multiplicador de Precios de Extras
Description: Este plugin permite multiplicar los precios de los extras en la tabla `yith_wapo_addons` por una tasa configurable.
Version: 1.0
Author: Carlos Peláez
Author URI: https://66f9d975d1a1c3788b161a9e--portfoliopelaez.netlify.app/
*/

function cambiar_precios_extras_yith() {
  global $wpdb;

  // Obtiene la tabla de opciones de productos
  $table_name = $wpdb->prefix . 'yith_wapo_addons';

  // Obtiene la fila de la tabla
  $row = $wpdb->get_row("SELECT * FROM $table_name");

  // Verifica si la fila es null
  if ($row === null) {
    return;
  }

  // Obtiene los datos de la fila
  $settings = unserialize($row->settings);
  $options = unserialize($row->options);

  // Obtiene la tasa de multiplicación desde la configuración del plugin
  $tasa_multiplicacion = get_option('tasa_multiplicacion_extras');

  // Actualiza los precios de los extras
  foreach ($options['price'] as $key => $precio) {
    $nuevo_precio = $precio * $tasa_multiplicacion;
    $options['price'][$key] = $nuevo_precio;
  }

  // Guarda los nuevos precios de los extras
  $wpdb->update($table_name, array('options' => serialize($options)), array('id' => $row->id));
}

// Agrega una página de configuración para el plugin
function agregar_pagina_configuracion() {
  add_options_page('Configuración del plugin', 'Configuración del plugin', 'manage_options', 'configuracion-plugin', 'mostrar_pagina_configuracion');
}

add_action('admin_menu', 'agregar_pagina_configuracion');

// Muestra la página de configuración
function mostrar_pagina_configuracion() {
  ?>
  <div class="wrap">
    <h1>Configuración del plugin</h1>
    <form method="post" action="options.php">
      <?php settings_fields('configuracion-plugin'); ?>
      <table class="form-table">
        <tr>
          <th scope="row">Tasa de multiplicación para los precios de los extras</th>
          <td><input type="number" name="tasa_multiplicacion_extras" value="<?php echo get_option('tasa_multiplicacion_extras'); ?>"></td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

// Registra la configuración del plugin
function registrar_configuracion() {
  register_setting('configuracion-plugin', 'tasa_multiplicacion_extras');
}

add_action('admin_init', 'registrar_configuracion');

// Llama a la función para cambiar los precios de los extras
cambiar_precios_extras_yith();
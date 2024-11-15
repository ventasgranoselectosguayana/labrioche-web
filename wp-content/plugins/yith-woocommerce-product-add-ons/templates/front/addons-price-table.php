<?php
/**
 * WAPO Template
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\ProductAddOns
 * @version 4.0.0
 *
 * @var WC_Product $product
 * @var WC_Product_Variation $variation
 * @var string $total_price_box
 * @var float $blocks_product_price
 * @var string $currency
 */
$suffix          = '';
$suffix_callback = '';

// translators: [FRONT] Add-ons table shown on the product page
$product_price_label = apply_filters( 'yith_wapo_table_product_price_label', __( 'Product price', 'yith-woocommerce-product-add-ons' ) );
// translators: [FRONT] Add-ons table shown on the product page
$total_options_label = apply_filters( 'yith_wapo_table_total_options_label', __( 'Total options', 'yith-woocommerce-product-add-ons' ) );
// translators: [FRONT] Add-ons table shown on the product page
$order_total_label   = apply_filters( 'yith_wapo_table_order_total_label', __( 'Order total', 'yith-woocommerce-product-add-ons' ) );

$price_display_suffix = get_option( 'woocommerce_price_display_suffix', '' );
$price_suffix         = ' <small>' . $price_display_suffix . '</small>';

if ( $price_display_suffix ) {
	if ( strpos( $price_display_suffix, '{price_including_tax}' ) !== false ) {
		$suffix          = '{price_including_tax}';
		$suffix_callback = 'wc_get_price_including_tax';
	} elseif ( strpos( $price_display_suffix, '{price_excluding_tax}' ) !== false ) {
		$suffix          = '{price_excluding_tax}';
		$suffix_callback = 'wc_get_price_excluding_tax';
	}
	if ( $suffix_callback ) {
		$price_callback       = $suffix_callback( $product );
		$price_callback       = wc_price( $price_callback );
		$price_display_suffix = str_replace(
			$suffix,
			$price_callback,
			$price_display_suffix
		);
		$price_suffix         = $price_display_suffix;
	}
}
?>


<?php
			// Verifica si la clave "quantity" está definida en el arreglo
			if (isset($_POST['quantity'])) {
				$quantity = $_POST['quantity'];
			} else {
				// Si no está definida, asigna un valor predeterminado (por ejemplo, 1)
				$quantity = 1;
			}

			// Multiplica el precio por la cantidad
			$total_price = $blocks_product_price * $quantity;

			// Muestra el total en la celda correspondiente de tu tabla
			// echo '<td id="wapo-total-product-price">' . wc_price($blocks_product_price) . '</td>';
			?>

			</tr>

<div id="wapo-total-price-table">
	<table class="<?php echo esc_attr( $total_price_box ); ?>">
		
		<!-- AQUI ESTA EL NUMERO DONDE SE DEBE CALCULAR -->
		<?php if ( $blocks_product_price > 0 ) : ?>
			<tr class="wapo-product-price" style="<?php echo esc_attr( 'only_final' === $total_price_box ? 'display: none;' : '' ); ?>">
				<!-- Product price: -->
				<th><?php echo esc_html( $product_price_label ); ?>:</th> 
				<td id="wapo-total-product-pric"><?php echo wp_kses_post( wc_price( $total_price ) ); ?><?php echo wc_tax_enabled() ? wp_kses_post( $price_suffix ) : ''; ?></td>
<!-- 				<td id="wapo-total-options-price"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>0,00</bdi></span> <small class="woocommerce-price-suffix">Impuestos Incluidos</small></td> -->
				
		<?php endif; ?>
		<!-- AQUI ESTA EL NUMERO DONDE SE DEBE CALCULAR -->
		
		<tr class="wapo-total-options" style="<?php echo esc_attr( 'all' !== $total_price_box ? 'display: none;' : '' ); ?>">
			<th><?php echo esc_html( $total_options_label ); ?>:</th>
			<td id="wapo-total-options-price"></td>
		</tr>
		<?php if ( apply_filters( 'yith_wapo_table_hide_total_order', true ) ) { ?>
			<tr class="wapo-total-order">
				<th><?php echo esc_html( $order_total_label ); ?>:</th>
				<td id="wapo-total-order-price"></td>
			</tr>
		<?php } ?>
	</table>
</div>

<script>

	
  document.querySelector('.input-text.qty.text').addEventListener('input', function() {
    const inputNumero = document.querySelector('.input-text.qty.text'); // Selecciona el elemento por su clase
    inputNumero.id = 'miInputNumero'; // Asigna el ID deseado
    const quantity = parseFloat(document.querySelector('.input-text.qty.text').value); // Obtén el valor de cantidad como número
	if(!quantity){
		quantity = 1;
	}
    const productPrice = <?php echo $total_price ?>; // Valor de $blocks_product_price desde PHP
    const totalPrice = quantity * productPrice; // Calcula el precio total

    const formatter = new Intl.NumberFormat('en-US', {
      style: 'currency',
      currency: 'USD',
      minimumFractionDigits: 2,
    });
    const precioFormateado = formatter.format(totalPrice);
	  const smallElement = document.createElement('small');
smallElement.className = 'woocommerce-price-suffix';
smallElement.textContent = 'Impuestos Incluidos';
    document.getElementById('wapo-total-product-pric').innerHTML = `<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">${precioFormateado}</bdi></span> ${smallElement.outerHTML}`;
	
  });

</script>



<?php

/**
 * Featured Products Template for Woo block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'featured-products-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'featured-products-block';
if (!empty($block['className'])) {
	$className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$className .= ' align' . $block['align'];
}
if ($is_preview) {
	$className .= ' is-admin';
}
// Post ID is in $_POST['post_id'] when rendering ACF block in Gutenberg
$post_id = get_the_ID() ? get_the_ID() : $_POST['post_id'];
?>
<div class="<?php echo esc_attr($className); ?> woocommerce my-products-loop">
	<?php

	global $post; // Do not forget this!

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => 8,
		'post_status' => 'publish',
		'tax_query' => array(
			array(
				'taxonomy' => 'product_visibility',
				'field' => 'name',
				'terms' => 'featured',
			),
		)
	);
	$products = wc_get_products($args);

	// Set loop properties
	$columns = get_field( 'columns' );
	wc_set_loop_prop('columns', $columns);

	// Start custom WC loop
	woocommerce_product_loop_start();
	foreach ($products as $product) {
		// Setup postdata
		$post = get_post($product->get_id());
		setup_postdata($post);
		// Product markup
		echo '<li class="product">';
		echo $product->get_image();
		echo '<h3 class="product-title">' . $product->get_title()  . '</h3>';
		echo $product->get_price_html();
		echo '<p>' . $product->get_short_description() . '</p>';
		echo '<a href="' . $product->get_permalink() . '" class="button">Buy Now</a>';
		echo '</li>';

		//this doesn't work with ACF right now. No fix seems forthcoming.
		// if (function_exists('wc_get_template_part')) {
		// 	wc_get_template_part('content', 'product');
		// };

	}
	// End loop and reset postdata
	woocommerce_product_loop_end();
	wp_reset_postdata();

	?>
</div>
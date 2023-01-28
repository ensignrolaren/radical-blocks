<?php

/**
 * All products Template for woo block
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'all-products-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'all-products-block';
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
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> woocommerce">
	<ul class="products">
		<?php
		global $paged;
		$products_per_page = apply_filters('loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page());
		$term = get_field('limit_to_category');
		$term_name = $term->name;
		
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => $products_per_page,
			'product_cat' => $term_name,
			'paged' => $paged,
			'meta_query' => array(
				array(
					'key' => '_stock_status',
					'value' => 'instock'
				)
			)
		);
		$loop = new WP_Query($args);
		if ($loop->have_posts()) {
			while ($loop->have_posts()) : $loop->the_post();

			// get the WC_Product Object
			$product = wc_get_product(get_the_ID()); ?>
			
				<li class="product">
					<?php
					echo '<a href="' . $product->get_permalink() . '">' . $product->get_image() . '</a>';
					echo '<h3 class="product-title">' . '<a href="' . $product->get_permalink() . '">' . $product->get_title()  . '</a>' . '</h3>';
					echo '<a href="' . $product->get_permalink() . '" class="price">' . $product->get_price_html() . '</a>';
					echo '<a href="' . $product->get_permalink() . '" class="button">Buy Now</a>';

					//this doesn't work with ACF right now. No fix seems forthcoming.
					// wc_get_template_part('content', 'product');
					?>
				</li>
		<?php endwhile;
		} else {
			echo __('No products found');
		}

		wp_reset_postdata();
		?>
		<nav class="woocommerce-pagination">
			<ul>
				<li><?php previous_posts_link('&laquo; PREV', $loop->max_num_pages) ?></li>
				<li><?php next_posts_link('NEXT &raquo;', $loop->max_num_pages) ?></li>
			</ul>
		</nav>
	</ul>
</div>
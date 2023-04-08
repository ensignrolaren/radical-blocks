<?php
/**
* Featured products Template for woo block
*
* @param   array $block The block settings and attributes.
* @param   string $content The block inner HTML (empty).
* @param   bool $is_preview True during AJAX preview.
* @param   (int|string) $post_id The post ID this block is saved to.
*/

// Create id attribute allowing for custom "anchor" value.
$id = 'featured-products-' . $block['id'];
if( !empty($block['anchor']) ) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'featured-products-block';
if( !empty($block['className']) ) {
	$className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
	$className .= ' align' . $block['align'];
}
if( $is_preview ) {
	$className .= ' is-admin';
}
// Post ID is in $_POST['post_id'] when rendering ACF block in Gutenberg
$post_id = get_the_ID() ? get_the_ID() : $_POST['post_id'];
?>
<ul id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> woocommerce">
	<?php
		$columns = get_field( 'columns' );
	?>
	<?php if ( have_rows( 'featured_products' ) ) : ?>
		<?php while ( have_rows( 'featured_products' ) ) : the_row(); ?>
			<?php 
				// vars
				$product = get_sub_field( 'product' );
				$excerpt = get_field('show_excerpts');
			?>
			<?php 
				global $post;
				if( $product ) :
					$post = $product;
					setup_postdata($post); 
					wc_get_template_part( 'content', 'product' );
					wp_reset_postdata(); ?>
				<?php endif; ?>
		<?php endwhile; ?>
	<?php else : ?>
		<?php // no rows found ?>
	<?php endif; ?>
</ul>
<style type="text/css">
	<?php echo '#' . $id; ?> .product {
		flex: 1 1 calc(<?php echo $columns; ?> - 1.5rem);
	}
</style>
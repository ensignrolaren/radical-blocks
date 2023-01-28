<?php

/**
 * Block template file: render.php
 *
 * Rad/row Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'rad/row-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-rad/row';
if (!empty($block['className'])) {
	$classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$classes .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?>">
	<?php if (have_rows('')) : ?>
		<?php while (have_rows('')) : the_row(); ?>
			<InnerBlocks class="rad-row-item__inner" />
		<?php endwhile; ?>
	<?php else : ?>
		<?php // No rows found 
		?>
	<?php endif; ?>
</div>
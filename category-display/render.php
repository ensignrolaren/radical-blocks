<?php

/**
 * Block template file: render.php
 *
 * rad/category-display Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'category-display-' . $block['id'];
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'rad-block-category-display';
if (!empty($block['className'])) {
	$classes .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$classes .= ' align' . $block['align'];
}
?>

<ul id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?>">
	<?php $category = get_field('category'); ?>
	<?php if ($category) : ?>
		<?php foreach ($category as $term) : ?>
			<li class="category-item">
				<a href="<?php echo esc_url(get_term_link($term)); ?>">
					<p><?php echo esc_html($term->name); ?></p>
					<?php if (get_field('show_featured_image') == 1) { ?>

						<?php $term_id = $term->term_id;?>
						<?php $term_id_prefixed = 'category_' . $term_id; ?>

						<?php $featured_image = get_field('featured_image', $term_id_prefixed); ?>

						<?php if ($featured_image) : ?>
							<img src="<?php echo esc_url($featured_image['url']); ?>" alt="<?php echo esc_attr($featured_image['alt']); ?>" />
						<?php endif; ?>
					<?php } ?>
				</a>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>

</ul>
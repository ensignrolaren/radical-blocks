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
<style type="text/css">

	<?php echo '#' . $id; ?>.has-1-columns .category-item {
		flex: 0 1 calc(100% - 1rem);
	}

	<?php echo '#' . $id; ?>.has-2-columns .category-item {
		flex: 0 1 calc(50% - 1rem);
	}

	<?php echo '#' . $id; ?>.has-3-columns .category-item {
		flex: 0 1 calc(33.333% - 1rem);
	}

	<?php echo '#' . $id; ?>.has-4-columns .category-item {
		flex: 0 1 calc(25% - 1rem);
	}

	<?php echo '#' . $id; ?>.has-5-columns .category-item {
		flex: 0 1 calc(20% - 1rem);
	}

	<?php echo '#' . $id; ?>.has-6-columns .category-item {
		flex: 0 1 calc(16.66666667% - 1rem);
	}
</style>
<?php if (get_field('columns')) :
	$columns = (get_field('columns'));
else :
	$columns = 1;
endif; ?>
<ul id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?> has-<?php echo $columns; ?>-columns">
	<?php $category = get_field('category'); ?>
	<?php if ($category) : ?>
		<?php foreach ($category as $term) : ?>
			<li class="category-item">
				<a href="<?php echo esc_url(get_term_link($term)); ?>">
					<p class="category-display-name"><?php echo esc_html($term->name); ?></p>
					<?php if (get_field('show_featured_image') == 1) { ?>

						<?php $term_id = $term->term_id; ?>
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
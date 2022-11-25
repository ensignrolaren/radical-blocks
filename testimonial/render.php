<?php

/**
 * Testimonial block rendering
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = ['rad-testimonial'];
if (!empty($block['className'])) {
	$classes = array_merge($classes, explode(' ', $block['className']));
}
if (!empty($block['align'])) {
	$classes[] = 'align' . $block['align'];
}
if (!empty($block['align_text'])) {
	$classes[] = 'has-text-align-' . $block['align_text'];
}
if (!empty($block['backgroundColor'])) {
	$classes[] = 'has-background';
	$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
}
if (!empty($block['textColor'])) {
	$classes[] = 'has-text-color';
	$classes[] = 'has-' . $block['textColor'] . '-color';
}
printf(
	'<div class="%s"%s>',
	esc_attr(join(' ', $classes)),
	!empty($block['anchor']) ? ' id="' . esc_attr(sanitize_title($block['anchor'])) . '"' : '',
); ?>
	<!-- Testimonial text -->
	<div class="rad-testimonial__body">
		<?php
		$testimonial = get_field('testimonial');
		if ($testimonial) :
			echo $testimonial;
		endif;
		?>
	</div>
	<?php
	$image = get_field('image');
	?>
	<!-- Testimonial attribution -->
	<div class="rad-testimonial__attribution">
		<div class="rad-testimonial__image">
			<?php if ($image) : ?>
				<?php echo wp_get_attachment_image($image['id'], 'full'); ?>
			<?php endif; ?>
		</div>
		<div class="rad-testimonial__text">
			<?php
			$name = get_field('name');
			if ($name) :
				echo '<div class="rad-testimonial__name">' . $name . '</div>';
			endif;
			$company = get_field('company');
			if ($company) :
				echo '<div class="rad-testimonial__company">' . $company . '</div>';
			endif;
			?>
		</div>
	</div>


</div>
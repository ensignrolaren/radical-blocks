<?php

/**
 * Timeline event block rendering
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */ ?>
<div class="rad-timeline__event">
	<?php
	// Create class attribute allowing for custom "className" and "align" values.
	$classes = ['rad-timeline__event-inner'];
	if (!empty($block['className'])) {
		$classes = array_merge($classes, explode(' ', $block['className']));
	}
	if (!empty($block['align'])) {
		$classes[] = 'align' . $block['align'];
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
		'<li class="%s"%s>',
		esc_attr(join(' ', $classes)),
		!empty($block['anchor']) ? ' id="' . esc_attr(sanitize_title($block['anchor'])) . '"' : '',
	); ?>
		<InnerBlocks />
	</li>
	<div class="rad-timeline__event-spacer">
		<!-- spacer -->
	</div>
</div>
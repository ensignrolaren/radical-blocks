<?php

/**
 * copyright block rendering
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>
<?php
// Create class attribute allowing for custom "className" and "align" values.
$classes = ['rad-copyright'];
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
<?php
echo '&copy; ' . date("Y");
echo ' ';
echo bloginfo('name'); ?>
</div>
<?php

/**
 * Post date block rendering
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = '';
if (!empty($block['className'])) {
	$classes .= sprintf(' %s', $block['className']);
}
if (!empty($block['align'])) {
	$classes .= sprintf(' align%s', $block['align']);
}
?>
<?php 
if( !$is_preview ) {
	rad_posted_on();
} else {
	echo '<p>Dynamic Single Post Date</p>';
} 
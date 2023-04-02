<?php

/**
 * FAQ block rendering
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create class attribute allowing for custom "className" and "align" values.
$classes = [ 'rad-faq' ];
if ( ! empty( $block['className'] ) ) {
	$classes = array_merge( $classes, explode( ' ', $block['className'] ) );
}
if ( ! empty( $block['align'] ) ) {
	$classes[] = 'align' . $block['align'];
}
if ( ! empty( $block['backgroundColor'] ) ) {
	$classes[] = 'has-background';
	$classes[] = 'has-' . $block['backgroundColor'] . '-background-color';
}
if ( ! empty( $block['textColor'] ) ) {
	$classes[] = 'has-text-color';
	$classes[] = 'has-' . $block['textColor'] . '-color';
}
printf(
	'<div class="%s"%s>',
	esc_attr(join(' ', $classes)),
	!empty($block['anchor']) ? ' id="' . esc_attr(sanitize_title($block['anchor'])) . '"' : '',
); ?>
	<?php if (have_rows('faqs')) : ?>
		<?php while (have_rows('faqs')) : the_row(); ?>
			<?php if (have_rows('faq')) : ?>
				<?php while (have_rows('faq')) : the_row(); ?>
					<details class="rad-faq__faq">
						<summary class="rad-faq__question">
							<div class="rad-faq__question-inner"><?php the_sub_field('faq_question'); ?></div>
						</summary>
						<div class="rad-faq__answer">
							<?php the_sub_field('faq_answer'); ?>
						</div>
					</details>
					<hr class="rad-faq__separator"/>
				<?php endwhile; ?>
			<?php else : ?>
				<?php // no rows found 
				?>
			<?php endif; ?>
		<?php endwhile; ?>
	<?php endif; ?>

	<?php
	global $schema;
	$schema = array(
		'@context'   => "https://schema.org",
		'@type'      => "FAQPage",
		'mainEntity' => array()
	);
	if (have_rows('faqs')) {
		while (have_rows('faqs')) : the_row();
			if (have_rows('faq')) {
				while (have_rows('faq')) : the_row();
					$questions = array(
						'@type'          => 'Question',
						'name'           => get_sub_field('faq_question'),
						'acceptedAnswer' => array(
							'@type' => "Answer",
							'text' => get_sub_field('faq_answer')
						)
					);
					array_push($schema['mainEntity'], $questions);
				endwhile;
			}
		endwhile;
	}
	?>
</div>
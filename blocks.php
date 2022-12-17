<?php

/**
 * Plugin Name:  Radical Blocks
 * Description:  A collection of custom blocks
 * Version:      1.0.3
 * Author:       Kelsey Barmettler
 * Author URI:   https://kelseybarmettler.com/
 * Text Domain:  radical-pack
 * Requires PHP: 5.6.20
 * GitHub Plugin URI: ensignrolaren/radical-blocks
 * GitHub Plugin URI: https://github.com/ensignrolaren/radical-blocks
 */

// Set new ACF Save and Load points
add_filter('acf/settings/save_json', 'set_acf_json_save_folder');
function set_acf_json_save_folder( $path ) {
	$path = dirname(__FILE__) . '/acf-json';
	return $path;
}
add_filter('acf/settings/load_json', 'add_acf_json_load_folder');
function add_acf_json_load_folder( $paths ) {
	unset($paths[0]);
	$paths[] = dirname(__FILE__) . '/acf-json';
	return $paths;
}

// Register custom blocks
function radical_load_blocks() {
	// Testimonial
	register_block_type(plugin_dir_path(__FILE__) . 'testimonial/block.json');
	// Social Icons
	register_block_type(plugin_dir_path(__FILE__) . 'social-icons/block.json');
	// FAQ
	register_block_type(plugin_dir_path(__FILE__) . 'faq/block.json');
	// Copyright
	register_block_type(plugin_dir_path(__FILE__) . 'copyright/block.json');
	// Post title
	register_block_type(plugin_dir_path(__FILE__) . 'post-title/block.json');
	// Post date
	register_block_type(plugin_dir_path(__FILE__) . 'post-date/block.json');
	// Timeline
	register_block_type(plugin_dir_path(__FILE__) . 'timeline/block.json');
	// Timeline Event
	register_block_type(plugin_dir_path(__FILE__) . 'timeline-event/block.json');
	// Carousel
	register_block_type(plugin_dir_path(__FILE__) . '/carousel/block.json');
	// Carousel Item
	register_block_type(plugin_dir_path(__FILE__) . 'carousel-item/block.json');
}
add_action('init', 'radical_load_blocks');

// Conditionally load block assets only if they're present
// function rad_register_block_script() {
// 	// if we are not in the back end
// 	// if (!is_admin()) {
		// $id = get_the_ID();
		// echo $id;
		// // and also if there's not carousel
		// if (!has_block('rad/carousel')) {
		// 	wp_enqueue_script('carousel', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery']);
		// }
// 	// }
// }
// add_action('init', 'rad_register_block_script');

function rad_register_block_script() {
	wp_register_script('carousel', plugin_dir_url(__FILE__) . 'carousel/slick.min.js', ['jquery']);
}
add_action('init', 'rad_register_block_script');
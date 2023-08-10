<?php

/**
 * Plugin Name:  Custom ACF Blocks
 * Description:  A collection of custom blocks
 * Version:      1.1.23
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
	register_block_type(plugin_dir_path(__FILE__) . 'carousel/block.json');
	// Carousel Item
	register_block_type(plugin_dir_path(__FILE__) . 'carousel-item/block.json');
	// Row
	register_block_type(plugin_dir_path(__FILE__) . 'row/block.json');
	// Category Display
	register_block_type(plugin_dir_path(__FILE__) . 'category-display/block.json');
}
add_action('init', 'radical_load_blocks');

// check if Woocommerce is active
$all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if (stripos(implode($all_plugins), 'woocommerce.php')) {
	// Woo featured products
	register_block_type(plugin_dir_path(__FILE__) . 'featured-products/block.json');
	// Woo all products
	register_block_type(plugin_dir_path(__FILE__) . 'all-products/block.json');
}

function smart_enqueue_block_assets() {
	// Get all blocks on the page
	$block_names = [];
	$blocks = parse_blocks(get_post()->post_content);
	$block_names = get_block_names_recursive($blocks);

	// Get all CSS and JS files in the 'css' and 'js' directories, respectively
	$plugin_dir = plugin_dir_path(__FILE__);
	$css_dir = $plugin_dir . 'css/';
	$css_files = scandir($css_dir);
	$js_dir = $plugin_dir . 'js/';
	$js_files = scandir($js_dir);

	// Check if jQuery is already enqueued
	$jquery_enqueued = wp_script_is('jquery', 'enqueued');

	// Loop through block names and enqueue assets
	foreach ($block_names as $block_name) {
		$css_filename = $block_name . '.css';
		$js_filename = $block_name . '.js';
		if (in_array($css_filename, $css_files)) {
			wp_enqueue_style($block_name, plugins_url('css/' . $css_filename, __FILE__));
		}
		if (in_array($js_filename, $js_files)) {
			$dependencies = array();
			// Enqueue jQuery if it hasn't been enqueued already
			if (!$jquery_enqueued && in_array($block_name, array('thethemefoundry/happyforms', 'carousel'))) {
				wp_enqueue_script('jquery');
				$jquery_enqueued = true;
			}
			wp_enqueue_script($block_name, plugins_url('js/' . $js_filename, __FILE__), $dependencies, false, true);
		}
	}
}

// Recursive function to get all block names on the page, including nested blocks
function get_block_names_recursive($blocks) {
	$block_names = [];
	foreach ($blocks as $block) {
		$block_name = str_replace('rad/', '', $block['blockName']); // Remove 'rad/' from block names
		$block_names[] = $block_name;
		if (!empty($block['innerBlocks'])) {
			$block_names = array_merge($block_names, get_block_names_recursive($block['innerBlocks']));
		}
	}
	return $block_names;
}
add_action('wp_enqueue_scripts', 'smart_enqueue_block_assets');
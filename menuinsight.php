<?php
/**
 * Plugin Name: menuinsight
 * Plugin URI: http://github.com/LinuxDoku/menuinsight
 * Description: See which menus a page belongs to.
 * Version: 0.1
 * Author: Martin Lantzsch
 * Author URI: http://linux-doku.de
 * 
 * @copyright (c) 2014, Martin Lantzsch <martin@linux-doku.de>
 */
add_action('add_meta_boxes', 'menuinsight_add_meta_boxes');

function menuinsight_add_meta_boxes()
{
	add_meta_box(
		'menuinsight', __('MenuInsight', 'menuinsight'), 'menuinsight_meta_box', 'page', 'side'
	);
}

function menuinsight_meta_box()
{
	global $post;

	$menus = wp_get_nav_menus();
	if(is_array($menus)) {
		foreach($menus as $menu) {
			$items = wp_get_nav_menu_items($menu->name);

			if(is_array($items)) {
				foreach($items as $item) {
					if($item->object_id === $post->ID) {
						echo $menu->name . '<br />';
					}
				}
			}
		}
	}
}

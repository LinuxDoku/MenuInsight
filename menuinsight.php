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
add_action('admin_head', 'menuinsight_css');
add_action('add_meta_boxes', 'menuinsight_add_meta_boxes');
add_action('manage_pages_columns', 'menuinsight_pages_column');
add_action('manage_pages_custom_column', 'menuinsight_pages_custom_column', 10, 2);

function menuinsight_css()
{
	echo '<style type="text/css">';
	echo '.manage-column.column-MenuInsight { width: 180px; }';
	echo '</style>';
}

function menuinsight_print_page_menus($page_id)
{
	$menus = wp_get_nav_menus();
	if(is_array($menus)) {
		foreach($menus as $menu) {
			$items = wp_get_nav_menu_items($menu->name);

			if(is_array($items)) {
				foreach($items as $item) {
					if((int)$item->object_id === (int)$page_id) { // nice wordpress, return int as string...
						echo $menu->name . '<br />';
					}
				}
			}
		}
	}
}

function menuinsight_add_meta_boxes()
{
	add_meta_box(
		'menuinsight', __('MenuInsight', 'menuinsight'), 'menuinsight_meta_box', 'page', 'side'
	);
}

function menuinsight_meta_box()
{
	global $post;
	menuinsight_print_page_menus($post->ID);
}

function menuinsight_pages_column($columns)
{
	$columns['MenuInsight'] = 'MenuInsight';
	return $columns;
}

function menuinsight_pages_custom_column($column_name, $page_id)
{
	if($column_name === 'MenuInsight') {
		menuinsight_print_page_menus($page_id);
	}
}
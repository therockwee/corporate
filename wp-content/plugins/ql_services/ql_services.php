<?php
/*
Plugin Name: Theme Services
Plugin URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Description: Theme Services Plugin
Author: QuanticaLabs
Author URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 1.0
*/

//custom post type - services
function ql_services_init()
{
	$labels = array(
		'name' => _x('Services', 'post type general name', 'ql_services'),
		'singular_name' => _x('Service', 'post type singular name', 'ql_services'),
		'add_new' => _x('Add New', 're_sidebar', 'ql_services'),
		'add_new_item' => __('Add New Service', 'ql_services'),
		'edit_item' => __('Edit Service', 'ql_services'),
		'new_item' => __('New Service', 'ql_services'),
		'all_items' => __('Services', 'ql_services'),
		'view_item' => __('View Service', 'ql_services'),
		'search_items' => __('Search Services', 'ql_services'),
		'not_found' =>  __('No services found', 'ql_services'),
		'not_found_in_trash' => __('No services found in Trash', 'ql_services'), 
		'parent_item_colon' => '',
		'menu_name' => __("Services", 'ql_services')
	);
	
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => array("slug" => "services"),
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes") 
	);
	register_post_type("ql_services", $args);
	
	//check for re_services posts
	if(!get_option("services_updated"))
	{	
		$services = get_posts(array(
			'post_type' => 're_services',
			'posts_per_page' => -1
		));
		foreach($services as $service)
			set_post_type($service->ID, "ql_services");
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		add_option("services_updated", 1);
	}
}  
add_action("init", "ql_services_init"); 

//custom sidebars items list
function ql_services_services_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Service name', 'post type singular name', 'ql_services'),
		"order" =>  _x('Order', 'post type singular name', 'ql_services'),
		"date" => __('Date', 'ql_services')
	);    

	return $columns;  
}  
add_filter("manage_edit-ql_services_columns", "ql_services_services_edit_columns");

function manage_ql_services_services_posts_custom_column($column)
{
	global $post;
	switch($column)
	{
		case "order":
			echo get_post($post->ID)->menu_order;
			break;
	}
}
add_action("manage_ql_services_posts_custom_column", "manage_ql_services_services_posts_custom_column");

// Register the column as sortable
function ql_services_services_sortable_columns($columns) 
{
    $columns = array(
		"title" => "title",
		"order" => "order",
		"date" => "date"
	);

    return $columns;
}
add_filter("manage_edit-ql_services_sortable_columns", "ql_services_services_sortable_columns");

function ql_services_shortcode($atts)
{
	extract(shortcode_atts(array(
		"items_per_page" => "-1",
		"ids" => "",
		"order_by" => "title,menu_order",
		"order" => "ASC",
		"headers" => 1,
		"headers_links" => 1,
		"headers_border" => 1,
		"show_excerpt" => 1,
		"show_featured_image" => 1,
		"featured_image_links" => 1,
		"top_margin" => "page-margin-top" 
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	query_posts(array(
		'post__in' => $ids,
		'post_type' => 'ql_services',
		'posts_per_page' => $items_per_page,
		'post_status' => 'publish',
		'orderby' => implode(" ", explode(",", $order_by)),
		'order' => $order
	));
	
	
	$output = "";
	if(have_posts())
	{
		$output .= '<ul class="services-list clearfix' . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
		while(have_posts()): the_post();
			$output .= '<li>';
			if((int)$show_featured_image)
			{
				if((int)$featured_image_links)
					$output .= '<a href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">';
				$output .= get_the_post_thumbnail(get_the_ID(), "medium-thumb" , array("alt" => get_the_title(), "title" => ""));
				if((int)$featured_image_links)
					$output .= '</a>';
			}
			if((int)$headers)
				$output .= '<h4' . ((int)$headers_border ? ' class="box-header"' : '') . '>' . ((int)$headers_links ? '<a href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">' : '') . get_the_title() .  ((int)$headers_links ? '</a>' : '') . '</h4>';
			if((int)$show_excerpt && has_excerpt())
				$output .= apply_filters('the_excerpt', get_the_excerpt());
			$output .= '</li>';
		endwhile;
		$output .= '</ul>';
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("ql_services", "ql_services_shortcode");
add_shortcode("re_services", "ql_services_shortcode");

//visual composer
function ql_services_vc_init()
{
	if(is_plugin_active("js_composer/js_composer.php") && function_exists('wpb_map'))
	{
		//get services list
		$services_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'ql_services'
		));
		$services_array = array();
		$services_array[__("All", 'ql_services')] = "-";
		foreach($services_list as $service)
			$services_array[$service->post_title . " (id:" . $service->ID . ")"] = $service->ID;

		wpb_map( array(
			"name" => __("Services list", 'ql_services'),
			"base" => "ql_services",
			"class" => "",
			"controls" => "full",
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-layer-custom-post-type-list",
			"category" => __('Plugins', 'ql_services'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Items per page/Post count", 'ql_services'),
					"param_name" => "items_per_page",
					"value" => -1,
					"description" => __("Set -1 to display all.", 'ql_services')
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display selected", 'ql_services'),
					"param_name" => "ids",
					"value" => $services_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order by", 'ql_services'),
					"param_name" => "order_by",
					"value" => array(__("Title, menu order", 'ql_services') => "title,menu_order", __("Menu order", 'ql_services') => "menu_order", __("Date", 'ql_services') => "date", __("Random", 'ql_services') => "rand")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order", 'ql_services'),
					"param_name" => "order",
					"value" => array(__("ascending", 'ql_services') => "ASC", __("descending", 'ql_services') => "DESC")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers", 'ql_services'),
					"param_name" => "headers",
					"value" => array(__("Yes", 'ql_services') => 1, __("No", 'ql_services') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers links", 'ql_services'),
					"param_name" => "headers_links",
					"value" => array(__("Yes", 'ql_services') => 1, __("No", 'ql_services') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers border", 'ql_services'),
					"param_name" => "headers_border",
					"value" => array(__("Yes", 'ql_services') => 1, __("No", 'ql_services') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Show excerpt", 'ql_services'),
					"param_name" => "show_excerpt",
					"value" => array(__("Yes", 'ql_services') => 1, __("No", 'ql_services') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Show featured image", 'ql_services'),
					"param_name" => "show_featured_image",
					"value" => array(__("Yes", 'ql_services') => 1, __("No", 'ql_services') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Featured image links", 'ql_services'),
					"param_name" => "featured_image_links",
					"value" => array(__("Yes", 'ql_services') => 1, __("No", 'ql_services') => 0),
					"dependency" => Array('element' => "show_featured_image", 'value' => '1')
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Top margin", 'ql_services'),
					"param_name" => "top_margin",
					"value" => array(__("None", 'ql_services') => "none", __("Page (small)", 'ql_services') => "page-margin-top", __("Section (large)", 'ql_services') => "page-margin-top-section")
				)
			)
		));
	}
}
add_action("init", "ql_services_vc_init"); 
?>
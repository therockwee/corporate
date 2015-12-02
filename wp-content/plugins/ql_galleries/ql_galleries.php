<?php
/*
Plugin Name: Theme Galleries
Plugin URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Description: Theme Galleries Plugin
Author: QuanticaLabs
Author URI: http://themeforest.net/user/QuanticaLabs/portfolio?ref=QuanticaLabs
Version: 1.0
*/

//custom post type - galleries
function ql_galleries_init()
{
	$labels = array(
		'name' => _x('Galleries', 'post type general name', 'ql_galleries'),
		'singular_name' => _x('Gallery', 'post type singular name', 'ql_galleries'),
		'add_new' => _x('Add New', 're_sidebar', 'ql_galleries'),
		'add_new_item' => __('Add New Gallery', 'ql_galleries'),
		'edit_item' => __('Edit Gallery', 'ql_galleries'),
		'new_item' => __('New Gallery', 'ql_galleries'),
		'all_items' => __('Galleries', 'ql_galleries'),
		'view_item' => __('View Gallery', 'ql_galleries'),
		'search_items' => __('Search Galleries', 'ql_galleries'),
		'not_found' =>  __('No galleries found', 'ql_galleries'),
		'not_found_in_trash' => __('No galleries found in Trash', 'ql_galleries'), 
		'parent_item_colon' => '',
		'menu_name' => __("Galleries", 'ql_galleries')
	);
	
	$args = array(  
		"labels" => $labels, 
		"public" => true,  
		"show_ui" => true,  
		"capability_type" => "post",
		"menu_position" => 20,
		"hierarchical" => false,  
		"rewrite" => array("slug" => "galleries"),
		"supports" => array("title", "editor", "excerpt", "thumbnail", "page-attributes") 
	);
	register_post_type("ql_galleries", $args);
	register_taxonomy("ql_galleries_category", array("ql_galleries"), array("label" => "Categories", "singular_label" => "Category", "rewrite" => true));
}  
add_action("init", "ql_galleries_init"); 

//galleries items list
function ql_galleries_edit_columns($columns)
{
	$columns = array(  
		"cb" => "<input type=\"checkbox\" />",  
		"title" => _x('Gallery name', 'post type singular name', 'ql_galleries'),
		"ql_galleries_category" => __('Categories', 'ql_galleries'),
		"order" =>  _x('Order', 'post type singular name', 'ql_galleries'),
		"date" => __('Date', 'ql_galleries')
	);    

	return $columns;  
}  
add_filter("manage_edit-ql_galleries_columns", "ql_galleries_edit_columns");

function manage_ql_galleries_posts_custom_column($column)
{
	global $post;
	switch($column)
	{
		case "ql_galleries_category":
			echo get_the_term_list($post->ID, "ql_galleries_category", '', ', ','');
			break;
		case "order":
			echo get_post($post->ID)->menu_order;
			break;
	}
}
add_action("manage_ql_galleries_posts_custom_column", "manage_ql_galleries_posts_custom_column");

// Register the column as sortable
function ql_galleries_sortable_columns($columns) 
{
    $columns = array(
		"title" => "title",
		"order" => "order",
		"date" => "date"
	);

    return $columns;
}
add_filter("manage_edit-ql_galleries_sortable_columns", "ql_galleries_sortable_columns");

function ql_galleries_shortcode($atts)
{
	extract(shortcode_atts(array(
		"items_per_page" => "-1",
		"category" => "",
		"ids" => "",
		"order_by" => "title,menu_order",
		"order" => "ASC",
		"type" => "list",
		"all_label" => __("All Galleries", 'ql_galleries'),
		"headers" => 1,
		"read_more" => 1,
		"read_more_label" => __("READ MORE", 'ql_galleries'),
		"top_margin" => "page-margin-top" 
	), $atts));
	
	$ids = explode(",", $ids);
	if($ids[0]=="-" || $ids[0]=="")
	{
		unset($ids[0]);
		$ids = array_values($ids);
	}
	$category = explode(",", $category);
	if($category[0]=="-" || $category[0]=="")
	{
		unset($category[0]);
		$category = array_values($category);
	}
	query_posts(array(
		'post__in' => $ids,
		'post_type' => 'ql_galleries',
		'posts_per_page' => $items_per_page,
		'post_status' => 'publish',
		'ql_galleries_category' => implode(",", $category),
		'orderby' => implode(" ", explode(",", $order_by)),
		'order' => $order
	));
	
	
	$output = "";
	if(have_posts())
	{
		if($type=="isotope")
		{
			$categories_count = count($category);
			$output .= '<div class="clearfix gray small"><ul class="ui-tabs-nav isotope-filters margin-top-70">';
			if($all_label!="")
				$output .= '<li>
						<a class="selected" href="#filter-*" title="' . ($all_label!='' ? esc_attr($all_label) : '') . '">' . ($all_label!='' ? $all_label : '') . '</a>
					</li>';
			for($i=0; $i<$categories_count; $i++)
			{
				$term = get_term_by('slug', $category[$i], "ql_galleries_category");
				$output .= '<li>
						<a href="#filter-' . trim($category[$i]) . '" title="' . esc_attr($term->name) . '">' . $term->name . '</a>
					</li>';
			}
			$output .= '</ul>';
		}
		$output .= '<ul class="galleries-list clearfix' . ($type=="isotope" ? ' isotope' : '') . ($top_margin!="none" ? ' ' . $top_margin : '') . '">';
		while(have_posts()): the_post();
			if($type=="isotope")
			{
				$categories = array_filter((array)get_the_terms(get_the_ID(), "ql_galleries_category"));
				$categories_count = count($categories);
				$categories_string = "";
				$i = 0;
				foreach($categories as $category)
				{
					$categories_string .= urldecode($category->slug) . ($i+1<$categories_count ? ' ' : '');
					$i++;
				}
			}
			$output .= '<li' . ($type=="isotope" ? ' class="' . $categories_string . '"' : '') . '>
			<a href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">
				' . get_the_post_thumbnail(get_the_ID(), ($type=="isotope" ? "small" : "big") . "-thumb" , array("alt" => get_the_title(), "title" => "")) . '
			</a>';
			if((int)$headers || (int)$read_more)
			{
				$output .= '<div class="view align-center">
					<div class="vertical-align-table">
						<div class="vertical-align-cell">';
				if((int)$headers)
					$output .= '<p class="description">' . get_the_title() . '</p>';
				if((int)$read_more)
					$output .= '<a class="more simple" href="' . get_permalink() . '" title="' . esc_attr($read_more_label) . '">' . $read_more_label . '</a>';
				$output .= '</div>
					</div>
				</div>';
			}
		endwhile;
		$output .= '</ul>';
		if($type=="isotope")
			$output .= '</div>';
	}
	//Reset Query
	wp_reset_query();
	return $output;
}
add_shortcode("ql_galleries", "ql_galleries_shortcode");

//visual composer
function ql_galleries_vc_init()
{
	if(is_plugin_active("js_composer/js_composer.php") && function_exists('wpb_map'))
	{
		//get galleries list
		$galleries_list = get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'post_type' => 'ql_galleries'
		));
		$galleries_array = array();
		$galleries_array[__("All", 'ql_galleries')] = "-";
		foreach($galleries_list as $gallery)
			$galleries_array[$gallery->post_title . " (id:" . $gallery->ID . ")"] = $gallery->ID;
			
		//get galleries categories list
		$galleries_categories = get_terms("ql_galleries_category");
		$galleries_categories_array = array();
		$galleries_categories_array[__("All", 'ql_galleries')] = "-";
		foreach($galleries_categories as $galleries_category)
			$galleries_categories_array[$galleries_category->name] =  $galleries_category->slug;

		wpb_map( array(
			"name" => __("Galleries list", 'ql_galleries'),
			"base" => "ql_galleries",
			"class" => "",
			"controls" => "full",
			"show_settings_on_create" => true,
			"icon" => "icon-wpb-layer-custom-post-type-list",
			"category" => __('Plugins', 'ql_galleries'),
			"params" => array(
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Items per page/Post count", 'ql_galleries'),
					"param_name" => "items_per_page",
					"value" => -1,
					"description" => __("Set -1 to display all.", 'ql_galleries')
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display selected", 'ql_galleries'),
					"param_name" => "ids",
					"value" => $galleries_array
				),
				array(
					"type" => "dropdownmulti",
					"class" => "",
					"heading" => __("Display from Category", 'ql_galleries'),
					"param_name" => "category",
					"value" => $galleries_categories_array
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order by", 'ql_galleries'),
					"param_name" => "order_by",
					"value" => array(__("Title, menu order", 'ql_galleries') => "title,menu_order", __("Menu order", 'ql_galleries') => "menu_order", __("Date", 'ql_galleries') => "date", __("Random", 'ql_galleries') => "rand")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Order", 'ql_galleries'),
					"param_name" => "order",
					"value" => array(__("ascending", 'ql_galleries') => "ASC", __("descending", 'ql_galleries') => "DESC")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Type", 'ql_galleries'),
					"param_name" => "type",
					"value" => array(__("list", 'ql_galleries') => "list", __("isotope", 'ql_galleries') => "isotope")
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("All filter label", 'ql_galleries'),
					"param_name" => "all_label",
					"value" => __("All Galleries", 'ql_galleries'),
					"dependency" => Array('element' => "type", 'value' => "isotope")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Headers", 'ql_galleries'),
					"param_name" => "headers",
					"value" => array(__("Yes", 'ql_galleries') => 1, __("No", 'ql_galleries') => 0)
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Read more button", 'ql_galleries'),
					"param_name" => "read_more",
					"value" => array(__("Yes", 'ql_galleries') => 1, __("No", 'ql_galleries') => 0)
				),
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __("Read more button label", 'ql_galleries'),
					"param_name" => "read_more_label",
					"value" => __("READ MORE", 'ql_galleries'),
					"dependency" => Array('element' => "read_more", 'value' => "1")
				),
				array(
					"type" => "dropdown",
					"class" => "",
					"heading" => __("Top margin", 'ql_galleries'),
					"param_name" => "top_margin",
					"value" => array(__("None", 'ql_galleries') => "none", __("Page (small)", 'ql_galleries') => "page-margin-top", __("Section (large)", 'ql_galleries') => "page-margin-top-section")
				)
			)
		));
	}
}
add_action("init", "ql_galleries_vc_init"); 
?>
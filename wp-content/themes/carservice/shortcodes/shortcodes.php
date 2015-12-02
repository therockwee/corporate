<?php
global $carservice_posts_array;
$carservice_posts_array = array();
$count_posts = wp_count_posts();
if($count_posts->publish<100)
{
	$carservice_posts_list = get_posts(array(
		'posts_per_page' => -1,
		'nopaging' => true,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'post'
	));
	$carservice_posts_array[__("All", 'carservice')] = "-";
	foreach($carservice_posts_list as $post)
		$carservice_posts_array[$post->post_title . " (id:" . $post->ID . ")"] = $post->ID;
}

global $carservice_pages_array;
$carservice_pages_array = array();
$count_pages = wp_count_posts('page');
if($count_pages->publish<100)
{
	$pages_list = get_posts(array(
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'page'
	));
	$carservice_pages_array = array();
	$carservice_pages_array[__("none", 'carservice')] = "-";
	foreach($pages_list as $single_page)
		$carservice_pages_array[$single_page->post_title . " (id:" . $single_page->ID . ")"] = $single_page->ID;
}

//blog 1 column
require_once(get_template_directory() . "/shortcodes/blog.php");
//blog 2 columns
require_once(get_template_directory() . "/shortcodes/blog_2_columns.php");
//blog small
require_once(get_template_directory() . "/shortcodes/blog_small.php");
//post
require_once(get_template_directory() . "/shortcodes/single-post.php");
//comments
require_once(get_template_directory() . "/shortcodes/comments.php");
//items_list
require_once(get_template_directory() . "/shortcodes/items_list.php");
//map
require_once(get_template_directory() . "/shortcodes/map.php");
if(is_plugin_active('ql_services/ql_services.php'))
{
	//service single
	require_once(get_template_directory() . "/shortcodes/single-service.php");
}
if(is_plugin_active('ql_galleries/ql_galleries.php'))
{
	//gallery single
	require_once(get_template_directory() . "/shortcodes/single-gallery.php");
}
//about box
require_once(get_template_directory() . "/shortcodes/call_to_action_box.php");
//featured item
require_once(get_template_directory() . "/shortcodes/featured_item.php");
//announcement box
require_once(get_template_directory() . "/shortcodes/announcement_box.php");
//pricing table
if(is_plugin_active('css3_web_pricing_tables_grids/css3_web_pricing_tables_grids.php'))
	require_once(get_template_directory() . "/shortcodes/pricing_table.php");
//testimonials
require_once(get_template_directory() . "/shortcodes/testimonials.php");
//our clients carousel
require_once(get_template_directory() . "/shortcodes/our_clients_carousel.php");
//cost calculator
require_once(get_template_directory() . "/shortcodes/cost_calculator_slider_box.php");
require_once(get_template_directory() . "/shortcodes/cost_calculator_dropdown_box.php");
require_once(get_template_directory() . "/shortcodes/cost_calculator_input_box.php");
require_once(get_template_directory() . "/shortcodes/cost_calculator_summary_box.php");
require_once(get_template_directory() . "/shortcodes/cost_calculator_contact_box.php");

//row inner
$attributes = array(
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Type", 'carservice'),
		"param_name" => "type",
		"value" => array(__("Default", 'carservice') => "",  __("Full width", 'carservice') => "full-width",  __("Paralax background", 'carservice') => "full-width cs-parallax", __("Appointment form", 'carservice') => "cost-calculator-container"),
		"description" => __("Select row type", "carservice")
	),
	array(
		"type" => "dropdown",
		"class" => "",
		"heading" => __("Top margin", 'carservice'),
		"param_name" => "top_margin",
		"value" => array(__("None", 'carservice') => "none",  __("Page (small)", 'carservice') => "page-margin-top", __("Section (large)", 'carservice') => "page-margin-top-section"),
		"description" => __("Select top margin value for your row", "carservice")
	)
);
vc_add_params('vc_row_inner', $attributes);
//row
vc_map( array(
	'name' => __( 'Row', 'js_composer' ),
	'base' => 'vc_row',
	'is_container' => true,
	'icon' => 'icon-wpb-row',
	'show_settings_on_create' => false,
	'category' => __( 'Content', 'js_composer' ),
	'description' => __( 'Place content elements inside the row', 'js_composer' ),
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Row ID', 'js_composer' ),
			'param_name' => 'el_id',
			'description' => __( 'Enter optionally row ID. Make sure it is unique, and it is valid as w3c specification: <a href="' . esc_url(__('http://www.w3schools.com/tags/att_global_id.asp', 'carservice')) . '" target="_blank">link</a> (Must not have spaces)', 'js_composer' ),
		),
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Font Color', 'js_composer' ),
			'param_name' => 'font_color',
			'description' => __( 'Select font color', 'js_composer' ),
			'edit_field_class' => 'vc_col-md-6 vc_column'
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'carservice'),
			"param_name" => "type",
			"value" => array(__("Default", 'carservice') => "",  __("Full width", 'carservice') => "full-width",  __("Paralax background", 'carservice') => "full-width cs-parallax", __("Cost calculator form", 'carservice') => "cost-calculator-container"),
			"description" => __("Select row type", "carservice")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'carservice'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'carservice') => "none",  __("Page (small)", 'carservice') => "page-margin-top", __("Section (large)", 'carservice') => "page-margin-top-section"),
			"description" => __("Select top margin value for your row", "carservice")
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		)
	),
	'js_view' => 'VcRowView'
) );

//column
$column_width_list = array(
	__('1 column - 1/12', 'js_composer') => '1/12',
	__('2 columns - 1/6', 'js_composer') => '1/6',
	__('3 columns - 1/4', 'js_composer') => '1/4',
	__('4 columns - 1/3', 'js_composer') => '1/3',
	__('5 columns - 5/12', 'js_composer') => '5/12',
	__('6 columns - 1/2', 'js_composer') => '1/2',
	__('7 columns - 7/12', 'js_composer') => '7/12',
	__('8 columns - 2/3', 'js_composer') => '2/3',
	__('9 columns - 3/4', 'js_composer') => '3/4',
	__('10 columns - 5/6', 'js_composer') => '5/6',
	__('11 columns - 11/12', 'js_composer') => '11/12',
	__('12 columns - 1/1', 'js_composer') => '1/1'
);
vc_map( array(
	'name' => __( 'Column', 'js_composer' ),
	'base' => 'vc_column',
	'is_container' => true,
	//"as_parent" => array('except' => 'vc_row'),
	'content_element' => false,
	'params' => array(
		array(
			'type' => 'colorpicker',
			'heading' => __( 'Font Color', 'js_composer' ),
			'param_name' => 'font_color',
			'description' => __( 'Select font color', 'js_composer' ),
			'edit_field_class' => 'vc_col-md-6 vc_column'
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Extra class name', 'js_composer' ),
			'param_name' => 'el_class',
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Column type", 'carservice'),
			"param_name" => "type",
			"value" => array(__("Default", 'carservice') => "",  __("Smart (sticky)", 'carservice') => "cs-smart-column"),
			"dependency" => Array('element' => "width", 'value' => array_map('strval', array_values((array_slice($column_width_list, 0, -1)))))
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'carservice'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'carservice') => "none",  __("Page (small)", 'carservice') => "page-margin-top", __("Section (large)", 'carservice') => "page-margin-top-section"),
			"description" => __("Select top margin value for your column", "carservice")
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' )
		),
		array(
			'type' => 'dropdown',
			'heading' => __( 'Width', 'js_composer' ),
			'param_name' => 'width',
			'value' => $column_width_list,
			'group' => __( 'Width & Responsiveness', 'js_composer' ),
			'description' => __( 'Select column width.', 'js_composer' ),
			'std' => '1/1'
		),
		array(
			'type' => 'column_offset',
			'heading' => __('Responsiveness', 'js_composer'),
			'param_name' => 'offset',
			'group' => __( 'Width & Responsiveness', 'js_composer' ),
			'description' => __('Adjust column for different screen sizes. Control width, offset and visibility settings.', 'js_composer')
		)
	),
	'js_view' => 'VcColumnView'
) );

$vc_is_wp_version_3_6_more = version_compare( preg_replace( '/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo( 'version' ) ), '3.6' ) >= 0;
//tab
vc_map( array(
	'name' => __( 'Tab', 'js_composer' ),
	'base' => 'vc_tab',
	"as_parent" => array('except' => 'vc_tabs, vc_accordion'),
	"allowed_container_element" => array('vc_row', 'vc_nested_tabs', 'vc_nested_accordion'),
	'is_container' => true,
	'content_element' => false,
	'params' => array(
		array(
			'type' => 'textfield',
			'heading' => __( 'Title', 'js_composer' ),
			'param_name' => 'title',
			'description' => __( 'Tab title.', 'js_composer' )
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon", 'carservice'),
			"param_name" => "icon",
			"value" => array(
				__("none", 'carservice') => "none",
				__("bricks", 'carservice') => "sl-small-bricks",
				__("briefcase", 'carservice') => "sl-small-briefcase",
				__("brush-1", 'carservice') => "sl-small-brush-1",
				__("brush-2", 'carservice') => "sl-small-brush-2",
				__("bubble", 'carservice') => "sl-small-bubble",
				__("bubble check", 'carservice') => "sl-small-bubble-check",
				__("bucket", 'carservice') => "sl-small-bucket",
				__("building", 'carservice') => "sl-small-building",
				__("calculator", 'carservice') => "sl-small-calculator",
				__("camera", 'carservice') => "sl-small-camera",
				__("cart-1", 'carservice') => "sl-small-cart-1",
				__("cart-2", 'carservice') => "sl-small-cart-2",
				__("chat", 'carservice') => "sl-small-chat",
				__("clock", 'carservice') => "sl-small-clock",
				__("cone", 'carservice') => "sl-small-cone",
				__("construction", 'carservice') => "sl-small-construction",
				__("conversation", 'carservice') => "sl-small-conversation",
				__("lab", 'carservice') => "sl-small-documents",
				__("door", 'carservice') => "sl-small-door",
				__("driller", 'carservice') => "sl-small-driller",
				__("eco", 'carservice') => "sl-small-eco",
				__("faq", 'carservice') => "sl-small-faq",
				__("fax", 'carservice') => "sl-small-fax",
				__("fence", 'carservice') => "sl-small-fence",
				__("forklift", 'carservice') => "sl-small-forklift",
				__("garage", 'carservice') => "sl-small-garage",
				__("gears", 'carservice') => "sl-small-gears",
				__("globe", 'carservice') => "sl-small-globe",
				__("hammer", 'carservice') => "sl-small-hammer",
				__("helmet", 'carservice') => "sl-small-helmet",
				__("house-1", 'carservice') => "sl-small-house-1",
				__("house-2", 'carservice') => "sl-small-house-2",
				__("key", 'carservice') => "sl-small-key",
				__("documents", 'carservice') => "sl-small-lab",
				__("lightbulb", 'carservice') => "sl-small-lightbulb",
				__("list", 'carservice') => "sl-small-list",
				__("location", 'carservice') => "sl-small-location",
				__("lock", 'carservice') => "sl-small-lock",
				__("mail", 'carservice') => "sl-small-mail",
				__("measure", 'carservice') => "sl-small-measure",
				__("megaphone", 'carservice') => "sl-small-megaphone",
				__("payment", 'carservice') => "sl-small-payment",
				__("pencil", 'carservice') => "sl-small-pencil",
				__("percent", 'carservice') => "sl-small-percent",
				__("person", 'carservice') => "sl-small-person",
				__("phone", 'carservice') => "sl-small-phone",
				__("photo", 'carservice') => "sl-small-photo",
				__("picture", 'carservice') => "sl-small-picture",
				__("plan", 'carservice') => "sl-small-plan",
				__("poster", 'carservice') => "sl-small-poster",
				__("quote", 'carservice') => "sl-small-quote",
				__("roller", 'carservice') => "sl-small-roller",
				__("ruler", 'carservice') => "sl-small-ruler",
				__("scissors", 'carservice') => "sl-small-scissors",
				__("screwdriver", 'carservice') => "sl-small-screwdriver",
				__("shield", 'carservice') => "sl-small-shield",
				__("shovel", 'carservice') => "sl-small-shovel",
				__("speaker", 'carservice') => "sl-small-speaker",
				__("stationery", 'carservice') => "sl-small-stationery",
				__("team", 'carservice') => "sl-small-team",
				__("tick", 'carservice') => "sl-small-tick",
				__("trolley", 'carservice') => "sl-small-trolley",
				__("trophy", 'carservice') => "sl-small-trophy",
				__("trowel", 'carservice') => "sl-small-trowel",
				__("truck", 'carservice') => "sl-small-truck",
				__("video", 'carservice') => "sl-small-video",
				__("wallet", 'carservice') => "sl-small-wallet",
				__("watering-can", 'carservice') => "sl-small-watering-can",
				__("wrench", 'carservice') => "sl-small-wrench",
				__("wrenches", 'carservice') => "sl-small-wrenches")
		),
		array(
			'type' => 'textfield',
			'heading' => __( 'Tab ID', 'js_composer' ),
			'param_name' => "tab_id"
		)
	),
	'js_view' => $vc_is_wp_version_3_6_more ? 'VcTabView' : 'VcTabView35'
) );

//box_header
function cs_theme_box_header($atts)
{
	extract(shortcode_atts(array(
		"title" => "Sample Header",
		"type" => "h4",
		"class" => "",
		"bottom_border" => 1,
		"top_margin" => "none"
	), $atts));
	
	return '<' . esc_attr($type) . ((int)$bottom_border || $class!="" || $top_margin!="none" ? ' class="' : '') . ((int)$bottom_border ? ' box-header' : '') . ($class!="" ? ' ' . esc_attr($class) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . ((int)$bottom_border || $class!="" || $top_margin!="none" ? '"' : '') . '>' . do_shortcode($title) . '</' . esc_attr($type) . '>';
}
add_shortcode("box_header", "cs_theme_box_header");
//visual composer
wpb_map( array(
	"name" => __("Box header", 'carservice'),
	"base" => "box_header",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-box-header",
	"category" => __('Carservice', 'carservice'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'carservice'),
			"param_name" => "title",
			"value" => "Sample Header"
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'carservice'),
			"param_name" => "type",
			"value" => array(__("H1", 'carservice') => "h1", __("H2", 'carservice') => "h2", __("H3", 'carservice') => "h3", __("H4", 'carservice') => "h4", __("H5", 'carservice') => "h5", __("H6", 'carservice') => "h6", __("Label", 'carservice') => "label")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Bottom border", 'carservice'),
			"param_name" => "bottom_border",
			"value" => array(__("yes", 'carservice') => 1,  __("no", 'carservice') => 0)
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'carservice'),
			"param_name" => "class",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'carservice'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'carservice') => "none", __("Page (small)", 'carservice') => "page-margin-top", __("Section (large)", 'carservice') => "page-margin-top-section")
		)
	)
));

//read more
function cs_theme_button($atts)
{
	extract(shortcode_atts(array(
		"type" => "read_more",
		"icon" => "none",
		"url" => "",
		"title" => __("READ MORE", 'carservice'),
		"label" => "",
		"target" => "",
		"extraclass" => "",
		"top_margin" => "none"
	), $atts));

	$output = (is_rtl() ?  (($label!="" ? '<h3>' : '') . '<a class="' . ($type=="read_more" ? 'more' : 'cs-action-button') . ($type=="action" && !empty($icon) && $icon!="none" ? ' template-' . esc_attr($icon) : '') . (!empty($extraclass) ? ' ' . esc_attr($extraclass) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '" href="' . esc_url($url) . '" title="' . esc_attr($title) . '"><span>' . $title . '</span></a>' . ($label!="" ? '<span class="button-label">' . $label . '</span></h3>' : '')) : (($label!="" ? '<h3><span class="button-label">' . $label . '</span>' : '') . '<a class="' . ($type=="read_more" ? 'more' : 'cs-action-button') . ($type=="action" && !empty($icon) && $icon!="none" ? ' template-' . esc_attr($icon) : '') . (!empty($extraclass) ? ' ' . esc_attr($extraclass) : '') . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '" href="' . esc_url($url) . '" title="' . esc_attr($title) . '"><span>' . $title . '</span></a>' . ($label!="" ? '</h3>' : '')));
	return $output;	
}
add_shortcode("vc_btn", "cs_theme_button");
//visual composer
wpb_map( array(
	"name" => __("Button", 'carservice'),
	"base" => "vc_btn",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-ui-button",
	"category" => __('Carservice', 'carservice'),
	"params" => array(
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Type", 'carservice'),
			"param_name" => "type",
			"value" => array(__("Read more button", 'carservice') => "read_more", __("Action button", 'carservice') => "action")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon", 'carservice'),
			"param_name" => "icon",
			"value" => array(
				__("none", 'carservice') => "none",
				__("arrow-circle-down", 'carservice') => "arrow-circle-down",
				__("arrow-circle-right", 'carservice') => "arrow-circle-right",
				__("arrow-dropdown", 'carservice') => "arrow-dropdown",
				__("arrow-left-1", 'carservice') => "arrow-left-1",
				__("arrow-left-2", 'carservice') => "arrow-left-2",
				__("arrow-right-1", 'carservice') => "arrow-right-1",
				__("arrow-right-2", 'carservice') => "arrow-right-2",
				__("arrow-menu", 'carservice') => "arrow-menu",
				__("arrow-up", 'carservice') => "arrow-up",
				__("bubble", 'carservice') => "bubble",
				__("bullet", 'carservice') => "bullet",
				__("calendar", 'carservice') => "calendar",
				__("clock", 'carservice') => "clock",
				__("location", 'carservice') => "location",
				__("eye", 'carservice') => "eye",
				__("mail", 'carservice') => "mail",
				__("map-marker", 'carservice') => "map-marker",
				__("phone", 'carservice') => "phone",
				__("search", 'carservice') => "search",
				__("shopping-cart", 'carservice') => "shopping-cart"
			),
			"dependency" => Array('element' => "type", 'value' => "action")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'carservice'),
			"param_name" => "title",
			"value" => __("READ MORE", 'carservice')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Label", 'carservice'),
			"param_name" => "label",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Url", 'carservice'),
			"param_name" => "url",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button target", 'carservice'),
			"param_name" => "target",
			"value" => array(__("Same window", 'carservice') => "", __("New window", 'carservice') => "_blank")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'carservice'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'carservice') => "none", __("Page (small)", 'carservice') => "page-margin-top", __("Section (large)", 'carservice') => "page-margin-top-section")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Extra class name", 'carservice'),
			"param_name" => "extraclass",
			"value" => ""
		),
	)
));
?>
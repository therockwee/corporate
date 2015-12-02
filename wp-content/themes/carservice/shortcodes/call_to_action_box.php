<?php
//post
function cs_theme_call_to_action_box($atts, $content)
{
	extract(shortcode_atts(array(
		"title" => "",
		"icon" => "none",
		"button_label" => "",
		"button_url" => "",
		"button_target" => "",
		"top_margin" => "none"
	), $atts));

	$output = '<div class="call-to-action' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">';
	if(isset($icon) && $icon!="" && $icon!="none")
		$output .= '<div class="hexagon small"><div class="sl-small-' . esc_attr($icon) . '"></div></div>';
	if($title!="")
		$output .= '<h4>' . $title . '</h4>';
	if($content!="")
		$output .= '<p class="description">' . wpb_js_remove_wpautop($content) . '</p>';
	if($button_label!="")
		$output .= '<a class="more" href="' . esc_url($button_url) . '"' . ($button_target!="" ? ' target="' . esc_attr($button_target) . '"' : '') . ' title="' . esc_attr($button_label) . '"><span>' . $button_label . '</span></a>';
	$output .= '</div>';
	return $output;
}
add_shortcode("call_to_action_box", "cs_theme_call_to_action_box");

//visual composer
function cs_theme_call_to_action_box_vc_init()
{
	$params = array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", 'carservice'),
			"param_name" => "title",
			"value" => ""
		),
		array(
			"type" => "textarea_html",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text", 'carservice'),
			"param_name" => "content",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Icon", 'carservice'),
			"param_name" => "icon",
			"value" => array(
				__("none", 'carservice') => "none",
				__("bricks", 'carservice') => "bricks",
				__("briefcase", 'carservice') => "briefcase",
				__("brush-1", 'carservice') => "brush-1",
				__("brush-2", 'carservice') => "brush-2",
				__("bubble", 'carservice') => "bubble",
				__("bubble check", 'carservice') => "bubble-check",
				__("bucket", 'carservice') => "bucket",
				__("building", 'carservice') => "building",
				__("calculator", 'carservice') => "calculator",
				__("camera", 'carservice') => "camera",
				__("cart-1", 'carservice') => "cart-1",
				__("cart-2", 'carservice') => "cart-2",
				__("chat", 'carservice') => "chat",
				__("clock", 'carservice') => "clock",
				__("cone", 'carservice') => "cone",
				__("construction", 'carservice') => "construction",
				__("conversation", 'carservice') => "conversation",
				__("lab", 'carservice') => "documents",
				__("door", 'carservice') => "door",
				__("driller", 'carservice') => "driller",
				__("eco", 'carservice') => "eco",
				__("faq", 'carservice') => "faq",
				__("fax", 'carservice') => "fax",
				__("fence", 'carservice') => "fence",
				__("forklift", 'carservice') => "forklift",
				__("garage", 'carservice') => "garage",
				__("gears", 'carservice') => "gears",
				__("globe", 'carservice') => "globe",
				__("hammer", 'carservice') => "hammer",
				__("helmet", 'carservice') => "helmet",
				__("house-1", 'carservice') => "house-1",
				__("house-2", 'carservice') => "house-2",
				__("key", 'carservice') => "key",
				__("documents", 'carservice') => "lab",
				__("lightbulb", 'carservice') => "lightbulb",
				__("list", 'carservice') => "list",
				__("location", 'carservice') => "location",
				__("lock", 'carservice') => "lock",
				__("mail", 'carservice') => "mail",
				__("measure", 'carservice') => "measure",
				__("megaphone", 'carservice') => "megaphone",
				__("payment", 'carservice') => "payment",
				__("pencil", 'carservice') => "pencil",
				__("percent", 'carservice') => "percent",
				__("person", 'carservice') => "person",
				__("phone", 'carservice') => "phone",
				__("photo", 'carservice') => "photo",
				__("picture", 'carservice') => "picture",
				__("plan", 'carservice') => "plan",
				__("poster", 'carservice') => "poster",
				__("quote", 'carservice') => "quote",
				__("roller", 'carservice') => "roller",
				__("ruler", 'carservice') => "ruler",
				__("scissors", 'carservice') => "scissors",
				__("screwdriver", 'carservice') => "screwdriver",
				__("shield", 'carservice') => "shield",
				__("shovel", 'carservice') => "shovel",
				__("speaker", 'carservice') => "speaker",
				__("stationery", 'carservice') => "stationery",
				__("team", 'carservice') => "team",
				__("tick", 'carservice') => "tick",
				__("trolley", 'carservice') => "trolley",
				__("trophy", 'carservice') => "trophy",
				__("trowel", 'carservice') => "trowel",
				__("truck", 'carservice') => "truck",
				__("video", 'carservice') => "video",
				__("wallet", 'carservice') => "wallet",
				__("watering-can", 'carservice') => "watering-can",
				__("wrench", 'carservice') => "wrench",
				__("wrenches", 'carservice') => "wrenches")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button label", 'carservice'),
			"param_name" => "button_label",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button url", 'carservice'),
			"param_name" => "button_url",
			"value" => ""
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Button target", 'carservice'),
			"param_name" => "button_target",
			"value" => array(__("Same window", 'carservice') => "", __("New window", 'carservice') => "_blank")
		),
		array(
			"type" => "dropdown",
			"class" => "",
			"heading" => __("Top margin", 'carservice'),
			"param_name" => "top_margin",
			"value" => array(__("None", 'carservice') => "none", __("Page (small)", 'carservice') => "page-margin-top", __("Section (large)", 'carservice') => "page-margin-top-section")
		)
	);
	
	wpb_map( array(
		"name" => __("Call To Action Box", 'carservice'),
		"base" => "call_to_action_box",
		"class" => "",
		"controls" => "full",
		"show_settings_on_create" => true,
		"icon" => "icon-wpb-layer-call-to-action-box",
		"category" => __('Carservice', 'carservice'),
		"params" => $params
	));
}
add_action("init", "cs_theme_call_to_action_box_vc_init");
?>

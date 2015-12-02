<?php
function cs_theme_announcement_box_shortcode($atts)
{
	extract(shortcode_atts(array(
		"header" => "",
		"header_expose" => "",
		"button_label" => "",
		"button_url" => "#",
		"icon" => "wallet",
		"button_color" => "",
		"button_custom_color" => "",
		"button_hover_color" => "",
		"button_hover_custom_color" => "",
		"button_text_color" => "",
		"button_hover_text_color" => "",
		"top_margin" => "page_margin_top_section"
	), $atts));
	
	$button_color = ($button_custom_color!="" ? $button_custom_color : $button_color);
	$button_hover_color = ($button_hover_custom_color!="" ? $button_hover_custom_color : $button_hover_color);
	
	$output = '<div class="announcement clearfix' . ($top_margin!="none" ? ' ' . esc_attr($top_margin) : '') . '">
					<div class="vc_row wpb_row vc_row-fluid">
						<div class="vc_col-sm-8 wpb_column vc_column_container">
							<div class="vertical-align">
								<div class="vertical-align-cell sl-small-' . esc_attr($icon) . '">
									' . ($header!="" ? '<h3>' . $header . '</h3>' : '')	. ($header_expose!="" ? '<p class="description">' . $header_expose . '</p>' : '') . '
								</div>
							</div>
						</div>';
	if($button_label!="")
		$output .= '<div class="vc_col-sm-4 wpb_column vc_column_container">
						<div class="vertical-align">
							<div class="vertical-align-cell">
								<a title="' . esc_attr($button_label) . '" href="' . esc_url($button_url) . '" class="more"><span>' . $button_label . '</span></a>
							</div>
						</div>
					</div>';
	$output .= '</div>
			</div>';
	return $output;
}
add_shortcode("announcement_box", "cs_theme_announcement_box_shortcode");
//visual composer
wpb_map( array(
	"name" => __("Announcement box", 'carservice'),
	"base" => "announcement_box",
	"class" => "",
	"controls" => "full",
	"show_settings_on_create" => true,
	"icon" => "icon-wpb-layer-announcement-box",
	"category" => __('Carservice', 'carservice'),
	"params" => array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Header", 'carservice'),
			"param_name" => "header",
			"value" => ""
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Header expose", 'carservice'),
			"param_name" => "header_expose",
			"value" => ""
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
			"heading" => __("Top margin", 'carservice'),
			"param_name" => "top_margin",
			"value" => array(__("Section (large)", 'carservice') => "page_margin_top_section", __("Page (small)", 'carservice') => "page_margin_top", __("None", 'carservice') => "none")
		)
	)
));
?>

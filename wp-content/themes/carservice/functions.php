<?php
$themename = "carservice";
/*function your_prefix_vcSetAsTheme() 
{
	vc_set_as_theme();
}
add_action('init', 'your_prefix_vcSetAsTheme');*/
if(function_exists('set_revslider_as_theme'))
{
	function carservice_set_revolution_as_theme() 
	{
		set_revslider_as_theme();
	}
	add_action('init', 'carservice_set_revolution_as_theme');
}

//plugins activator
require_once("plugins_activator.php");

//for is_plugin_active
include_once( ABSPATH . 'wp-admin/includes/plugin.php');

//wpb_remove("vc_row_inner");
if(function_exists("wpb_remove"))
{
	wpb_remove("vc_gmaps");
	wpb_remove("vc_tour");
	wpb_remove("vc_separator");
	wpb_remove("vc_text_separator");
}

//theme options
require_once(get_template_directory() . "/theme-options.php");

//custom meta box
require_once(get_template_directory() . "/meta-box.php");

if(function_exists("wpb_map"))
{
	//contact_form
	require_once(get_template_directory() . "/contact_form.php");
	//shortcodes
	require_once(get_template_directory() . "/shortcodes/shortcodes.php");
}

//comments
require_once(get_template_directory() . "/comments-functions.php");

//widgets
require_once(get_template_directory() . "/widgets/widget-contact-info.php");
require_once(get_template_directory() . "/widgets/widget-contact-details.php");
require_once(get_template_directory() . "/widgets/widget-contact-details-list.php");
require_once(get_template_directory() . "/widgets/widget-list.php");
require_once(get_template_directory() . "/widgets/widget-recent.php");
require_once(get_template_directory() . "/widgets/widget-social-icons.php");
require_once(get_template_directory() . "/widgets/widget-cart-icon.php");

function cs_theme_after_setup_theme()
{
	global $themename;
	//set default theme options
	if(!get_option($themename . "_installed"))
	{		
		$theme_options = array(
			"favicon_url" => get_template_directory_uri() . "/images/favicon.ico",
			"logo_url" => "",
			"logo_text" => "CARSERVICE",
			"footer_text" => '© Copyright 2015 <a target="_blank" title="' . esc_html__('Car Service Theme', 'carservice') . '" href="' . esc_url(__('http://themeforest.net/item/car-service-mechanic-auto-shop-wordpress-theme/12777824?ref=QuanticaLabs', 'carservice')) . '">Carservice Theme</a> by <a target="_blank" title="' . esc_html__('QuanticaLabs', 'carservice') . '" href="' . esc_url(__('http://quanticalabs.com', 'carservice')) . '">QuanticaLabs</a>',
			"sticky_menu" => 0,
			"responsive" => 1,
			"scroll_top" => 1,
			"layout" => 'fullwidth',
			"layout_style" => '',
			"layout_image_overlay" => '',
			"style_selector" => 0,
			"direction" => "default",
			"cf_admin_name" => get_option("admin_email"),
			"cf_admin_email" => get_option("admin_email"),
			"cf_smtp_host" => "",
			"cf_smtp_username" => "",
			"cf_smtp_password" => "",
			"cf_smtp_port" => "",
			"cf_smtp_secure" => "",
			"cf_email_subject" => "Carservice WP: Contact from WWW",
			"cf_template" => "<html>
	<head>
	</head>
	<body>
		<div><b>Name</b>: [name]</div>
		<div><b>E-mail</b>: [email]</div>
		<div><b>Phone</b>: [phone]</div>
		<div><b>Message</b>: [message]</div>
		[form_data]
	</body>
</html>",
			"site_background_color" => '',
			"main_color" => '',
			"header_top_sidebar" => '',
			"primary_font" => '',
			"primary_font_custom" => ''
		);
		add_option($themename . "_options", $theme_options);
		
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
		add_option($themename . "_installed", 1);
	}
	
	//Make theme available for translation
	//Translations can be filed in the /languages/ directory
	load_theme_textdomain('carservice', get_template_directory() . '/languages');
	
	//woocommerce
	add_theme_support("woocommerce");
	
	//menus
	add_theme_support("menus");
	
	//register thumbnails
	add_theme_support("post-thumbnails");
	
	add_image_size("blog-post-thumb", 870, 580, true);
	add_image_size("gallery-thumb", 570, 380, true);
	add_image_size("large-thumb", 960, 680, true);
	add_image_size("big-thumb", 480, 320, true);
	add_image_size("medium-thumb", 390, 260, true);
	add_image_size("small-thumb", 270, 180, true);
	add_image_size("tiny-thumb", 90, 90, true);
	
	//enable custom background
	add_theme_support("custom-background"); //3.4
	//add_custom_background(); //deprecated
	
	//enable feed links
	add_theme_support('automatic-feed-links');
	
	//title tag
	add_theme_support("title-tag");
	
	//register menus
	if(function_exists("register_nav_menu"))
	{
		register_nav_menu("main-menu", "Main Menu");
	}
	
	//custom theme filters
	add_filter('upload_mimes', 'cs_custom_upload_files');
	//using shortcodes in sidebar
	add_filter("widget_text", "do_shortcode");
	add_filter("image_size_names_choose", "cs_theme_image_sizes");
	add_filter('wp_list_categories','cs_category_count_span');
	add_filter('get_archives_link', 'cs_archive_count_span');
	add_filter('excerpt_more', 'cs_theme_excerpt_more', 99);
	add_filter('post_class', 'cs_check_image');
	add_filter('user_contactmethods', 'cs_contactmethods', 10, 1);
	add_filter('wp_title', 'cs_wp_title_filter', 10, 2);
	add_filter('site_transient_update_plugins', 'carservice_filter_update_vc_plugin', 10, 2);
	
	//custom theme woocommerce filters
	add_filter('woocommerce_pagination_args' , 'cs_woo_custom_override_pagination_args');
	add_filter('woocommerce_product_single_add_to_cart_text', 'cs_woo_custom_cart_button_text');
	add_filter('woocommerce_product_add_to_cart_text', 'cs_woo_custom_cart_button_text');
	add_filter('loop_shop_columns', 'cs_woo_custom_loop_columns');
	add_filter('woocommerce_product_description_heading', 'cs_woo_custom_product_description_heading');
	add_filter('woocommerce_checkout_fields' , 'cs_woo_custom_override_checkout_fields');
	add_filter('woocommerce_show_page_title', 'cs_woo_custom_show_page_title');
	add_filter('loop_shop_per_page', create_function( '$cols', 'return 6;' ), 20);
		
	//custom theme actions
	if(!function_exists('_wp_render_title_tag')) 
		add_action('wp_head', 'cs_theme_slug_render_title');
	
	//custom theme woocommerce actions
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
	//remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 10);
	add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	//add_action('woocommerce_after_shop_loop', 'woocommerce_result_count', 20);
	
	//phpMailer
	add_action('phpmailer_init', 'cs_phpmailer_init');
	
	//vc settings
	if(is_plugin_active("js_composer/js_composer.php") && function_exists("vc_set_default_editor_post_types"))
	{
		vc_set_default_editor_post_types(array(
			"page",
			"ql_galleries",
			"ql_services"
		));
	}
	//content width
	if(!isset($content_width)) 
		$content_width = 1050;
	
	//register sidebars
	if(function_exists("register_sidebar"))
	{
		//register custom sidebars
		$sidebars_list = get_posts(array( 
			'post_type' => $themename . '_sidebars',
			'posts_per_page' => '-1',
			'post_status' => 'publish',
			'orderby' => 'menu_order',
			'order' => 'ASC'
		));
		foreach($sidebars_list as $sidebar)
		{
			$before_widget = get_post_meta($sidebar->ID, "before_widget", true);
			$after_widget = get_post_meta($sidebar->ID, "after_widget", true);
			$before_title = get_post_meta($sidebar->ID, "before_title", true);
			$after_title = get_post_meta($sidebar->ID, "after_title", true);
			register_sidebar(array(
				"id" => $sidebar->post_name,
				"name" => $sidebar->post_title,
				'before_widget' => ($before_widget!='' && $before_widget!='empty' ? $before_widget : ''),
				'after_widget' => ($after_widget!='' && $after_widget!='empty' ? $after_widget : ''),
				'before_title' => ($before_title!='' && $before_title!='empty' ? $before_title : ''),
				'after_title' => ($after_title!='' && $after_title!='empty' ? $after_title : '')
			));
		}
	}
}
add_action("after_setup_theme", "cs_theme_after_setup_theme");
function cs_theme_switch_theme($theme_template)
{
	global $themename;
	delete_option($themename . "_installed");
}
add_action("switch_theme", "cs_theme_switch_theme");

/* --- phpMailer config --- */

function cs_phpmailer_init(PHPMailer $mail) 
{
	global $theme_options;
	$mail->CharSet='UTF-8';

	$smtp = $theme_options["cf_smtp_host"];
	if(!empty($smtp))
	{
		$mail->IsSMTP();
		$mail->SMTPAuth = true; 
		//$mail->SMTPDebug = 1;
		$mail->Host = $theme_options["cf_smtp_host"];
		$mail->Username = $theme_options["cf_smtp_username"];
		$mail->Password = $theme_options["cf_smtp_password"];
		if((int)$theme_options["cf_smtp_post"]>0)
			$mail->Port = (int)$theme_options["cf_smtp_port"];
		$mail->SMTPSecure = $theme_options["cf_smtp_secure"];
	}
}

 
function cs_custom_template_for_vc() 
{
    $data = array();
    $data['name'] = __('Single Post Template', 'carservice');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row top_margin="none" el_class="margin-top-70"][vc_column type="" top_margin="none" width="3/4"][single_post featured_image_size="default" show_post_title="1" show_post_featured_image="1" show_post_excerpt="0" show_post_categories="1" show_post_date="1" show_post_author="1" show_post_views="1" show_post_comments="1" show_leave_reply_button="1"][comments show_comments_form="1" show_comments_list="1" top_margin="page-margin-top"][/vc_column][vc_column type="cs-smart-column" top_margin="none" width="1/4"][call_to_action_box title="ONLINE APPOINTMENT" icon="percent" button_label="MAKE APPOINTMENT" button_url="#" top_margin="none"]Book your appointment now and get $5 discount.[/call_to_action_box][box_header title="LATEST POSTS" type="h6" bottom_border="1" top_margin="page-margin-top"][blog_small cs_pagination="0" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" show_post_title="1" show_post_date="1" top_margin="none" el_class="margin-top-30" show_post_views="0"][box_header title="MOST VIEWED" type="h6" bottom_border="1" top_margin="page-margin-top"][blog_small cs_pagination="0" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="views" order="DESC" show_post_title="1" show_post_date="0" top_margin="none" el_class="margin-top-30" show_post_views="1"][box_header title="TEXT WIDGET" type="h6" bottom_border="1" top_margin="page-margin-top"][vc_wp_text el_class="margin-top-24"]Here is a text widget settings ipsum lore tora dolor sit amet velum. Maecenas est velum, gravida <a href="#">vehicula dolor</a>[/vc_wp_text][vc_wp_categories options="" el_class="page-margin-top clearfix" title="CATEGORIES"][vc_wp_archives options="count" title="ARCHIVES" el_class="page-margin-top full-width clearfix"][vc_wp_tagcloud taxonomy="post_tag" title="TAGS" el_class="page-margin-top clearfix"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Blog Template', 'carservice');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row top_margin="none" el_class="margin-top-70"][vc_column type="" top_margin="none" width="3/4"][blog cs_pagination="1" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" show_post_title="1" show_post_excerpt="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_date="1" show_post_views="1" show_post_comments="1" is_search_results="0" top_margin="none" cs_pagination="1" show_post_tags="0"][/vc_column][vc_column type="cs-smart-column" top_margin="none" width="1/4"][call_to_action_box title="ONLINE APPOINTMENT" icon="percent" button_label="MAKE APPOINTMENT" button_url="#" top_margin="none"]Book your appointment now and get $5 discount.[/call_to_action_box][box_header title="LATEST POSTS" type="h6" bottom_border="1" top_margin="page-margin-top"][blog_small cs_pagination="0" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" show_post_title="1" show_post_date="1" top_margin="none" el_class="margin-top-30" show_post_views="0"][box_header title="MOST VIEWED" type="h6" bottom_border="1" top_margin="page-margin-top"][blog_small cs_pagination="0" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="views" order="DESC" show_post_title="1" show_post_date="0" top_margin="none" el_class="margin-top-30" show_post_views="1"][box_header title="TEXT WIDGET" type="h6" bottom_border="1" top_margin="page-margin-top"][vc_wp_text el_class="margin-top-24"]Here is a text widget settings ipsum lore tora dolor sit amet velum. Maecenas est velum, gravida <a href="#">vehicula dolor</a>[/vc_wp_text][vc_wp_categories options="" el_class="page-margin-top clearfix" title="CATEGORIES"][vc_wp_archives options="count" title="ARCHIVES" el_class="page-margin-top full-width clearfix"][vc_wp_tagcloud taxonomy="post_tag" title="TAGS" el_class="page-margin-top clearfix"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Search Page Template', 'carservice');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row type="" top_margin="none" el_class="margin-top-70"][vc_column type="" top_margin="none" width="3/4"][blog cs_pagination="1" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" show_post_title="1" show_post_excerpt="1" read_more="1" show_post_categories="1" show_post_author="1" show_post_date="1" date_format="renovate" show_post_views="1" show_post_comments="1" is_search_results="1" top_margin="none" cs_pagination="1" show_post_tags="0"][/vc_column][vc_column type="cs-smart-column" top_margin="none" width="1/4"][call_to_action_box title="ONLINE APPOINTMENT" icon="percent" button_label="MAKE APPOINTMENT" button_url="#" top_margin="none"]Book your appointment now and get $5 discount.[/call_to_action_box][box_header title="LATEST POSTS" type="h6" bottom_border="1" top_margin="page-margin-top"][blog_small cs_pagination="0" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="date" order="DESC" show_post_title="1" show_post_date="1" top_margin="none" el_class="margin-top-30" show_post_views="0"][box_header title="MOST VIEWED" type="h6" bottom_border="1" top_margin="page-margin-top"][blog_small cs_pagination="0" items_per_page="3" offset="0" featured_image_size="default" ids="-" category="-" author="-" order_by="views" order="DESC" show_post_title="1" show_post_date="0" top_margin="none" el_class="margin-top-30" show_post_views="1"][box_header title="TEXT WIDGET" type="h6" bottom_border="1" top_margin="page-margin-top"][vc_wp_text el_class="margin-top-24"]Here is a text widget settings ipsum lore tora dolor sit amet velum. Maecenas est velum, gravida <a href="#">vehicula dolor</a>[/vc_wp_text][vc_wp_categories options="" el_class="page-margin-top clearfix" title="CATEGORIES"][vc_wp_archives options="count" title="ARCHIVES" el_class="page-margin-top full-width clearfix"][vc_wp_tagcloud taxonomy="post_tag" title="TAGS" el_class="page-margin-top clearfix"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Gallery Template', 'carservice');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row top_margin="none" el_class="margin-top-70"][vc_column type="" top_margin="none" width="1/1"][single_gallery top_margin="none"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
	
	$data = array();
    $data['name'] = __('Single Service Template', 'carservice');
    $data['weight'] = 0;
    $data['image_path'] = preg_replace( '/\s/', '%20', get_template_directory_uri() . '/admin/images/visual_composer/layout.png');
    $data['custom_class'] = 'custom_template_for_vc_custom_template';
    $data['content'] = <<<CONTENT
        [vc_row el_class="margin-top-70"][vc_column width="1/4"][vc_wp_custommenu nav_menu="27" el_class="vertical-menu"][call_to_action_box title="ONLINE APPOINTMENT" icon="percent" button_label="MAKE APPOINTMENT" button_url="#" top_margin="page-margin-top" text=""]Book your appointment now and get $5 discount.[/call_to_action_box][box_header title="DOWNLOAD" type="h6" bottom_border="1" top_margin="page-margin-top"][vc_btn type="action" icon="arrow-circle-down" title="Download Brochure" url="#" extraclass="margin-top-30"][vc_btn type="action" icon="arrow-circle-down" title="Download Summary" url="#"][/vc_column][vc_column width="3/4"][single_service show_social_icons="1" show_twitter="1" show_facebook="1" show_linkedin="1" show_skype="1" show_googleplus="1" show_instagram="1"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates($data);
}
if(is_plugin_active("js_composer/js_composer.php") && function_exists("vc_set_default_editor_post_types"))
	add_action("vc_load_default_templates_action", "cs_custom_template_for_vc");

/* --- Theme Custom Filters & Actions Functions --- */
//add new mimes for upload dummy content files (code can be removed after dummy content import)
function cs_custom_upload_files($mimes) 
{
    $mimes = array_merge($mimes, array('xml' => 'application/xml'), array('json' => 'application/json'), array('zip' => 'application/zip'), array('gz' => 'application/x-gzip'), array('ico' => 'image/x-icon'));
    return $mimes;
}
function cs_theme_image_sizes($sizes)
{
	$addsizes = array(
		"blog-post-thumb" => __("Blog post thumbnail", 'carservice'),
		"gallery-thumb" => __("Gallery thumbnail", 'carservice'),
		"large-thumb" => __("Large thumbnail", 'carservice'),
		"big-thumb" => __("Big thumbnail", 'carservice'),
		"medium-thumb" => __("Medium thumbnail", 'carservice'),
		"small-thumb" => __("Small thumbnail", 'carservice'),
		"tiny-thumb" => __("Tiny thumbnail", 'carservice'),
	);
	$newsizes = array_merge($sizes, $addsizes);
	return $newsizes;
}
function cs_category_count_span($links) 
{
	$links = str_replace('</a> (', '<span>', $links);
	$links = str_replace(')', '</span></a>', $links);
	return $links;
}
function cs_archive_count_span($links) 
{
	$links = str_replace('</a>&nbsp;(', '<span>', $links);
	$links = str_replace(')', '</span></a>', $links);
	return $links;
}
//excerpt
function cs_theme_excerpt_more($more) 
{
	return '';
}
//sticky
function cs_check_image($class) 
{
	if(is_sticky())
		$class[] = 'sticky';
	return $class;
}
//user info
function cs_contactmethods($contactmethods) 
{
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['linkedin'] = 'Linkedin';
	$contactmethods['skype'] = 'Skype';
	$contactmethods['googleplus'] = 'Google Plus';
	$contactmethods['instagram'] = 'Instagram';
	return $contactmethods;
}
if(!function_exists('_wp_render_title_tag')) 
{
    function cs_theme_slug_render_title() 
	{
		echo '<title>'. wp_title('', false) . '</title>';
    }
}
function cs_wp_title_filter($title, $sep)
{
	//$title = get_bloginfo('name') . " | " . (is_home() || is_front_page() ? get_bloginfo('description') : $title);
	return $title;
}
function carservice_filter_update_vc_plugin($date) 
{
    if(!empty($date->checked["js_composer/js_composer.php"]))
        unset($date->checked["js_composer/js_composer.php"]);
    if(!empty($date->response["js_composer/js_composer.php"]))
        unset($date->response["js_composer/js_composer.php"]);
    return $date;
}

/* --- Theme WooCommerce Custom Filters Functions --- */
function cs_woo_custom_override_pagination_args($args) 
{
	$args['prev_text'] = __('&lsaquo;', 'carservice');
	$args['next_text'] = __('&rsaquo;', 'carservice');
	return $args;
}
function cs_woo_custom_cart_button_text() 
{
	return __('ADD TO CART', 'woocommerce');
}
if(!function_exists('loop_columns')) 
{
	function cs_woo_custom_loop_columns() 
	{
		return 3; // 3 products per row
	}
}
function cs_woo_custom_product_description_heading() 
{
    return '';
}
function cs_woo_custom_show_page_title()
{
	return false;
}
function cs_woo_custom_override_checkout_fields($fields) 
{
	$fields['billing']['billing_first_name']['placeholder'] = 'First Name';
	$fields['billing']['billing_last_name']['placeholder'] = 'Last Name';
	$fields['billing']['billing_company']['placeholder'] = 'Company Name';
	$fields['billing']['billing_email']['placeholder'] = 'Email Address';
	$fields['billing']['billing_phone']['placeholder'] = 'Phone';
	return $fields;
}

//admin functions
require_once(get_template_directory() . "/admin/functions.php");

//theme options
global $theme_options;
$theme_options = array(
	"favicon_url" => '',
	"logo_url" => '',
	"logo_text" => '',
	"footer_text" => '',
	"sticky_menu" => '',
	"responsive" => '',
	"scroll_top" => '',
	"style_selector" => '',
	"direction" => '',
	"cf_admin_name" => '',
	"cf_admin_email" => '',
	"cf_smtp_host" => '',
	"cf_smtp_username" => '',
	"cf_smtp_password" => '',
	"cf_smtp_port" => '',
	"cf_smtp_secure" => '',
	"cf_email_subject" => '',
	"cf_template" => '',
	"main_color" => '',
	"header_top_sidebar" => '',
	"primary_font" => '',
	"primary_font_custom" => ''
);
$theme_options = cs_theme_stripslashes_deep(array_merge($theme_options, (array)get_option($themename . "_options")));

function cs_theme_enqueue_scripts()
{
	global $themename;
	global $theme_options;
	//style
	if($theme_options["primary_font"]!="" && $theme_options["primary_font_custom"]=="")
		wp_enqueue_style("google-font-primary", "//fonts.googleapis.com/css?family=" . urlencode($theme_options["primary_font"]) . (!empty($theme_options["primary_font_subset"]) ? "&subset=" . implode(",", $theme_options["primary_font_subset"]) : ""));
	else if($theme_options["primary_font_custom"]=="")
		wp_enqueue_style("google-font-opensans", "//fonts.googleapis.com/css?family=Open+Sans:300,300italic,400,600,700,800&amp;subset=latin,latin-ext");
	wp_enqueue_style("reset", get_template_directory_uri() . "/style/reset.css");
	wp_enqueue_style("superfish", get_template_directory_uri() ."/style/superfish.css");
	wp_enqueue_style("prettyPhoto", get_template_directory_uri() ."/style/prettyPhoto.css");
	wp_enqueue_style("jquery-qtip", get_template_directory_uri() ."/style/jquery.qtip.css");
	wp_enqueue_style("odometer", get_template_directory_uri() ."/style/odometer-theme-default.css");
	wp_enqueue_style("animations", get_template_directory_uri() ."/style/animations.css");
	wp_enqueue_style("main-style", get_stylesheet_uri());
	if((int)$theme_options["responsive"])
		wp_enqueue_style("responsive", get_template_directory_uri() ."/style/responsive.css");
	else
		wp_enqueue_style("no-responsive", get_template_directory_uri() ."/style/no_responsive.css");

	if(is_plugin_active('woocommerce/woocommerce.php'))
	{
		wp_enqueue_style("woocommerce-custom", get_template_directory_uri() ."/woocommerce/style.css");
		if((int)$theme_options["responsive"])
			wp_enqueue_style("woocommerce-responsive", get_template_directory_uri() ."/woocommerce/responsive.css");
		else
			wp_dequeue_style("woocommerce-smallscreen");
		if(is_rtl())
			wp_enqueue_style("woocommerce-rtl", get_template_directory_uri() ."/woocommerce/rtl.css");
	}
	wp_enqueue_style("cs-streamline-small", get_template_directory_uri() ."/fonts/streamline-small/style.css");
	wp_enqueue_style("cs-template", get_template_directory_uri() ."/fonts/template/styles.css");
	wp_enqueue_style("cs-social", get_template_directory_uri() ."/fonts/social/styles.css");
	wp_enqueue_style("custom", get_template_directory_uri() ."/custom.css");
	//js
	wp_enqueue_script("jquery-ui-core", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-accordion", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-tabs", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-datepicker", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-selectmenu", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-slider", false, array("jquery"), false, true);
	wp_enqueue_script("jquery-ui-touch-punch", get_template_directory_uri() ."/js/jquery.ui.touch-punch.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-isotope", get_template_directory_uri() ."/js/jquery.isotope.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-ba-bqq", get_template_directory_uri() ."/js/jquery.ba-bbq.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-easing", get_template_directory_uri() ."/js/jquery.easing.1.3.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-carouFredSel", get_template_directory_uri() ."/js/jquery.carouFredSel-6.2.1-packed.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-touchSwipe", get_template_directory_uri() ."/js/jquery.touchSwipe.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-transit", get_template_directory_uri() ."/js/jquery.transit.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-hint", get_template_directory_uri() ."/js/jquery.hint.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-costCalculator", get_template_directory_uri() ."/js/jquery.costCalculator.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-parallax", get_template_directory_uri() ."/js/jquery.parallax.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-qtip", get_template_directory_uri() ."/js/jquery.qtip.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-block-ui", get_template_directory_uri() ."/js/jquery.blockUI.min.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-prettyPhoto", get_template_directory_uri() ."/js/jquery.prettyPhoto.js", array("jquery"), false, true);
	wp_enqueue_script("jquery-odometer", get_template_directory_uri() ."/js/odometer.min.js", array("jquery", "theme-main" ), false, true);
	wp_enqueue_script("google-maps-v3", "//maps.google.com/maps/api/js?sensor=false", false, array(), false, true);
	if(function_exists("is_customize_preview") && !is_customize_preview())
		wp_enqueue_script("theme-main", get_template_directory_uri() ."/js/main.js", array("jquery", "jquery-ui-core", "jquery-ui-accordion", "jquery-ui-tabs"), false, true);
	
	//ajaxurl
	$data["ajaxurl"] = admin_url("admin-ajax.php");
	//themename
	$data["themename"] = $themename;
	//home url
	$data["home_url"] = esc_url(get_home_url());
	//is_rtl
	$data["is_rtl"] = ((is_rtl() || $theme_options["direction"]=='rtl') && ((isset($_COOKIE["cs_direction"]) && $_COOKIE["cs_direction"]!="LTR") || !isset($_COOKIE["cs_direction"]))) || (isset($_COOKIE["cs_direction"]) && $_COOKIE["cs_direction"]=="RTL") ? 1 : 0;
	
	//pass data to javascript
	$params = array(
		'l10n_print_after' => 'config = ' . json_encode($data) . ';'
	);
	wp_localize_script("theme-main", "config", $params);
}
add_action("wp_enqueue_scripts", "cs_theme_enqueue_scripts");

//function to display number of posts
function getPostViews($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }
    return (int)$count;
}

//function to count views
function setPostViews($postID) 
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='')
	{
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, 1);
    }
	else
	{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function get_time_iso8601() 
{
	$offset = get_option('gmt_offset');
	$timezone = ($offset < 0 ? '-' : '+') . (abs($offset)<10 ? '0'.abs($offset) : abs($offset)) . '00' ;
	return get_the_time('Y-m-d\TH:i:s') . $timezone;					
}

function cs_theme_direction() 
{
	global $wp_locale, $theme_options;
	if(isset($theme_options['direction']) || (isset($_COOKIE["cs_direction"]) && ($_COOKIE["cs_direction"]=="LTR" || $_COOKIE["cs_direction"]=="RTL")))
	{
		if($theme_options['direction']=='default' && empty($_COOKIE["cs_direction"]))
			return;
		$wp_locale->text_direction = ($theme_options['direction']=='rtl' && ((isset($_COOKIE["cs_direction"]) && $_COOKIE["cs_direction"]!="LTR") || !isset($_COOKIE["cs_direction"])) || (isset($_COOKIE["cs_direction"]) && $_COOKIE["cs_direction"]=="RTL") ? 'rtl' : 'ltr');
	}
}
add_action("after_setup_theme", "cs_theme_direction");

//carservice get_font_subsets
function cs_ajax_get_font_subsets()
{
	if($_POST["font"]!="")
	{
		$subsets = '';
		$fontExplode = explode(":", $_POST["font"]);
		$subsets_array = cs_get_google_font_subset($fontExplode[0]);
		
		foreach($subsets_array as $subset)
			$subsets .= '<option value="' . esc_attr($subset) . '">' . $subset . '</option>';
		
		echo "cs_start" . $subsets . "cs_end";
	}
	exit();
}
add_action('wp_ajax_carservice_get_font_subsets', 'cs_ajax_get_font_subsets');

/**
 * Returns array of Google Fonts
 * @return array of Google Fonts
 */
function cs_get_google_fonts()
{
	//get google fonts
	$fontsArray = get_option("carservice_google_fonts");
	//update if option doesn't exist or it was modified more than 2 weeks ago
	if($fontsArray===FALSE || (time()-$fontsArray->last_update>2*7*24*60*60)) 
	{
		$google_api_url = 'http://quanticalabs.com/.tools/GoogleFont/font.txt';
		$fontsJson = wp_remote_retrieve_body(wp_remote_get($google_api_url, array('sslverify' => false)));
		$fontsArray = json_decode($fontsJson);
		$fontsArray->last_update = time();		
		update_option("carservice_google_fonts", $fontsArray);
	}
	return $fontsArray;
}

/**
 * Returns array of subsets for provided Google Font
 * @param type $font - Google font
 * @return array of subsets for provided Google Font
 */
function cs_get_google_font_subset($font)
{
	$subsets = array();
	//get google fonts
	$fontsArray = cs_get_google_fonts();		
	$fontsCount = count($fontsArray->items);
	for($i=0; $i<$fontsCount; $i++)
	{
		if($fontsArray->items[$i]->family==$font)
		{
			for($j=0, $max=count($fontsArray->items[$i]->subsets); $j<$max; $j++)
			{
				$subsets[] = $fontsArray->items[$i]->subsets[$j];
			}
			break;
		}
	}
	return $subsets;
}
?>
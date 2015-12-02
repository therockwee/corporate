<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php global $theme_options; ?>
	<head>
		<!--meta-->
		<meta charset="<?php esc_attr(bloginfo("charset")); ?>" />
		<meta name="generator" content="WordPress <?php esc_attr(bloginfo("version")); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.2" />
		<meta name="description" content="<?php esc_attr(bloginfo('description')); ?>" />
		<meta name="format-detection" content="telephone=no" />
		<!--style-->
		<link rel="alternate" type="application/rss+xml" title="<?php esc_html_e('RSS 2.0', 'carservice'); ?>" href="<?php esc_url(bloginfo("rss2_url")); ?>" />
		<link rel="pingback" href="<?php esc_url(bloginfo("pingback_url")); ?>" />
		<?php
		if(!function_exists('has_site_icon') || !has_site_icon())
		{
		?>
		<link rel="shortcut icon" href="<?php echo (empty($theme_options["favicon_url"]) ? esc_url(get_template_directory_uri() . "/images/favicon.ico") : esc_url($theme_options["favicon_url"])); ?>" />
		<?php
		}
		wp_head();
		?>
	</head>
	<?php
		$image_overlay = ((!isset($_COOKIE['cs_image_overlay']) && $theme_options['layout_image_overlay']=='overlay') || ((isset($_COOKIE['cs_image_overlay']) && $_COOKIE['cs_image_overlay']=='overlay') || (!isset($_COOKIE['cs_image_overlay']) && $theme_options['layout_image_overlay']=='')) ? ' overlay' : '');
		$layout_style_class = (isset($_COOKIE['cs_layout']) && $_COOKIE['cs_layout']=="boxed" ? (isset($_COOKIE['cs_layout_style']) && $_COOKIE['cs_layout_style']!="" ? $_COOKIE['cs_layout_style'] . $image_overlay : 'image-1' . $image_overlay) : (isset($theme_options['layout']) && $theme_options['layout']=="boxed" ? (isset($theme_options['layout_style']) && $theme_options['layout_style']!="" ? $theme_options['layout_style'] . (substr($theme_options['layout_style'], 0, 5)=="image" && isset($theme_options['layout_image_overlay']) && $theme_options['layout_image_overlay']!="0" ? $image_overlay : '') : 'image-1' . $image_overlay) : ''));
	?>
	<body <?php body_class(($layout_style_class!="color_preview" ? esc_attr($layout_style_class) : "")); ?>>
		<div class="site-container<?php echo (isset($_COOKIE['cs_layout']) ? ($_COOKIE['cs_layout']=="boxed" ? ' boxed' : '') : ($theme_options['layout']=="boxed" ? ' boxed' : '')); ?>">
			<?php
			if($theme_options["header_top_sidebar"]!="")
			{
			?>
			<div class="header-top-bar-container clearfix">
				<?php
				$sidebar = get_post($theme_options["header_top_sidebar"]);
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name)):
				?>
				<div class="header-top-bar">
					<?php
					dynamic_sidebar($sidebar->post_name);
					?>
				</div>
				<a href="#" class="header-toggle template-arrow-up"></a>
				<?php
				endif;
				?>
			</div>
			<?php
			}
			$menu_type = (isset($_COOKIE['cs_menu_type']) && $_COOKIE['cs_menu_type']!="" ? ' ' . $_COOKIE['cs_menu_type'] : ((int)$theme_options["sticky_menu"] ? ' sticky' : ''));
			?>
			<!-- Header -->
			<div class="header-container<?php echo !empty($menu_type) ? esc_attr($menu_type) : ''; ?>">
				<div class="vertical-align-table">
					<div class="header clearfix">
						<div class="logo vertical-align-cell">
							<h1><a href="<?php echo esc_url(get_home_url()); ?>" title="<?php esc_attr(bloginfo("name")); ?>">
							<?php if($theme_options["logo_url"]!=""): ?>
							<img src="<?php echo esc_url($theme_options["logo_url"]); ?>" alt="logo">
							<?php endif; ?>
							<?php if($theme_options["logo_text"]!=""): ?>
							<?php echo $theme_options["logo_text"]; ?>
							<?php 
							endif;
							?>
							</a></h1>
						</div>
						<?php
						//Get menu object
						$locations = get_nav_menu_locations();
						if(isset($locations["main-menu"]))
						{
							$main_menu_object = get_term($locations["main-menu"], "nav_menu");
							if(has_nav_menu("main-menu") && $main_menu_object->count>0) 
							{
								?>
								<a href="#" class="mobile-menu-switch vertical-align-cell">
									<span class="line"></span>
									<span class="line"></span>
									<span class="line"></span>
								</a>
								<div class="menu-container clearfix vertical-align-cell">
								<?php
								wp_nav_menu(array(
									"container" => "nav",
									"theme_location" => "main-menu",
									"menu_class" => "sf-menu"
								));
								?>
								</div>
								<div class="mobile-menu-container">
									<div class="mobile-menu-divider"></div>
									<?php
									wp_nav_menu(array(
										"container" => "nav",
										"theme_location" => "main-menu",
										"menu_class" => "mobile-menu"
									));
									?>
								</div>
								<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		<!-- /Header -->
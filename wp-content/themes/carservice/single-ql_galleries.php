<?php
/*
Template Name: Gallery
*/
get_header();
?>
<div class="theme-page padding-bottom-70">
	<div class="vc_row wpb_row vc_row-fluid gray full-width page-header vertical-align-table">
		<div class="vc_row wpb_row vc_inner vc_row-fluid full-width padding-top-bottom-50 vertical-align-cell">
			<div class="vc_row wpb_row vc_inner vc_row-fluid">
				<div class="page-header-left">
					<h1><?php echo strtoupper(get_the_title()); ?></h1>
				</div>
				<div class="page-header-right">
					<div class="bread-crumb-container">
						<label><?php _e("YOU ARE HERE:", 'carservice'); ?></label>
						<ul class="bread-crumb">
							<li>
								<a href="<?php echo esc_url(get_home_url()); ?>" title="<?php esc_attr_e('Home', 'carservice'); ?>">
									<?php _e('HOME', 'carservice'); ?>
								</a>
							</li>
							<li class="separator">
								&#47;
							</li>
							<li>
								<?php echo strtoupper(get_the_title()); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<?php
		/*get page with single post template set*/
		$post_template_page_array = get_pages(array(
			'post_type' => 'page',
			'post_status' => 'publish',
			//'number' => 1,
			'meta_key' => '_wp_page_template',
			'meta_value' => 'single-ql_galleries.php'
		));
		if(count($post_template_page_array))
		{
			$post_template_page = $post_template_page_array[0];
			if(count($post_template_page_array) && isset($post_template_page))
			{
				echo wpb_js_remove_wpautop(apply_filters('the_content', $post_template_page->post_content));
				global $post;
				$post = $post_template_page;
				setup_postdata($post);
			}
			else
				echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row top_margin="none" el_class="margin-top-70"][vc_column type="" top_margin="none" width="1/1"][single_gallery top_margin="none"][/vc_column][/vc_row]'));
		}
		else
		{
			if(function_exists("wpb_map"))
				echo wpb_js_remove_wpautop(apply_filters('the_content', '[vc_row top_margin="none" el_class="margin-top-70"][vc_column type="" top_margin="none" width="1/1"][single_gallery top_margin="none"][/vc_column][/vc_row]'));
		}
		?>
	</div>
</div>
<?php
get_footer();
?>
            <div class="vc_row wpb_row vc_row-fluid dark-gray full-width footer-row padding-top-30 padding-bottom-50">
				<?php global $theme_options;
				$sidebar_footer_top = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_top", true));
				if(isset($sidebar_footer_top) && !(int)get_post_meta($sidebar_footer_top->ID, "hidden", true) && is_active_sidebar($sidebar_footer_top->post_name))
				{
				?>
				<div class="vc_row wpb_row vc_row-fluid padding-bottom-30">
					<div class="vc_row wpb_row vc_inner vc_row-fluid">
						<?php
							dynamic_sidebar($sidebar_footer_top->post_name);
						?>
					</div>
				</div>
				<?php
				}
				$sidebar = get_post(get_post_meta(get_the_ID(), "page_sidebar_footer_bottom", true));
				if(isset($sidebar) && !(int)get_post_meta($sidebar->ID, "hidden", true) && is_active_sidebar($sidebar->post_name))
				{
				?>
				<div class="vc_row wpb_row vc_row-fluid footer-row<?php echo (isset($sidebar_footer_top) && !(int)get_post_meta($sidebar_footer_top->ID, "hidden", true) && is_active_sidebar($sidebar_footer_top->post_name) ? ' top-border page-padding-top' : ''); ?>">
					<div class="vc_row wpb_row vc_inner vc_row-fluid row-4-4">
						<?php
							dynamic_sidebar($sidebar->post_name);
						?>
					</div>
				</div>
				<?php
				}
				?>
			</div>
            <div class="vc_row wpb_row vc_row-fluid dark-black full-width footer-row padding-top-20 padding-bottom-10">
        	<div class="vc_row padding-bottom-30">
            <ul class="social-icons gray margin-top-26">
            	<li><a class="social-linkedin" href="#"></a></li>
                <li><a class="social-linkedin" href="#"></a></li>
                <li><a class="social-linkedin" href="#"></a></li>
                <li><a class="social-linkedin" href="#"></a></li>
                <li><a class="social-linkedin" href="#"></a></li>
                <li><a class="social-linkedin" href="#"></a></li>
            </ul>
         </div>
         </div>
			<?php
			if($theme_options["footer_text"]!=""): ?>
			<div class="vc_row wpb_row vc_row-fluid align-center padding-top-bottom-30">
				<span class="copyright">
				<?php echo do_shortcode($theme_options["footer_text"]); ?>
				</span>
			</div>
			<?php endif; ?>
		</div>
		<div class="background-overlay"></div>
		<?php if((int)$theme_options["scroll_top"]): ?>
		<a href="#top" class="scroll-top animated-element template-arrow-up" title="<?php esc_html_e("Scroll to top", 'carservice'); ?>"></a>
		<?php
		endif;
		if((int)$theme_options["style_selector"])
			require_once(get_template_directory() . "/style_selector/style_selector.php");
		$main_color = (isset($_COOKIE['cs_main_color']) ? $_COOKIE['cs_main_color'] : $theme_options['main_color']);
		if($theme_options["site_background_color"]!="" || $main_color!="" || $theme_options["primary_font_custom"]!="" || $theme_options["primary_font"]!="")
			require_once(get_template_directory() . "/custom_colors.php");
		wp_footer();
		?>
	</body>
</html>
<?php
get_header();
?>
<div class="theme-page padding-bottom-70">
	<div class="vc_row wpb_row vc_row-fluid gray full-width page-header vertical-align-table">
		<div class="vc_row wpb_row vc_inner vc_row-fluid full-width padding-top-bottom-50 vertical-align-cell">
			<div class="vc_row wpb_row vc_inner vc_row-fluid">
				<div class="page-header-left">
					<h1><?php the_title(); ?></h1>
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
								<?php the_title(); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix">
		<?php
		if(have_posts()) : while (have_posts()) : the_post();
			the_content();
			require_once(get_template_directory() . "/comments-form.php");	
			if(comments_open())
			{
			?>
				<div class="comments-list-container clearfix page-margin-top">
			<?php
			}
			comments_template();
			if(comments_open())
			{
			?>
				</div>
			<?php
			}
		endwhile; endif;
		?>
	</div>
</div>
<?php
get_footer(); 
?>
<?php
/**
 * The template part for displaying off-canvas area.
 *
 * @package Newsblock
 */
global $temperature;
if ( csco_offcanvas_exists() ) {

	$scheme = csco_color_scheme(
		get_theme_mod( 'color_header_background', '#0a0a0a' ),
		get_theme_mod( 'color_header_background_dark', '#1c1c1c' )
	);
	?>

	<div class="cs-site-overlay"></div>

	<div class="cs-offcanvas">
		<div class="csOffcanvas_inWrapper">
			
		
		<div class="cs-offcanvas__header" <?php echo wp_kses( $scheme, 'post' ); ?>>			
			<?php do_action( 'csco_offcanvas_header_start' ); ?>
			<nav class="cs-offcanvas__nav">
				<?php // csco_component( 'header_logo' ); ?>
				<div class="logoLeft_redCircle">
					<a href="https://webstories.link/preview/-MoUqg_KBF7nfAhKOCjs" target="_blank" class="logoLeft_redCircle">Recent Post</a>
				</div>
			<?php
				if(!empty($temperature)){
					?>
				<h6 class="headerTimeLeft"><?php echo getDateTime('','l jS F Y');?>
					<a class="Download_TPaper" href="#">
					<span class='langEndisMr'><?php echo __("عرض جريدة اليوم","sbs_author_blog"); ?></span>
					</a>
				</h6>
                    <h6 class="weatherHeaderLeft"><?php echo $temperature->temp_c; ?><span>°C</span> <img src="<?php echo $temperature->condition->icon; ?>" alt=""></h6>					
					<?php
				}
				?>
				<div class="headerRight">
					<a href="https://dev.albilad.site/ar/login/">
						<span class='langEndisMr'><?php echo __("تسجيل الدخول","sbs_author_blog"); ?></span>
					</a>
				</div>
				<span class="cs-offcanvas__toggle" role="button"><i class="cs-icon cs-icon-x"></i></span>
			</nav>

			<?php do_action( 'csco_offcanvas_header_end' ); ?>
	</div>
			
			
			
			
			
		<aside class="cs-offcanvas__sidebar">
			
			<div class="cs-offcanvas__inner cs-offcanvas__area cs-widget-area">
				<?php
				$locations = get_nav_menu_locations();

				// Get menu by location.
				if ( isset( $locations['primary'] ) || isset( $locations['mobile'] ) ) {

					if ( isset( $locations['primary'] ) ) {
						$location = $locations['primary'];
					}
					if ( isset( $locations['mobile'] ) ) {
						$location = $locations['mobile'];
					}

					the_widget( 'WP_Nav_Menu_Widget', array( 'nav_menu' => $location ), array(
						'before_widget' => '<div class="widget %s cs-d-lg-none">',
						'after_widget'  => '</div>',
					) );
				}
				?>

				<?php dynamic_sidebar( 'sidebar-offcanvas' ); ?>
			</div>
		</aside>
			
			
			<!-------------ADD  CUSTOM BETWEEN COMMENT------------->
			
			<!-------------ADD  CUSTOM BETWEEN COMMENT------------->
			
			</div>
	</div>
	<?php
}
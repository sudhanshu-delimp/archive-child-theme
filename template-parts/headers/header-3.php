<?php
/**
 * The template for displaying the header 3
 *
 * @package Newsblock
 */

$scheme = csco_color_scheme(
	get_theme_mod( 'color_topbar_background', '#FFFFFF' ),
	get_theme_mod( 'color_topbar_background_dark', '#1c1c1c' )
);
global $temperature;
?>

<div class="cs-topbar" <?php echo wp_kses( $scheme, 'post' ); ?>>

	
	
    <div class="cs-container">
		<div class="cs-header__inner cs-inner-large-height">
			<div class="cs-header__col cs-col-left">
				<div class="logoLeft_redCircle">
					<a class="logoLeft_redCircle" href="https://webstories.link/preview/-MoUqg_KBF7nfAhKOCjs" target="_blank">Recent Post</a>
				</div>
				<?php
				if(!empty($temperature)){
					?>
                    <h6 class="weatherHeaderLeft"><?php echo $temperature->temp_c; ?><span>°C</span> <img src="<?php echo $temperature->condition->icon; ?>" alt=""></h6>
					<h6 class="headerTimeLeft"><?php echo getDateTime('','l jS F Y');?><a class="Download_TPaper" href="#">
					<span class='langEndisMr'><?php echo __("عرض جريدة اليوم","sbs_author_blog"); ?></span></a>
					<?php
				}
				?>
				<?php csco_component( 'header_offcanvas_toggle' ); ?>
			</div>
			<div class="cs-header__col cs-col-center">
				<?php // csco_component( 'header_logo', true, array( 'variant' => 'large' ) ); ?>
				<a class="cs-header__logo" href="https://albiladdaily.com/"><img src="/wp-content/uploads/2021/11/Black.png" /></a>
			</div>
			<div class="cs-header__col cs-col-right">
				<div class="headerRight">
					<a href="https://dev.albilad.site/ar/login/"><span class='langEndisMr'><?php echo __("تسجيل الدخول","sbs_author_blog"); ?></span>
					</a> 
				</div>
				<?php csco_component( 'header_social_links' ); ?>
			</div>
		</div>
	</div>
</div>

<?php
$scheme = csco_color_scheme(
	get_theme_mod( 'color_header_background', '#0a0a0a' ),
	get_theme_mod( 'color_header_background_dark', '#1c1c1c' )
);
?>

<header class="cs-header cs-header-three" <?php echo wp_kses( $scheme, 'post' ); ?>>
	<div class="cs-container">
		<div class="cs-header__inner cs-header__inner-desktop">
			<div class="cs-header__col cs-col-left">
				<?php
					csco_component( 'wc_header_cart' );
					csco_component( 'header_search_toggle' );
					csco_component( 'header_scheme_toggle' );
				?>
				<span class="cs-separator"></span>
				<?php
					csco_component( 'header_logo', true, array( 'variant' => 'hide' ) );
				?>
			</div>
			<div class="cs-header__col cs-col-center">
				<?php
					csco_component( 'header_nav_menu' );
					csco_component( 'header_multi_column_widgets' );
				?>
			</div>
			<div class="cs-header__col cs-col-right">
				<?php
					csco_component( 'header_button' );
					csco_component( 'header_single_column_widgets' );
				?>
			</div>
		</div>

		<?php csco_site_nav_mobile(); ?>
	</div>

	<?php csco_site_search(); ?>
</header>
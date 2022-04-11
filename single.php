<?php
/**
 * The template for displaying all single posts and attachments.
 *
 * @package Newsblock
 */

get_header(); ?>
<!-- <button class="back-seach" onclick="history.go(-1);">رجوع إلى نتائج البحث</button> -->
<a href="<?php echo site_url();?>"  class="back-seach"><?php echo __( 'back to search results', 'newsblock'); ?></a>
<div id="primary" class="cs-content-area">

	<?php do_action( 'csco_main_before' ); ?>

	<?php
	while ( have_posts() ) :
		the_post();
		?>

		<?php do_action( 'csco_post_before' ); ?>

			<?php get_template_part( 'template-parts/content-singular' ); ?>

		<?php do_action( 'csco_post_after' ); ?>

	<?php endwhile; ?>

	<?php do_action( 'csco_main_after' ); ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

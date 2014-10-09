<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Tarvo
 * @since Tarvo 1.0
 */
get_header();
global $options;
global $defaultoptions;
?>

<div id="hero" class="hero" style="<?php if (function_exists('get_tarvo_hero_background_style')) get_tarvo_hero_background_style(); ?>">
	<div class="container">
		<div class="breadcrumbs">
			<?php if (function_exists('tarvo_breadcrumbs')) tarvo_breadcrumbs(); ?>
		</div>
		<?php if (is_home()) : ?>
			<h1 class="site-title"><?php bloginfo('name'); ?></h1>
			<h2 class="site-description"><?php bloginfo('description'); ?></h2>
		<?php endif; ?>
	</div>
</div>

<div class="container">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php if (have_posts()) : ?>

				<?php /* The loop */ ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php
					get_template_part('content', get_post_format());
					?>
				<?php endwhile; ?>

				<?php tarvo_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part('content', 'none'); ?>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div>
	<?php get_footer(); ?>
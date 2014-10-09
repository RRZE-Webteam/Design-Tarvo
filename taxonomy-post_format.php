<?php
/**
 * The template for displaying Post Format pages
 *
 * Used to display archive-type pages for posts with a post format.
 * If you'd like to further customize these Post Format views, you may create a
 * new template file for each specific one.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Tarvo
 * @since Tarvo 1.0
 */
get_header();
?>

<div id="hero" class="hero" style="<?php if (function_exists('get_tarvo_hero_background_style')) get_tarvo_hero_background_style(); ?>">
	<div class="container">
		<div class="breadcrumbs">
			<?php if (function_exists('tarvo_breadcrumbs')) tarvo_breadcrumbs(); ?>
		</div>
		<?php /* The loop */ ?>
		<?php while (have_posts()) : the_post(); ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf(__('%s Archives', 'tarvo'), '<span>' . get_post_format_string(get_post_format()) . '</span>'); ?></h1>
			</header><!-- .archive-header -->
		<?php endwhile; ?>
	</div>
</div>

<div class="container">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php if (have_posts()) : ?>

				<?php /* The loop */ ?>
				<?php while (have_posts()) : the_post(); ?>
					<?php get_template_part('content', get_post_format()); ?>
				<?php endwhile; ?>

				<?php tarvo_paging_nav(); ?>

			<?php else : ?>
				<?php get_template_part('content', 'none'); ?>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
</div><!-- .container -->

<?php get_footer(); ?>
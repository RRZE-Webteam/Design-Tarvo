<?php
/**
 * The template for displaying Author archive pages
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
		<?php if (have_posts()) : the_post(); ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php printf(__('All posts by %s', 'tarvo'), '<span class="vcard">' . get_the_author() . '</span>'); ?></h1>
			</header><!-- .archive-header -->
		<?php endif; ?>
	</div><!-- .container -->
</div>

<div class="container">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php if (have_posts()) : ?>

				<?php
				/*
				 * Queue the first post, that way we know what author
				 * we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();

				/*
				 * Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
				?>

				<?php if (get_the_author_meta('description')) : ?>
					<?php get_template_part('author-bio'); ?>
				<?php endif; ?>

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
</div><!-- .container-->
<?php get_footer(); ?>
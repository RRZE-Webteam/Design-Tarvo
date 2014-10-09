<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
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
		<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
		<?php endwhile; ?>
	</div>
</div>

<div class="container">
	<div id="primary" class="content-area">

		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<?php if (has_post_thumbnail() && !post_password_required()) : ?>
							<div class="entry-thumbnail">
								<?php the_post_thumbnail(); ?>
							</div>
						<?php endif; ?>


					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'tarvo') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link(__('Edit', 'tarvo'), '<span class="edit-link">', '</span>'); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->

	</div><!-- #primary -->

	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
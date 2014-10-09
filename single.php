<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Tarvo
 * @since Tarvo 1.0
 */

get_header(); ?>

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
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>
				<?php tarvo_post_nav(); ?>
				<?php comments_template(); ?>

			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>
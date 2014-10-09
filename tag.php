<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
	<?php if ( have_posts() ) : ?>
		<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'tarvo' ), single_tag_title( '', false ) ); ?></h1>

				<?php if ( tag_description() ) : // Show an optional tag description ?>
				<div class="archive-meta"><?php echo tag_description(); ?></div>
				<?php endif; ?>
			</header><!-- .archive-header -->
	<?php endif; ?>
	</div><!-- .container -->
</div>

<div class="container">
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php tarvo_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div><!-- .container -->
<?php get_footer(); ?>
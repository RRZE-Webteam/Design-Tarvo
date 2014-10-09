<?php
/**
 * The template for displaying 404 pages (Not Found)
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
		<header class="page-header">
			<h1 class="page-title"><?php _e('Not Found', 'tarvo'); ?></h1>
		</header>
	</div><!-- .container -->
</div>

<div class="container">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<div class="page-wrapper">
				<div class="page-content">
					<h2><?php _e('This is somewhat embarrassing, isn&rsquo;t it?', 'tarvo'); ?></h2>
					<p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'tarvo'); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- .container -->

<?php get_footer(); ?>
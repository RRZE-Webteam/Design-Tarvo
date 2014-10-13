<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Tarvo
 * @since Tarvo 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" content="width=device-width">
		<title><?php wp_title('|', true, 'right'); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
		<?php get_tarvo_opengraphinfo() ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">
			<header id="masthead" class="site-header clear" role="banner">
				<div class="container">
					<div class="top-search">
						<?php get_search_form(); ?>
					</div>

					<?php if (!is_home()) { ?>
						<a class="home-link clear" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
						<?php } ?>
						<?php if (get_header_image()) { ?>
							<img src="<?php header_image(); ?>" class="header-logo" alt ="<?php bloginfo('name'); ?>" title ="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
						<?php } else { ?>
							<h1 class="site-title"><?php bloginfo('name'); ?></h1>
							<h2 class="site-description"><?php bloginfo('description'); ?></h2>
						<?php } ?>
						<?php if (!is_home()) { ?>
						</a>
					<?php } ?>

					<div id="navbar" class="navbar">
						<nav id="site-navigation" class="navigation main-navigation" role="navigation">
							<button class="menu-toggle"><?php _e('Menu', 'tarvo'); ?></button>
							<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e('Skip to content', 'tarvo'); ?>"><?php _e('Skip to content', 'tarvo'); ?></a>
							<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu')); ?>
						</nav><!-- #site-navigation -->
					</div><!-- #navbar -->

				</div><!-- .container -->
			</header><!-- #masthead -->

			<div id="main" class="site-main">
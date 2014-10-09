<?php
/**
 * Tarvo functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Tarvo
 * @since Tarvo 1.0
 */
/*
 * Makes Tarvo available for translation.
 *
 * Translations can be added to the /languages/ directory.
 * If you're building a theme based on Tarvo, use a find and
 * replace to change 'tarvo' to the name of your theme in all
 * template files.
 */
load_theme_textdomain('tarvo', get_template_directory() . '/languages');


require( get_template_directory() . '/inc/constants.php' );
$options = get_option('tarvo_theme_options');

require( get_template_directory() . '/inc/theme-options.php' );


/*
 * Set up the content width value based on the theme's design.
 *
 * @see tarvo_content_width() for template-specific adjustments.
 */
if (!isset($content_width))
	$content_width = 604;

/**
 * Add support for a custom header image.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Tarvo only works in WordPress 3.6 or later.
 */
if (version_compare($GLOBALS['wp_version'], '3.6-alpha', '<'))
	require get_template_directory() . '/inc/back-compat.php';

/**
 * Tarvo setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Tarvo supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Tarvo 1.0
 */
function tarvo_setup() {

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style(array('css/editor-style.css', 'genericons/genericons.css'));

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support('html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	));

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support('post-formats', array(
		'audio', 'gallery', 'image', 'quote', 'video'
	));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu('primary', __('Navigation Menu', 'tarvo'));
	if (! is_blogs_fau_de()) {
		register_nav_menu('techmenu', __('Tech Menu', 'tarvo'));
	}
	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(300, 300);

	// This theme uses its own gallery styles.
	add_filter('use_default_gallery_style', '__return_false');
}

add_action('after_setup_theme', 'tarvo_setup');

/* function setoptions() {
  global $setoptions;
  global $setoptionsX;
  $setoptions = $setoptionsX;
  }

  add_action('init','setoptions'); */

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Tarvo 1.0
 */
function tarvo_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if (is_singular() && comments_open() && get_option('thread_comments'))
		wp_enqueue_script('comment-reply');

	// Adds Masonry to handle vertical alignment of footer widgets.
	if (is_active_sidebar('sidebar-1'))
		wp_enqueue_script('jquery-masonry');

	// Loads JavaScript file with functionality specific to Tarvo.
	wp_enqueue_script('tarvo-script', get_template_directory_uri() . '/js/functions.js', array('jquery'), '2014-06-08', true);

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style('genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.03');

	// Loads our main stylesheet.
	wp_enqueue_style('tarvo-style', get_stylesheet_uri(), array(), '2013-07-18');

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style('tarvo-ie', get_template_directory_uri() . '/css/ie.css', array('tarvo-style'), '2013-07-18');
	wp_style_add_data('tarvo-ie', 'conditional', 'lt IE 9');
}

add_action('wp_enqueue_scripts', 'tarvo_scripts_styles');

/**
 * Enqueue scripts and styles for the back end.
 *
 * @since Tarvo 1.0
 */
function tarvo_admin_style() {

	wp_register_style('themeadminstyle', get_template_directory_uri() . '/css/admin.css');
	wp_enqueue_style('themeadminstyle');
}

add_action('admin_enqueue_scripts', 'tarvo_admin_style');

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Tarvo 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function tarvo_wp_title($title, $sep) {
	global $paged, $page;

	if (is_feed())
		return $title;

	// Add the site name.
	$title .= get_bloginfo('name', 'display');

	// Add the site description for the home/front page.
	$site_description = get_bloginfo('description', 'display');
	if ($site_description && ( is_home() || is_front_page() ))
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if (( $paged >= 2 || $page >= 2 ) && !is_404())
		$title = "$title $sep " . sprintf(__('Page %s', 'tarvo'), max($paged, $page));

	return $title;
}

add_filter('wp_title', 'tarvo_wp_title', 10, 2);

/**
 * Register two widget areas.
 *
 * @since Tarvo 1.0
 */
function tarvo_widgets_init() {
	register_sidebar(array(
		'name' => __('Main Widget Area', 'tarvo'),
		'id' => 'sidebar-1',
		'description' => __('Appears in the footer section of the site.', 'tarvo'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __('Secondary Widget Area', 'tarvo'),
		'id' => 'sidebar-2',
		'description' => __('Appears on posts and pages in the sidebar.', 'tarvo'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}

add_action('widgets_init', 'tarvo_widgets_init');

if (!function_exists('tarvo_paging_nav')) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since Tarvo 1.0
	 */
	function tarvo_paging_nav() {
		global $wp_query;

		// Don't print empty markup if there's only one page.
		if ($wp_query->max_num_pages < 2)
			return;
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e('Posts navigation', 'tarvo'); ?></h1>
			<div class="nav-links">

				<?php if (get_next_posts_link()) : ?>
					<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'tarvo')); ?></div>
				<?php endif; ?>

				<?php if (get_previous_posts_link()) : ?>
					<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'tarvo')); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}

endif;

if (!function_exists('tarvo_post_nav')) :

	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @since Tarvo 1.0
	 */
	function tarvo_post_nav() {
		global $post;

		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post($post->post_parent) : get_adjacent_post(false, '', true);
		$next = get_adjacent_post(false, '', false);

		if (!$next && !$previous)
			return;
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e('Post navigation', 'tarvo'); ?></h1>
			<div class="nav-links">

				<?php previous_post_link('%link', _x('<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'tarvo')); ?>
				<?php next_post_link('%link', _x('%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'tarvo')); ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}

endif;

if (!function_exists('tarvo_entry_meta')) :

	/**
	 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own tarvo_entry_meta() to override in a child theme.
	 *
	 * @since Tarvo 1.0
	 */
	function tarvo_entry_meta() {
		global $options;

		if (is_sticky() && is_home() && !is_paged()) {
			echo '<span class="featured-post">'/* . __( 'Sticky', 'tarvo' ) */ . '</span>';
		}
		/* tarvo_entry_date(); */
		echo '<span class="date">' . get_the_date() . '</span>';

		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list(__(', ', 'tarvo'));
		if ($categories_list) {
			echo '<span class="categories-links">' . $categories_list . '</span>';
		}

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list('', __(', ', 'tarvo'));
		if ($tag_list && !is_home()) {
			echo '<span class="tags-links">' . $tag_list . '</span>';
		}

		// Post author
		if ($options['aktiv-autoren'] == 1):
			echo '<span class="author">';
			_e('written by ', 'tarvo');
			the_author_posts_link();
			echo '</span>';
		endif;

		//Edit link
		echo edit_post_link(__('Edit', 'tarvo'), '<span class="edit-link">', '</span>');

		// Social Media Share Icons
		if ('post' == get_post_type()) {
			tarvo_post_socialmedia_icons();
		}
	}

endif;

if (!function_exists('tarvo_entry_date')) :

	/**
	 * Print HTML with date information for current post.
	 *
	 * Create your own tarvo_entry_date() to override in a child theme.
	 *
	 * @since Tarvo 1.0
	 *
	 * @param boolean $echo (optional) Whether to echo the date. Default true.
	 * @return string The HTML-formatted post date.
	 */
	function tarvo_entry_date($echo = true) {
		if (has_post_format(array('chat', 'status')))
			$format_prefix = _x('%1$s on %2$s', '1: post format name. 2: date', 'tarvo');
		else
			$format_prefix = '%2$s';

		$date = sprintf('<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s%5$s%6$s</time></a></span>', esc_url(get_permalink()), esc_attr(sprintf(__('Permalink to %s', 'tarvo'), the_title_attribute('echo=0'))), esc_attr(get_the_date('c')), '<div class="entry-date-day">' . esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date('d'))) . '</div>', '<div class="entry-date-month-year"><span class="entry-date-month">' . esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date('M'))) . '</span><br>', '<span class="entry-date-year">' . esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date('Y'))) . '</span></div>'
		);

		if ($echo)
			echo $date;

		return $date;
	}

endif;

if (!function_exists('tarvo_the_attached_image')) :

	/**
	 * Print the attached image with a link to the next attached image.
	 *
	 * @since Tarvo 1.0
	 */
	function tarvo_the_attached_image() {
		/**
		 * Filter the image attachment size to use.
		 *
		 * @since Twenty thirteen 1.0
		 *
		 * @param array $size {
		 *     @type int The attachment height in pixels.
		 *     @type int The attachment width in pixels.
		 * }
		 */
		$attachment_size = apply_filters('tarvo_attachment_size', array(724, 724));
		$next_attachment_url = wp_get_attachment_url();
		$post = get_post();

		/*
		 * Grab the IDs of all the image attachments in a gallery so we can get the URL
		 * of the next adjacent image in a gallery, or the first image (if we're
		 * looking at the last image in a gallery), or, in a gallery of one, just the
		 * link to that image file.
		 */
		$attachment_ids = get_posts(array(
			'post_parent' => $post->post_parent,
			'fields' => 'ids',
			'numberposts' => -1,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'orderby' => 'menu_order ID'
		));

		// If there is more than 1 attachment in a gallery...
		if (count($attachment_ids) > 1) {
			foreach ($attachment_ids as $attachment_id) {
				if ($attachment_id == $post->ID) {
					$next_id = current($attachment_ids);
					break;
				}
			}

			// get the URL of the next image attachment...
			if ($next_id)
				$next_attachment_url = get_attachment_link($next_id);

			// or get the URL of the first image attachment.
			else
				$next_attachment_url = get_attachment_link(array_shift($attachment_ids));
		}

		printf('<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>', esc_url($next_attachment_url), the_title_attribute(array('echo' => false)), wp_get_attachment_image($post->ID, $attachment_size)
		);
	}

endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Tarvo 1.0
 *
 * @return string The Link format URL.
 */
function tarvo_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content($content);

	return ( $has_url ) ? $has_url : apply_filters('the_permalink', get_permalink());
}

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Tarvo 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function tarvo_body_class($classes) {
	if (!is_multi_author())
		$classes[] = 'single-author';

	if (is_active_sidebar('sidebar-2') && !is_attachment() && !is_404())
		$classes[] = 'sidebar';

	if (!get_option('show_avatars'))
		$classes[] = 'no-avatars';

	return $classes;
}

add_filter('body_class', 'tarvo_body_class');

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Tarvo 1.0
 */
function tarvo_content_width() {
	global $content_width;

	if (is_attachment())
		$content_width = 724;
	elseif (has_post_format('audio'))
		$content_width = 484;
}

add_action('template_redirect', 'tarvo_content_width');

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Tarvo 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function tarvo_customize_register($wp_customize) {
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
	$wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}

add_action('customize_register', 'tarvo_customize_register');

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JavaScript handlers to make the Customizer preview
 * reload changes asynchronously.
 *
 * @since Tarvo 1.0
 */
function tarvo_customize_preview_js() {
	wp_enqueue_script('tarvo-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array('customize-preview'), '20130226', true);
}

add_action('customize_preview_init', 'tarvo_customize_preview_js');

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
	global $post;
	return '<br><a class="more-link" href="' . get_permalink($post->ID) . '">' . __('Read more &rarr;', 'tarvo') . '</a>';
}

add_filter('excerpt_more', 'new_excerpt_more');


/*
 * Breadcrumb
 */

function tarvo_breadcrumbs() {
	global $options;
	$delimiter = '<span> / </span>';
	$home = $options['text-startseite']; // text for the 'Home' link
	$before = '<span class="current">'; // tag before the current crumb
	$after = '</span>'; // tag after the current crumb
	//echo '<span class="youarehere">' . __('You are here: ', 'tarvo') . '</span>&nbsp;&nbsp;';

	if (!is_home() && !is_front_page() || is_paged()) {
		global $post;
		$homeLink = home_url('/');
		echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
		if (is_category()) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0)
				echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
			echo $before . __('Category Archives ', 'tarvo') . '"' . single_cat_title('', false) . '"' . $after;
		} elseif (is_day()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif (is_month()) {
			echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif (is_year()) {
			echo $before . get_the_time('Y') . $after;
		} elseif (is_single() && !is_attachment()) {
			if (get_post_type() != 'post') {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category();
				$cat = $cat[0];
				echo is_wp_error($cat_parents = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ')) ? '' : $cat_parents;
				echo $before . get_the_title() . $after;
			}
		} elseif (!is_single() && !is_page() && !is_search() && get_post_type() != 'post' && !is_404()) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;
		} elseif (is_attachment()) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID);
			$cat = $cat[0];
			echo is_wp_error($cat_parents = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ')) ? '' : $cat_parents;
			echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif (is_page() && !$post->post_parent) {
			echo $before . get_the_title() . $after;
		} elseif (is_page() && $post->post_parent) {
			$parent_id = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb)
				echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif (is_search()) {
			echo $before . __('Search for ', 'tarvo') . '"' . get_search_query() . '"' . $after;
		} elseif (is_tag()) {
			echo $before . __('Tag Archives ', 'tarvo') . '"' . single_tag_title('', false) . '"' . $after;
		} elseif (is_author()) {
			global $author;
			$userdata = get_userdata($author);
			echo $before . __('Articles by ', 'tarvo') . $userdata->display_name . $after;
		} elseif (is_404()) {
			echo $before . '404' . $after;
		}
		/*
		  if ( get_query_var('paged') ) {
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
		  echo __('Page', 'tarvo') . ' ' . get_query_var('paged');
		  if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		  }
		 */
	} elseif (is_front_page()) {
		echo $before . $home . $after;
	} elseif (is_home()) {
		echo $before . get_the_title(get_option('page_for_posts')) . $after;
	}
}

if (!function_exists('get_tarvo_socialmediabuttons')) :

	/**
	 * Displays Social Media Icons on top of the Sidebar
	 */
	function get_tarvo_socialmediabuttons() {
		global $options;
		global $default_socialmedia_liste;
		$zeigeoption = $options['aktiv-socialmediabuttons'];

		if ($zeigeoption != 1) {
			return;
		}
		$result = '';
		$links = '';
		$result .= '<aside id="socialmedia_iconbar" class="widget clear">';
		$result .= '<ul class="socialmedia">';
		foreach ($default_socialmedia_liste as $entry => $listdata) {
			$value = '';
			$active = 0;
			if (isset($options['sm-list'][$entry]['content'])) {
				$value = $options['sm-list'][$entry]['content'];
			} else {
				$value = $default_socialmedia_liste[$entry]['content'];
			}
			if (isset($options['sm-list'][$entry]['active'])) {
				$active = $options['sm-list'][$entry]['active'];
			}
			if (($active == 1) && ($value)) {
				$links .= '<li><a class="icon_' . $entry . '" href="' . $value . '" title="' . $listdata['name'] . '">';
				$links .= $listdata['name'] . '</a></li>';
				$links .= "\n";
			}
		}

		if (strlen($links) > 1) {
			$result .= $links;
			$result .= '</ul>';
			$result .= '</aside>';
			echo $result;
		} else {
			return;
		}
	}

endif;

if (!function_exists('tarvo_post_socialmedia_icons')) :

	/**
	 * Display social media icons on every post
	 */
	function tarvo_post_socialmedia_icons() {
		global $post;
		global $options;
		global $defaultoptions;
		global $default_socialmedia_post_liste;
		$zeigeoption = $options['aktiv-post-sm-buttons'];

		if ($zeigeoption != 1) {
			return;
		}
		$links = '<div class="sm-box">';

		//Facebook link
		$fb_active = $options['aktiv-facebook-share'];
		$fb_title = $default_socialmedia_post_liste['facebook_share']['name'];
		$fb_text = $default_socialmedia_post_liste['facebook_share']['link_title'];
		$fb_link = $default_socialmedia_post_liste['facebook_share']['link'];
		if (isset($fb_active) && ($fb_active == 1)) {
			$links .= '<a class="sm-' . strtolower($fb_title) . '_share" href="' . $fb_link . get_permalink() . '" title="' . $fb_text . '" target="_blank">';
			$links .= '<span class="sm-icon"></span>';
			$links .= '<span class="sm-text screen-reader-text">';
			$links .= $fb_text . '</a>';
			$links .= "\n";
		}

		//Twitter link
		$tw_active = $options['aktiv-twitter-share'];
		$tw_title = $default_socialmedia_post_liste['twitter_share']['name'];
		$tw_text = $default_socialmedia_post_liste['twitter_share']['link_title'];
		$tw_link = $default_socialmedia_post_liste['twitter_share']['link'];
		$tw_via = (isset($options['via-twitter']) ? $options['via-twitter'] : $defaultoptions['via-twitter']);
		if (isset($tw_active) && ($tw_active == 1)) {
			$links .= '<a class="sm-' . strtolower($tw_title) . '_share" href=" ' . $tw_link . get_permalink();
			if (isset($tw_via) && ($tw_via != '')) {
				$links .= '&via=' . $tw_via;
			}
			$links .= '" title="' . $tw_text;
			$links .= '" target="_blank">';
			$links .= '<span class="sm-icon"></span>';
			$links .= '<span class="sm-text screen-reader-text">';
			$links .= $tw_text . '</a>';
			$links .= "\n";
		}

		$links.= '</div>';

		if (strlen($links) > 1) {
			echo $links;
		} else {
			return;
		}
	}

endif;



if (!function_exists('get_tarvo_sidebar_buttons')) :

	/**
	 * Displays Anmeldebutton
	 */
	function get_tarvo_sidebar_buttons() {
		global $options;
		if (isset($options['aktiv-buttons']) && ($options['aktiv-buttons'] == 1)) {
			echo '<aside id="buttons" class="widget">';
			if (isset($options['aktiv-anmeldebutton']) && ($options['aktiv-anmeldebutton'] == 1) && isset($options['url-anmeldebutton'])) {
				echo '<a href="' . $options['url-anmeldebutton'] . '" class="button breit ' . $options['color-anmeldebutton'] . '">' . $options['title-anmeldebutton'] . '</a>';
				echo "\n";
			}
			if (isset($options['aktiv-cfpbutton']) && ($options['aktiv-cfpbutton'] == 1) && isset($options['url-cfpbutton'])) {
				echo '<a href="' . $options['url-cfpbutton'] . '" class="button breit ' . $options['color-cfpbutton'] . '">' . $options['title-cfpbutton'] . '</a>';
				echo "\n";
			}
			echo '</aside>';
		}
	}

endif;


if (!function_exists('get_tarvo_hero_background_style')) :

	/**
	 * Returns Hero background image set in Theme Options
	 */
	function get_tarvo_hero_background_style() {
		global $options;
		global $defaultoptions;

		$hero_bg = $options['hero-background'];
		if (!isset($hero_bg)) {
			$hero_bg = 'blue';
		}
		$hero_bg_img = $defaultoptions['hero-background-options'][$hero_bg]['src'];
		$hero_bg_color = $defaultoptions['hero-background-options'][$hero_bg]['color'];

		echo 'background: url(' . $hero_bg_img . ') no-repeat center center ' . $hero_bg_color;
	}

endif;



if (!function_exists('get_tarvo_opengraphinfo')) :

	/**
	 * Assemble Open Graph Information for Facebook
	 */
	function get_tarvo_opengraphinfo() {
		global $post;

		$ogimage = '';
		if (is_single() && (has_post_thumbnail($post->ID))) :
			$ogimage = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		elseif (is_single() && !(has_post_thumbnail($post->ID))) :
			$ogimage = get_tarvo_first_image_url();
		elseif (get_header_image()):
			$ogimage = get_header_image();
		endif;

		$ogtitle = '';
		if (is_home()) :
			$ogtitle = get_bloginfo('title');
		elseif (is_single() || is_page()) :
			$ogtitle = get_the_title();
		elseif (is_category()) :
			$ogtitle = sprintf(__('Category Archives: %s', 'tarvo'), single_cat_title('', false));
		elseif (is_tag()) :
			$ogtitle = sprintf(__('Tag Archives: %s', 'tarvo'), single_tag_title('', false));
		endif;
		?>

		<meta property="og:title" content="<?php echo $ogtitle; ?>" />
		<meta property="og:description" content="<?php bloginfo('description'); ?>" />
		<meta property="og:image" content="<?php echo $ogimage; ?>" />
		<meta property="og:url" content="<?php echo 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]; ?>" />
		<meta property="og:locale" content="<?php echo str_replace("-", "_", get_bloginfo('language')); ?>" />
		<meta property="og:type" content="website" />

		<?php
	}

endif;



if (!function_exists('get_tarvo_first_image_url')) :

	/**
	 * Get First Picture URL from content
	 */
	function get_tarvo_first_image_url() {
		global $post;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if ($output != 0) {
			$first_img = $matches[1][0];
		} elseif (($output == 0) && (get_header_image())) {
			$first_img = get_header_image();
		}
		return $first_img;
	}

endif;


if (!function_exists('get_tarvo_thumbnailcode')) :
	/*
	 * Thumbnail-Reihenfolge in Options wählbar
	 */

	function get_tarvo_thumbnailcode($show_teaser_image = 0) {
		global $post;
		global $options;
		$thumbnailcode = '';
		$show_teaser_image = $options['teaser-image'];
		$firstpic = get_tarvo_firstpicture();
		$firstvideo = get_tarvo_firstvideo();
		$fallbackimg = '<img src="' . $options['src-teaser-thumbnail_default'] . '" alt="">';
		$output = '';

		/*
		 * 1 = Thumbnail (or: first picture, first video, fallback picture, nothing),
		 * 2 = First picture (or: thumbnail, first video, fallback picture, nothing),
		 * 3 = First video (or: thumbnail, first picture, fallback picture, nothing),
		 * 4 = First video (or: first picture, thumbnail, fallback picture, nothing),
		 * 5 = Nothing
		 */
		if ($show_teaser_image == 0) {
			$show_teaser_image = 1;
		}

		if (has_post_thumbnail()) {
			$thumbnailcode = get_the_post_thumbnail($post->ID, 'teaser-thumb');
		}

		if ($show_teaser_image == 1) {
			if ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
				$output = $thumbnailcode;
			} elseif ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
				$output = $firstpic;
			} elseif ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
				$output = $firstvideo;
			} elseif (isset($fallbackimg) && strlen(trim($fallbackimg)) > 10 && file_exists($fallbackimg)) {
				$output = $fallbackimg;
			} else {
				$output = '';
			}
		} elseif ($show_teaser_image == 2) {

			if ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
				$output = $firstpic;
			} elseif ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
				$output = $thumbnailcode;
			} elseif ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
				$output = $firstvideo;
			} elseif (isset($fallbackimg) && strlen(trim($fallbackimg)) > 10 && file_exists($fallbackimg)) {
				$output = $fallbackimg;
			} else {
				$output = '';
			}
		} elseif ($show_teaser_image == 3) {
			if ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
				$output = $firstvideo;
			} elseif ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
				$output = $thumbnailcode;
			} elseif ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
				$output = $firstpic;
			} elseif (isset($fallbackimg) && strlen(trim($fallbackimg)) > 10 && file_exists($fallbackimg)) {
				$output = $fallbackimg;
			} else {
				$output = '';
			}
		} elseif ($show_teaser_image == 4) {
			if ((isset($firstvideo)) && (strlen(trim($firstvideo)) > 10)) {
				$output = $firstvideo;
			} elseif ((isset($firstpic)) && (strlen(trim($firstpic)) > 10)) {
				$output = $firstpic;
			} elseif ((isset($thumbnailcode)) && (strlen(trim($thumbnailcode)) > 10)) {
				$output = $thumbnailcode;
			} elseif (isset($fallbackimg) && strlen(trim($fallbackimg)) > 10 && file_exists($fallbackimg)) {
				$output = $fallbackimg;
			} else {
				$output = '';
			}
		} else {
			$output = '';
		}

		echo $output;
	}

endif;

if (!function_exists('get_tarvo_firstpicture')) :
	/*
	 * Erstes Bild aus einem Artikel auslesen, wenn dies vorhanden ist
	 */

	function get_tarvo_firstpicture() {
		global $post;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$matches = array();
		preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if ((is_array($matches)) && (isset($matches[1]))) :
			return $matches[0];
		endif;
	}

endif;


if (!function_exists('get_tarvo_firstvideo')) :
	/*
	 * Erstes Video aus einem Artikel auslesen, wenn dies vorhanden ist
	 */

	function get_tarvo_firstvideo($width = 300, $height = 169, $nocookie = 1, $searchplain = 1) {
		global $post;
		ob_start();
		ob_end_clean();
		$matches = array();
		preg_match('/src="([^\'"]*www\.youtube[^\'"]+)/i', $post->post_content, $matches);
		if ((is_array($matches)) && (isset($matches[1]))) {
			$entry = $matches[1];
			if (!empty($entry)) {
				if ($nocookie == 1) {
					$entry = preg_replace('/youtube.com\/watch\?v=/', 'youtube-nocookie.com/embed/', $entry);
				}
				$htmlout = '<iframe width="' . $width . '" height="' . $height . '" src="' . $entry . '" allowfullscreen></iframe>';
				return $htmlout;
			}
		}
		// Schau noch nach YouTube-URLs die Plain im text sind. Hilfreich fuer
		// Installationen auf Multisite ohne iFrame-Unterstützung
		if ($searchplain == 1) {
			preg_match('/\[\b(https?:\/\/www\.youtube[\/a-z0-9\.\-\?=]+)/i', $post->post_content, $matches);
			if ((is_array($matches)) && (isset($matches[1]))) {
				$entry = $matches[1];
				if (!empty($entry)) {
					if ($nocookie == 1) {
						$entry = preg_replace('/youtube.com\/watch\?v=/', 'youtube-nocookie.com/embed/', $entry);
					}
					$htmlout = '<iframe width="' . $width . '" height="' . $height . '" src="' . $entry . '" allowfullscreen></iframe>';
					return $htmlout;
				}
			}
		}
		return;
	}

endif;

function tarvo_excerpt_length($length) {
	global $defaultoptions;
	return $defaultoptions['teaser_maxlength'];
}

add_filter('excerpt_length', 'tarvo_excerpt_length');

function tarvo_continue_reading_link() {
	return ' <span><a class="more-link" title="' . strip_tags(get_the_title()) . ': ' .  __('Read more', 'tarvo') . '" href="' . get_permalink() . '">' . '&nbsp;››' . '</a></span>';
}

function tarvo_auto_excerpt_more($more) {
	return ' &hellip;' . tarvo_continue_reading_link();
}

add_filter('excerpt_more', 'tarvo_auto_excerpt_more');

function tarvo_custom_excerpt_more($output) {
	if (has_excerpt() && !is_attachment()) {
		$output .= tarvo_continue_reading_link();
	}
	return $output;
}

add_filter('get_the_excerpt', 'tarvo_custom_excerpt_more');


if (!function_exists('get_tarvo_custom_excerpt')) :
	/*
	 * Erstellen des Extracts
	 */

	function get_tarvo_custom_excerpt($length = 0) {
		global $options;
		global $post;

		if (has_excerpt()) {
			return get_the_excerpt();
		} else {
			$excerpt = get_the_content();
			if (!isset($excerpt)) {
				$excerpt = __('No content', 'tarvo');
			}
		}
		if ($length == 0) {
			$length = $options['teaser_maxlength'];
		}

		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		if (mb_strlen($excerpt) < 5) {
			$excerpt = __('No content', 'tarvo');
		}
		// Youtube Shortcode entfernen
		$excerpt = preg_replace('/^\s*([^\'"]*www\.youtube[\/a-z0-9\.\-\?=]+)/i', '', $excerpt);

		if (mb_strlen($excerpt) > $length) {
			$the_str = mb_substr($excerpt, 0, $length);
			$the_str .= "&hellip;" . tarvo_continue_reading_link();
		} else {
			$the_str = $excerpt . tarvo_continue_reading_link();
		}
		$the_str = '<p>' . $the_str . '</p>';

		echo $the_str;
	}

endif;

function is_blogs_fau_de() {
	$http_host = filter_input(INPUT_SERVER, 'HTTP_HOST');
	if ($http_host == 'blogs.fau.de')
		return true;
	else
		return false;
}

function tarvo_tecmenu_fallback($args) {
	if (!is_blogs_fau_de())
		return '';
	global $current_blog, $post;
	if (is_multisite()) {
		$home = $current_blog->path;
	} else {
		$home = home_url();
	}
	if (is_page())
		$page = get_page($post->ID);
	// Siehe wp-includes/nav-menu-template.php
	extract($args);
	$links = array(
		'<li><a href="' . network_site_url('/', 'http') . '">' . $before . __('Blogs@FAU', 'tarvo') . $after . '</a></li>',
		'<li><a href="http://www.portal.uni-erlangen.de/forums/viewforum/94">' . $before . __('Forum', 'tarvo') . $after . '</a></li>',
		sprintf(is_front_page() && $home == '/hilfe/' ? '<li class="current-menu-item">%s</li>' : '<li>%s</li>', '<a href="' . network_site_url('/hilfe/', 'http') . '">' . $before . __('Hilfe', 'tarvo') . '</a>'),
		sprintf(!empty($page) && $page->post_name == 'kontakt' ? '<li class="current-menu-item">%s</li>' : '<li>%s</li>', '<a href="' . home_url('/kontakt/', 'http') . '">' . $before . __('Kontakt', 'tarvo') . $after . '</a>'),
		'<li><a href="' . network_site_url('/impressum/', 'http') . '">' . $before . __('Impressum', 'tarvo') . $after . '</a></li>',
		'<li><a href="' . network_site_url('/nutzungsbedingungen/', 'http') . '">' . $before . __('Nutzungsbedingungen', 'tarvo') . $after . '</a></li>'
	);
	$li = array();
	foreach ($links as $link) {
		if (false !== stripos($items_wrap, '<ul') or false !== stripos($items_wrap, '<ol'))
			$li[] = $link;
	}
	$li = implode(PHP_EOL, $li);
	$output = sprintf($items_wrap, $menu_id, $menu_class, $li);
	if (!empty($container))
		$output = "<$container class='$container_class' id='$container_id'>$output</$container>";
	if ($echo)
		echo $output;
	return $output;
}

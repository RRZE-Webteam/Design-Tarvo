<?php

/**
 * Tarvo  Constants
 *
 * */
$defaultoptions = array(
	'js-version' => '1.1',
	'default-color' => 'e6e6e6',
	'thumbnail-width' => 624,
	'thumbnail-height' => 9999,
	'content-width' => 625,
	'bannerlink-width' => 180,
	/* Max width for Logos and Images in Sidebar */
	'bannerlink-height' => 360,
	/* Max height for Logos and Images in Sidebar */
	'src_socialmediabuttons' => '/css/basemod_socialmediaicons.css',
	'aktiv-socialmediabuttons' => 1,
	'aktiv-post-sm-buttons' => 1,
	'aktiv-facebook-share' => 1,
	'aktiv-twitter-share' => 1,
	'aktiv-autoren' => 1,
	'aktiv-commentreplylink' => 0,
	'default_comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published. Required fields are marked red.', 'tarvo') . '<span class="required">*</span>' . '</p>',
	'disclaimer_post' => '',
	'login_errors' => 0,
	'src-breadcrumb-image' => get_template_directory_uri() . '/images/breadcrumbarrow.gif',
	'src-teaser-thumbnail_default' => '',
	'category-teaser' => 1,
	'teaser-thumbnail_width' => 300,
	'teaser-thumbnail_height' => 300,
	'teaser-thumbnail_crop' => 0,
	'src-teaser-thumbnail_default' => get_template_directory_uri() . '/images/default-teaserthumb.gif',
	'teaser-thumbnail_fallback' => 1,
	'teaser_maxlength' => 500,
	'teaser-image' => 0,
	/*
	 * 1 = Thumbnail (or: first picture, first video, fallback picture),
	 * 2 = First picture (or: thumbnail, first video, fallback picture),
	 * 3 = First video (or: thumbnail, first picture, fallback picture),
	 * 4 = First video (or: first picture, thumbnail, fallback picture),
	 * 5 = Nothing */
	'text-startseite' => __('Home', 'tarvo'),
	'default_text_title_home_backlink' => __('Back to Home Page', 'tarvo'),
	'default_footerlink_key' => 'Fakultaeten',
	'aktiv-buttons' => 1,
	'aktiv-anmeldebutton' => 1,
	'url-anmeldebutton' => '#',
	'title-anmeldebutton' => 'Button 1',
	'color-anmeldebutton' => 'blau',
	'aktiv-cfpbutton' => 1,
	'url-cfpbutton' => '#',
	'title-cfpbutton' => 'Button 2',
	'color-cfpbutton' => 'gruen',

	'via-twitter' => '',

	'hero-background' => 'blue',
	'hero-background-options' => array(
		'blue' => array(
			'src' => get_template_directory_uri() . '/images/hero-back-blue.jpg',
			'color' => '#003366'
		),
		'red' => array(
			'src' => get_template_directory_uri() . '/images/hero-back-red.jpg',
			'color' => '#81142b'
		),
		'turquoise' => array(
			'src' => get_template_directory_uri() . '/images/hero-back-turquoise.jpg',
			'color' => '#01b1c8'
		),
		'gold' => array(
			'src' => get_template_directory_uri() . '/images/hero-back-gold.jpg',
			'color' => '#ae8420'
		),
		'green' => array(
			'src' => get_template_directory_uri() . '/images/hero-back-green.jpg',
			'color' => '#019676'
		),
		'grey' => array(
			'src' => get_template_directory_uri() . '/images/hero-back-grey.jpg',
			'color' => '#a3acb3'
		)
	)
);

/*
 * Liste Hero Hintergründe
 */

$hero_backgrounds = array(
	'blue' => array(
		'src' => get_template_directory_uri() . '/images/hero-back-blue.jpg',
		'color' => '#003366'
	),
	'red' => array(
		'src' => get_template_directory_uri() . '/images/hero-back-gold.jpg',
		'color' => '#81142b'
	),
	'turqouise' => array(
		'src' => get_template_directory_uri() . '/images/hero-back-turquoise.jpg',
		'color' => '#01b1c8'
	),
	'gold' => array(
		'src' => get_template_directory_uri() . '/images/hero-back-gold.jpg',
		'color' => '#ae8420'
	),
	'green' => array(
		'src' => get_template_directory_uri() . '/images/hero-back-green.jpg',
		'color' => '#019676'
	),
	'grey' => array(
		'src' => get_template_directory_uri() . '/images/hero-back-grey.jpg',
		'color' => '#a3acb3'
	)
);

/*
 * Liste Social Media
 */
$default_socialmedia_post_liste = array(
	'facebook_share' => array(
		'name' => 'Facebook',
		'link' => 'https://www.facebook.com/sharer/sharer.php?u=',
		'link_title' => __('Share on Facebook', 'tarvo'),
	),
	'twitter_share' => array(
		'name' => 'Twitter',
		'link' => 'https://twitter.com/intent/tweet?&url=',
		'link_title' => __('Share on Twitter', 'tarvo'),
	),
);

/*
 * Liste Social Media
 */
$default_socialmedia_liste = array(
	'feed' => array(
		'name' => 'RSS Feed',
		'content' => get_bloginfo('rss2_url'),
		'active' => 1,
	),
	'delicious' => array(
		'name' => 'Delicious',
		'content' => '',
		'active' => 0,
	),
	'diaspora' => array(
		'name' => 'Diaspora',
		'content' => '',
		'active' => 0,
	),
	'facebook_follow' => array(
		'name' => 'Facebook',
		'content' => 'https://de-de.facebook.com/Uni.Erlangen.Nuernberg',
		'active' => 1,
	),
	'twitter_follow' => array(
		'name' => 'Twitter',
		'content' => 'https://twitter.com/UniFAU',
		'active' => 1,
	),
	'gplus' => array(
		'name' => 'Google Plus',
		'content' => '',
		'active' => 1,
	),
	'flattr' => array(
		'name' => 'Flattr',
		'content' => '',
		'active' => 0,
	),
	'flickr' => array(
		'name' => 'Flickr',
		'content' => '',
		'active' => 0,
	),
	'identica' => array(
		'name' => 'Identica',
		'content' => '',
		'active' => 0,
	),
	'itunes' => array(
		'name' => 'iTunes',
		'content' => '',
		'active' => 0,
	),
	'skype' => array(
		'name' => 'Skype',
		'content' => '',
		'active' => 0,
	),
	'youtube' => array(
		'name' => 'YouTube',
		'content' => '',
		'active' => 1,
	),
	'xing' => array(
		'name' => 'Xing',
		'content' => '',
		'active' => 0,
	),
	'tumblr' => array(
		'name' => 'Tumblr',
		'content' => '',
		'active' => 1,
	),
	'github' => array(
		'name' => 'GitHub',
		'content' => '',
		'active' => 0,
	),
	'appnet' => array(
		'name' => 'App.Net',
		'content' => '',
		'active' => 0,
	),
);


/*
 * Definition welche Konstanten als Optionen im Backend geaendert werden koennen
 */

$setoptions = array(
	'tarvo_theme_options' => array(
		'design' => array(
			'tabtitle' => __('Content Options', 'tarvo'),
			'fields' => array(
				'hero-background' => array(
					'type' => 'select',
					'title' => __('Hero Background', 'tarvo'),
					'label' => __('Hero (= header color stripe) background color', 'tarvo'),
					'default' => $defaultoptions['hero-background'],
					'liste' => array(
						'blue' => __('Blue', 'tarvo'),
						'gold' => __('Gold', 'tarvo'),
						'red' => __('Red', 'tarvo'),
						'turquoise' => __('Turquoise', 'tarvo'),
						'green' => __('Green', 'tarvo'),
						'grey' => __('Grey', 'tarvo')
					)
				),
				'text-startseite' => array(
					'type' => 'text',
					'title' => __('Home Page Name', 'tarvo'),
					'label' => __('Home page name for breadcrumb navigation', 'tarvo'),
					'default' => $defaultoptions['text-startseite'],
				),
				'aktiv-autoren' => array(
					'type' => 'bool',
					'title' => __('Show Authors', 'tarvo'),
					'label' => __('Show and link authors on post single view.', 'tarvo'),
					'default' => $defaultoptions['aktiv-autoren'],
				),
				'teaser' => array(
					'type' => 'section',
					'title' => __('Teaser', 'tarvo'),
				),
				'teaser_maxlength' => array(
					'type' => 'number',
					'title' => __('Teaser length', 'tarvo'),
					'label' => __('Maximum length for teasers on home page.', 'tarvo'),
					'default' => $defaultoptions['teaser_maxlength'],
					'parent' => 'teaser'
				),
				'teaser-image' => array(
					'type' => 'select',
					'title' => __('Teaser image', 'tarvo'),
					'label' => __('Show teaser image if availible and depending on post content.', 'tarvo'),
					'default' => $defaultoptions['teaser-image'],
					'liste' => array(
						1 => __("Featured image > first image > first video > default image", "tarvo"),
						2 => __("First image > featured image > first video > default image", "tarvo"),
						3 => __("First video > featured image > first image > default image", "tarvo"),
						4 => __("First video > first image > featured image > default image", "tarvo"),
						5 => __("No teaser image", "tarvo")),
					'parent' => 'teaser'
				),
				'buttons' => array(
					'type' => 'section',
					'title' => __('Buttons', 'tarvo'),
				),
				'aktiv-buttons' => array(
					'type' => 'bool',
					'title' => __('Show buttons', 'tarvo'),
					'label' => __('Show buttons on top of the sidebar', 'tarvo'),
					'default' => $defaultoptions['aktiv-buttons'],
					'parent' => 'buttons'
				),
				'aktiv-anmeldebutton' => array(
					'type' => 'bool',
					'title' => __('First button', 'tarvo'),
					'label' => __('Show', 'tarvo'),
					'default' => $defaultoptions['aktiv-anmeldebutton'],
					'parent' => 'buttons'
				),
				'url-anmeldebutton' => array(
					'type' => 'url',
					'title' => __('URL', 'tarvo'),
					'label' => __('Link', 'tarvo'),
					'default' => $defaultoptions['url-anmeldebutton'],
					'parent' => 'buttons'
				),
				'title-anmeldebutton' => array(
					'type' => 'text',
					'title' => __('Link title', 'tarvo'),
					'label' => __('Button Text', 'tarvo'),
					'default' => $defaultoptions['title-anmeldebutton'],
					'parent' => 'buttons'
				),
				'color-anmeldebutton' => array(
					'type' => 'select',
					'title' => __('Color', 'tarvo'),
					'label' => __('Button background color', 'tarvo'),
					'default' => $defaultoptions['color-anmeldebutton'],
					'liste' => array(
						'grau' => __("Grey", "tarvo"),
						'gelb' => __("Yellow", "tarvo"),
						'gruen' => __("Green", "tarvo"),
						'blau' => __("Blue", "tarvo"),
					),
					'parent' => 'buttons'
				),
				'aktiv-cfpbutton' => array(
					'type' => 'bool',
					'title' => __('Second button', 'tarvo'),
					'label' => __('Show', 'tarvo'),
					'default' => $defaultoptions['aktiv-cfpbutton'],
					'parent' => 'buttons'
				),
				'url-cfpbutton' => array(
					'type' => 'url',
					'title' => __('URL', 'tarvo'),
					'label' => __('Link', 'tarvo'),
					'default' => $defaultoptions['url-cfpbutton'],
					'parent' => 'buttons'
				),
				'title-cfpbutton' => array(
					'type' => 'text',
					'title' => __('Link title', 'tarvo'),
					'label' => __('Button Text', 'tarvo'),
					'default' => $defaultoptions['title-cfpbutton'],
					'parent' => 'buttons'
				),
				'color-cfpbutton' => array(
					'type' => 'select',
					'title' => __('Color', 'tarvo'),
					'label' => __('Button background color', 'tarvo'),
					'default' => $defaultoptions['color-cfpbutton'],
					'liste' => array(
						'grau' => __("Grey", "tarvo"),
						'gelb' => __("Yellow", "tarvo"),
						'gruen' => __("Green", "tarvo"),
						'blau' => __("Blue", "tarvo"),
					),
					'parent' => 'buttons'
				),
			)
		),
		'socialmedia' => array(
			'tabtitle' => __('Social Media', 'tarvo'),
			'fields' => array(
				'post-icons' => array(
					'type' => 'section',
					'title' => __('Share Icons in Post Header', 'tarvo'),
				),
				'aktiv-post-sm-buttons' => array(
					'type' => 'bool',
					'title' => __('Show', 'tarvo'),
					'label' => __('Show social media share buttons in the header of each post', 'tarvo'),
					'default' => $defaultoptions['aktiv-post-sm-buttons'],
					'parent' => 'post-icons',
				),
				'aktiv-facebook-share' => array(
					'type' => 'bool',
					'title' => __('Facebook', 'tarvo'),
					'label' => __('Show "Share on Facebook" icon.', 'tarvo'),
					'link' => 'https://www.facebook.com/sharer/sharer.php?u=',
					'link_title' => __('Share on Facebook', 'tarvo'),
					'default' => $defaultoptions['aktiv-facebook-share'],
					'parent' => 'post-icons',
				),
				'aktiv-twitter-share' => array(
					'type' => 'bool',
					'title' => __('Twitter', 'tarvo'),
					'label' => __('Show "Share on Twitter" icon.', 'tarvo'),
					'link' => 'https://twitter.com/intent/tweet?url=',
					'link_title' => __('Share on Twitter', 'tarvo'),
					'default' => $defaultoptions['aktiv-twitter-share'],
					'parent' => 'post-icons',
				),
				'via-twitter' => array(
					'type' => 'text',
					'title' => __('Twitter via (optional)', 'tarvo'),
					'label' => __('Your Twitter user name. Appears appended to Tweet text as via @username. The Twitter account may appear in a list of recommended accounts to follow.', 'tarvo'),
					'parent' => 'post-icons',
				),
				'site-icons' => array(
					'type' => 'section',
					'title' => __('Follow Icons in Sidebar', 'tarvo'),
				),
				'aktiv-socialmediabuttons' => array(
					'type' => 'bool',
					'title' => __('Show', 'tarvo'),
					'label' => __('Show social media link icons on top of the sidebar', 'tarvo'),
					'default' => $defaultoptions['aktiv-socialmediabuttons'],
					'parent' => 'site-icons',
				),
				'sm-list' => array(
					'type' => 'urlchecklist',
					'title' => __('Links', 'tarvo'),
					'liste' => $default_socialmedia_liste,
					'parent' => 'post-icons',
				),
			)
		),
	)
);
?>

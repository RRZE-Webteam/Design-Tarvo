<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Tarvo
 * @since Tarvo 1.0
 */
global $options;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if (!is_single()) : ?>
			<?php tarvo_post_socialmedia_icons(); ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<div class="date"><?php echo get_the_date(); ?></div>
		<?php endif; // is_single() ?>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail()
			|| ((null !==get_tarvo_firstpicture()) && (strlen(trim(get_tarvo_firstpicture()))>10))
			|| ((null !==get_tarvo_firstvideo()) && (strlen(trim(get_tarvo_firstvideo()))>10))
			&& !post_password_required()
			&& !is_attachment()
			&& ( 'image' != get_post_format() )
			&& ( 'gallery' != get_post_format() )) : ?>
		<div class="entry-thumbnail">
			<?php if (!is_single()) : ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php get_tarvo_thumbnailcode(); ?></a>
			<?php else : ?>
				<?php get_tarvo_thumbnailcode(); ?>
			<?php endif; // is_single() ?>
		</div>
	<?php endif; ?>

	<?php if (is_single()) : // Only display Full Content for Single View ?>

		<div class="entry-content">
			<?php the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'tarvo')); ?>
			<?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'tarvo') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
		</div><!-- .entry-content -->

	<?php else : ?>

		<div class="entry-summary">
			<?php get_tarvo_custom_excerpt(); ?>
			<?php //the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tarvo' ) ); ?>
			<?php /* the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tarvo' ) ); */ ?>
		</div><!-- .entry-summary -->

	<?php endif; ?>

	<?php if (is_single()) : ?>
	<footer class="entry-meta clear">
		<?php tarvo_entry_meta() ?>
		<?php if (comments_open()) : ?>
			<div class="comments-link">
			<?php comments_popup_link('<span class="leave-reply">' . __('Leave a comment', 'tarvo') . '</span>', __('One comment so far', 'tarvo'), __('View all % comments', 'tarvo')); ?>
			</div><!-- .comments-link -->
		<?php endif; // comments_open()   ?>
	</footer><!-- .entry-meta -->
	<?php endif; ?>
</article><!-- #post -->

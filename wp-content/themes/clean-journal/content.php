<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search
 *
 * @package Catch Themes
 * @subpackage Clean Journal
 * @since Clean Journal 0.1 
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="archive-post-wrap">
		<?php 
		/** 
		 * clean_journal_before_entry_container hook
		 *
		 * @hooked clean_journal_archive_content_image - 10
		 */
		do_action( 'clean_journal_before_entry_container' ); ?>


	</div><!-- .archive-post-wrap -->
</article><!-- #post -->
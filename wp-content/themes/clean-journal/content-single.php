<?php
/**
 * The template used for displaying post content in single.php
 *
 * @package Catch Themes
 * @subpackage Clean Journal
 * @since Clean Journal 0.1 
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	/** 
	 * clean_journal_before_post_container hook
	 *
	 * @hooked clean_journal_single_content_image - 10
	 */
	do_action( 'clean_journal_before_post_container' ); ?>

	

		<footer class="entry-footer">
			<?php clean_journal_tag_category(); ?>
		</footer><!-- .entry-footer -->
	</div><!-- .entry-container -->
</article><!-- #post-## -->
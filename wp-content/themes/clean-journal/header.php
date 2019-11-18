<?php
/**
 * The default template for displaying header
 *
 * @package Catch Themes
 * @subpackage Clean Journal
 * @since Clean Journal 0.1 
 */

	/** 
	 * clean_journal_doctype hook
	 *
	 * @hooked clean_journal_doctype -  10
	 *
	 */
	do_action( 'clean_journal_doctype' );?>

<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Cuprum|Noticia+Text" rel="stylesheet"> 
<?php	
	/** 
	 * clean_journal_before_wp_head hook
	 *
	 * @hooked clean_journal_head -  10
	 * 
	 */
	do_action( 'clean_journal_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php 
	/** 
     * clean_journal_before_header hook
     *
     */
    do_action( 'clean_journal_before' );
	
	/** 
	 * clean_journal_header hook
	 *
	 * @hooked clean_journal_page_start -  10
	 * @hooked clean_journal_header_top -  20
	 * @hooked clean_journal_header_start- 30
	 * @hooked clean_journal_mobile_header_nav_anchor - 40
	 * @hooked clean_journal_mobile_secondary_nav_anchor - 50
	 * @hooked clean_journal_site_branding - 60
	 * @hooked clean_journal_header_right - 70
	 * @hooked clean_journal_header_end - 100
	 * 
	 */
	do_action( 'clean_journal_header' );

	/** 
     * clean_journal_after_header hook
     *
     * @hooked clean_journal_primary_menu - 20
     * @hooked clean_journal_secondary_menu - 30
	 * @hooked clean_journal_featured_overall_image - 40
     * @hooked clean_journal_add_breadcrumb - 50
     */
	do_action( 'clean_journal_after_header' ); 

	/** 
	 * clean_journal_before_content hook
	 *
	 * @hooked clean_journal_slider - 10
	 * @hooked clean_journal_promotion_headline - 30
	 * @hooked clean_journal_featured_content_display (move featured content above homepage posts - default option) - 40
	 */
	do_action( 'clean_journal_before_content' );
	
	/** 
     * clean_journal_content hook
     *
     *  @hooked clean_journal_content_start - 10
     *  @hooked clean_journal_add_breadcrumb - 20
     *  @hooked clean_journal_content_sidebar_wrap_start - 40
     *
     */
	do_action( 'clean_journal_content' );	

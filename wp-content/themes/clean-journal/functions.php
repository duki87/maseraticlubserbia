<?php
/**
 * Functions and definitions
 *
 * Sets up the theme using core clean-journalcore and provides some helper functions using clean-journalcuston-functions.
 * Others are attached to action and
 * filter hooks in WordPress to change core functionality
 *
 * @package Catch Themes
 * @subpackage Clean Journal
 * @since Clean Journal 0.1
 */

//define theme version
if ( !defined( 'CLEAN_JOURNAL_THEME_VERSION' ) ) {
	$theme_data = wp_get_theme();

	define( 'CLEAN_JOURNAL_THEME_VERSION', $theme_data->get( 'Version' ) );
}

/**
 * Implement the core functions
 */
require trailingslashit( get_template_directory() ) . 'inc/clean-journal-core.php';

<?php
/** 
Plugin Name: month name translation benaceur
Plugin URI: http://benaceur-php.com/
Description: This plugin allows you to edit and translate the names of the months ...
Version: 2.1.2
Author: benaceur
Author URI: http://benaceur-php.com/
License: GPL2
*/

define("MNTB_BEN", "month-name-translation-benaceur");

// Add settings link on plugin page
   function month_name_translation_benaceur_action_links($links){
	  $links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.MNTB_BEN.'').'">'.__("Settings", MNTB_BEN).'</a>';
	  return $links;
   }
   add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'month_name_translation_benaceur_action_links');
// Add settings link on plugin page


   load_plugin_textdomain( MNTB_BEN, false, basename( dirname( __FILE__ ) ) . '/lang/' );

   add_action('admin_init', 'month_name_translation_benaceur_register_options');

  add_action('admin_menu', 'menu_month_name_translation_benaceur');
  function menu_month_name_translation_benaceur() {
  if (function_exists('add_options_page')) {
  $plugin_page_options = add_options_page( MNTB_BEN, 'Month-Translation-Benaceur', 'administrator', MNTB_BEN, 'month_name_translation_benaceur_page_options');
  }
}

  function month_name_translation_benaceur_register_options() { 
	
  register_setting('month_name_translation_benaceur_all_reset', 'mntb_all_reset');

  global $AllOptions_MNTB;	
  $AllOptions_MNTB = array(
  'month_name_translation_benaceur_enable_plug',
  'month_name_translation_benaceur_delete_all_options',
  'month_name_translation_benaceur_hide_icon_evol_plug',
  'month_name_translation_benaceur_dis_input',
  'month_name_translation_benaceur_jan',
  'month_name_translation_benaceur_t_jan',
  'month_name_translation_benaceur_Fev',
  'month_name_translation_benaceur_t_Fev',
  'month_name_translation_benaceur_Mar',
  'month_name_translation_benaceur_t_Mar',
  'month_name_translation_benaceur_Avr',
  'month_name_translation_benaceur_t_Avr',
  'month_name_translation_benaceur_Mai',
  'month_name_translation_benaceur_t_Mai',
  'monthnametranslationbenaceurjuin',
  'monthnametranslationbenaceurtjuin',
  'monthnametranslationbenaceurjuil',
  'monthnametranslationbenaceurtjuil',
  'month_name_translation_benaceur_Aou',
  'month_name_translation_benaceur_t_Aou',
  'month_name_translation_benaceur_Sep',
  'month_name_translation_benaceur_t_Sep',
  'month_name_translation_benaceur_Oct',
  'month_name_translation_benaceur_t_Oct',
  'month_name_translation_benaceur_Nov',
  'month_name_translation_benaceur_t_Nov',
  'month_name_translation_benaceur_Dec',
  'month_name_translation_benaceur_t_Dec',
  'month_name_translation_benaceur_enable_admin',
  'month_name_translation_benaceur_enable_front'
  );
  foreach($AllOptions_MNTB as $optionN_MNTB) {
    register_setting('month_name_translation_benaceur_group', $optionN_MNTB);
}	
	
	    if ($GLOBALS['pagenow'] == 'options-general.php' && $_GET['page'] == MNTB_BEN){
		wp_enqueue_style('month-name-translation-benaceur-admin',plugins_url('admin/style.css',__FILE__), false, '1.0.1' );
		wp_enqueue_style('farbtastic');	
	}
}

  function mntb_get_month_name($inp)
  {
  return date_i18n("F", strtotime(date_i18n("d-$inp-y")));
  }

// add_option
  add_action('admin_init', 'MNTB_group_options_default');
  function MNTB_group_options_default() {
   $month_jan = mntb_get_month_name('1');
   $month_feb = mntb_get_month_name('2');
   $month_mar = mntb_get_month_name('3');
   $month_apr = mntb_get_month_name('4');
   $month_may = mntb_get_month_name('5');
   $month_jun = mntb_get_month_name('6');
   $month_jul = mntb_get_month_name('7');
   $month_aug = mntb_get_month_name('8');
   $month_sep = mntb_get_month_name('9');
   $month_oct = mntb_get_month_name('10');
   $month_nov = mntb_get_month_name('11');
   $month_dec = mntb_get_month_name('12');
	
  add_option( 'month_name_translation_benaceur_enable_plug', '1');
  add_option( 'month_name_translation_benaceur_delete_all_options', 'no_delete_opt_mntb');
  add_option( 'month_name_translation_benaceur_dis_input', '0');
  add_option( 'month_name_translation_benaceur_jan', $month_jan);
  add_option( 'month_name_translation_benaceur_t_jan', $month_jan);
  add_option( 'month_name_translation_benaceur_Fev', $month_feb);
  add_option( 'month_name_translation_benaceur_t_Fev', $month_feb);
  add_option( 'month_name_translation_benaceur_Mar', $month_mar);
  add_option( 'month_name_translation_benaceur_t_Mar', $month_mar);
  add_option( 'month_name_translation_benaceur_Avr', $month_apr);
  add_option( 'month_name_translation_benaceur_t_Avr', $month_apr);
  add_option( 'month_name_translation_benaceur_Mai', $month_may);
  add_option( 'month_name_translation_benaceur_t_Mai', $month_may);
  add_option( 'monthnametranslationbenaceurjuin', $month_jun);
  add_option( 'monthnametranslationbenaceurtjuin', $month_jun);
  add_option( 'monthnametranslationbenaceurjuil', $month_jul);
  add_option( 'monthnametranslationbenaceurtjuil', $month_jul);
  add_option( 'month_name_translation_benaceur_Aou', $month_aug);
  add_option( 'month_name_translation_benaceur_t_Aou', $month_aug);
  add_option( 'month_name_translation_benaceur_Sep', $month_sep);
  add_option( 'month_name_translation_benaceur_t_Sep', $month_sep);
  add_option( 'month_name_translation_benaceur_Oct', $month_oct);
  add_option( 'month_name_translation_benaceur_t_Oct', $month_oct);
  add_option( 'month_name_translation_benaceur_Nov', $month_nov);
  add_option( 'month_name_translation_benaceur_t_Nov', $month_nov);
  add_option( 'month_name_translation_benaceur_Dec', $month_dec);
  add_option( 'month_name_translation_benaceur_t_Dec', $month_dec);
  }
// add_option

     register_activation_hook( __FILE__, 'MNTB_up_options' );
	 add_action('admin_init', 'mntb_activ_redir');
     function MNTB_up_options(){
     if ( version_compare( get_bloginfo('version'), '3.0', '<') )  { 
        deactivate_plugins( basename( __FILE__ ) ); 
			die(__('<strong>Core Control:</strong> Sorry, This plugin requires WordPress 3.0+', 'core-control'));
	 } else {
	    add_option('mntb_do_activation_redi', true);	 
	 }
	 }

     function mntb_activ_redir() {
     if (get_option('mntb_do_activation_redi', false)) {
        delete_option('mntb_do_activation_redi');
		if(!isset($_GET['activate-multi'])) {
        wp_redirect( admin_url( 'options-general.php?page='.MNTB_BEN.'' ) ) ;
		}
     }
     }
	 
    require_once ('includes/panel-var.php');	

   if ($mntb_enable_plug):

  if (is_admin() && !$mntb_enable_admin) {
  add_filter('date_i18n', 'modif_month_name_translation_benaceur');
  } else if (!is_admin() && !$mntb_enable_front) {
  add_filter('get_archives_link', 'modif_month_name_translation_benaceur');
  add_filter('date_i18n', 'modif_month_name_translation_benaceur');
  add_filter('wp_title', 'modif_month_name_translation_benaceur', 999);
  }

  function modif_month_name_translation_benaceur($list) {
    require ('includes/panel-var.php');	
    $patterns = array(
    '/'.$mntb_jan.'/', '/'.$mntb_Fev.'/', '/'.$mntb_Mar.'/', '/'.$mntb_Avr.'/', '/'.$mntb_Mai.'/', '/'.$mntb_Juin.'/',
    '/'.$mntb_Juil.'/', '/'.$mntb_Aou.'/', '/'.$mntb_Sep.'/', '/'.$mntb_Oct.'/',  '/'.$mntb_Nov.'/', '/'.$mntb_Dec.'/'
  );
  $replacements = array(
    $mntb_t_jan, $mntb_t_Fev, $mntb_t_Mar, $mntb_t_Avr, $mntb_t_Mai, $mntb_t_Juin, 
    $mntb_t_Juil, $mntb_t_Aou, $mntb_t_Sep, $mntb_t_Oct, $mntb_t_Nov, $mntb_t_Dec
  );    
  $list = preg_replace($patterns, $replacements, $list);
  return $list; 
  }

   endif; // enable_plug	

  if ($mntb_delete_all_options == 'delete_opt_mntb') :
  register_deactivation_hook( __FILE__, 'MNTB_plugin_deactivation' );
  function MNTB_plugin_deactivation() {
	
  global $AllOptions_MNTB;	
  foreach($AllOptions_MNTB as $optionN_MNTB) {
     delete_option($optionN_MNTB);
  }
     delete_option('mntb_all_reset');
  }
  endif; // endif month_name_translation_benaceur_delete_all_options

    add_action( 'admin_init', 'month_name_translation_benaceur_admin_notices' );
    function month_name_translation_benaceur_admin_notices() {
    $mntb_notice_admin = false;
	
    if ( $mntb_notice_admin && $GLOBALS['pagenow'] == 'options-general.php' && $_GET['page'] == MNTB_BEN ) {
    include ('includes/notices-mntb.php');
    }
	}

    require_once ('panel-page.php');
		
	if ($mntb_all_reset) :
  add_action('admin_init', 'mntb_all_reset_AllOptions');
  function mntb_all_reset_AllOptions() {
	  
  global $AllOptions_MNTB;	
  foreach($AllOptions_MNTB as $optionN_MNTB) {
     delete_option($optionN_MNTB);
  }

     delete_option('mntb_all_reset');
	 
      MNTB_group_options_default();
	  
  }  
  endif; // endif mntb_all_reset	

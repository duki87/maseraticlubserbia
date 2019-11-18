<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.greentreelabs.net
 * @since      1.0.0
 *
 * @package    Photoblocks
 * @subpackage Photoblocks/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Photoblocks
 * @subpackage Photoblocks/admin
 * @author     Diego Imbriani <diego@greentreelabs.net>
 */
class Photoblocks_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Gallery settings
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $settings    Gallery settings
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $settings ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings = $settings;
		$this->ajax_actions();
	}

	/**
	 * Retrieve available image sizes
	 *
	 * @since    1.0.0
	 */
	function list_image_sizes()
	{
		global  $_wp_additional_image_sizes ;
		$sizes = array();
		foreach ( get_intermediate_image_sizes() as $_size ) {
			
			if ( in_array( $_size, array(
				'thumbnail',
				'medium',
				'medium_large',
				'large'
			) ) ) {
				$sizes[$_size]['width'] = get_option( "{$_size}_size_w" );
				$sizes[$_size]['height'] = get_option( "{$_size}_size_h" );
				$sizes[$_size]['crop'] = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[$_size] ) ) {
				$sizes[$_size] = array(
					'width'  => $_wp_additional_image_sizes[$_size]['width'],
					'height' => $_wp_additional_image_sizes[$_size]['height'],
					'crop'   => $_wp_additional_image_sizes[$_size]['crop']
				);
			}
		
		}
		return $sizes;
	}

	

	/**
	 * Register ajax actions
	 *
	 * @since    1.0.0
	 */
	private function ajax_actions()
	{
		add_action('wp_ajax_pb_save_gallery', array($this, 'save_gallery'));
		add_action('wp_ajax_pb_load_gallery', array($this, 'load_gallery'));		
        add_action('wp_ajax_photoblocks_dismiss_review', array( $this, 'dismiss_review' ) );        
	}

	/**
	 * Save gallery
	 *
	 * @since    1.0.0
	 */
	public function save_gallery()
	{
		global $wpdb;

		//error_reporting(E_ALL);
		//ini_set('display_errors', 'On');

		if (check_admin_referer('photoblocks', 'photoblocks')) {
			header("Content-type: application/json");

			$id = intval($_POST['id']);
			unset($_POST['action']);
			unset($_POST['id']);
			unset($_POST['photoblocks']);

			$data = json_decode(stripslashes($_POST['settings']), true);
			
			foreach ($data as $k => $v)
			{
				if($k == 'blocks')
					continue;
				$data[$k] = $v;
			}
			
			$r = array('success' => false, 'id' => $id);

			$wpdb->show_errors = false;
			if ($id > 0)
			{
				$r['success'] = $wpdb->update($wpdb->photoblocks,
							  array('updated' => date("Y-m-d H:i:s"),
								  	'name' => $data['name'],
								  	'data' => stripslashes($_POST['settings']),
								  	'blocks' => stripslashes($_POST['blocks'])),
							  array('id' => $id));
			}
			else
			{
				$r['success'] = $wpdb->insert($wpdb->photoblocks,
							  array('created' => date('Y-m-d H:i:s'),
									'updated' => date('Y-m-d H:i:s'),
									'name' => $data['name'],
									'data' => json_encode($data),
									'blocks' => stripslashes($_POST['blocks'])));
				$r['id'] = $wpdb->insert_id;
			}

			if($r['id'] == 0)
			{
				$r['message'] = $wpdb->last_error;
			}

			header("Content-type: application/json");
			echo json_encode($r);
			wp_die();
		}
	}

	/**
	 * Init admin area
	 *
	 * @since    1.0.0
	 */
	public function init() {
		global $wpdb;

		if(isset($_GET['action']))
		{
			if($_GET['action'] == "delete" && isset($_GET['id']))
			{
				$wpdb->delete($wpdb->photoblocks, array("id" => $_GET['id']), array( '%d' ));
				wp_redirect( admin_url('admin.php?page=' . $this->plugin_name . '-dashboard' ), 301 );
        		exit();
			}
			if($_GET['action'] == "clone" && isset($_GET['id']))
			{
				$wpdb->get_results(
					$wpdb->prepare("insert into $wpdb->photoblocks (created, updated, name, data, blocks) select now(), now(), concat(name, ' (cloned)'), data, blocks from $wpdb->photoblocks where id=%d", $_GET['id'])
				);
				wp_redirect( admin_url('admin.php?page=' . $this->plugin_name . '-dashboard' ), 301 );
        		exit();
			}
		}	


		register_setting( $this->plugin_name, $this->plugin_name );
		//$this->check_default_values();
	}

	public function review()
	{
		global $wpdb;

		// Verify that we can do a check for reviews.
		$review = get_option( 'photoblocks_review' );
		$time = time();
		$load = false;
		$there_was_review = false;
	
		if ( !$review ) {
			$review = array(
				'time'      => $time,
				'dismissed' => false,
			);
			$load = true;
			$there_was_review = false;
		} else {
			// Check if it has been dismissed or not.
			if ( isset( $review['dismissed'] ) && !$review['dismissed'] && (isset( $review['time'] ) && $review['time'] + DAY_IN_SECONDS <= $time) ) {
				$load = true;
			}
		}
		
		// If we cannot load, return early.
		if ( !$load ) {
			return;
		}
		// Update the review option now.
		update_option( 'photoblocks_review', $review );
		// Run through optins on the site to see if any have been loaded for more than a week.
		$valid = false;
		$galleries = $wpdb->get_results('SELECT id, name from ' . $wpdb->photoblocks . ' order by id');
		if ( !$galleries ) {
			return;
		}
		$with_date = false;
		foreach ( $galleries as $gallery ) {
			
			if ( !isset( $gallery->created ) ) {
				continue;
			}
			$with_date = true;
			$data = $gallery->created;
			// Check the creation date of the local optin. It must be at least one week after.
			$created = ( isset( $data ) ? strtotime( $data ) + 7 * DAY_IN_SECONDS : false );
			if ( !$created ) {
				continue;
			}
			
			if ( $created <= $time ) {
				$valid = true;
				break;
			}
		
		}
		if ( !$with_date && count( $galleries ) > 0 && !$there_was_review ) {
			$valid = true;
		}
		// If we don't have a valid optin yet, return.
		if ( !$valid ) {
			return;
		}
		?>
		<div class="notice notice-info is-dismissible photoblocks-review-notice">
			<p><?php 
		_e( 'Hey, I noticed you created a photo gallery with PhotoBlocks - that’s awesome! Would you mind give it a 5-star rating on WordPress to help us spread the word and boost our motivation for new features?', 'photoblocks' );
		?>
</p>
			<p><strong><?php 
		_e( 'Diego Imbriani<br>Founder of GreenTreeLabs', 'photoblocks' );
		?>
</strong></p>
			<p>
				<a href="https://wordpress.org/support/plugin/photoblocks-grid-gallery/reviews/?filter=5#new-post" class="photoblocks-dismiss-review-notice photoblocks-review-out" target="_blank" rel="noopener"><?php 
		_e( 'Ok, you deserve it', 'photoblocks' );
		?>
</a><br>
				<a href="#" class="photoblocks-dismiss-review-notice" rel="noopener"><?php 
		_e( 'Nope, maybe later', 'photoblocks' );
		?>
</a><br>
				<a href="#" class="photoblocks-dismiss-review-notice" rel="noopener"><?php 
		_e( 'I already did', 'photoblocks' );
		?>
</a><br>
			</p>
		</div>
		<script type="text/javascript">
			jQuery(document).ready( function($) {
				$(document).on('click', '.photoblocks-dismiss-review-notice, .photoblocks-review-notice button', function( event ) {
					if ( ! $(this).hasClass('photoblocks-review-out') ) {
						event.preventDefault();
					}

					$.post( ajaxurl, {
						action: 'photoblocks_dismiss_review'
					});

					$('.photoblocks-review-notice').remove();
				});
			});
		</script>
		<?php 
	}
	
	public function dismiss_review()
	{
		$review = get_option( 'photoblocks_review' );
		if ( !$review ) {
			$review = array();
		}
		$review['time'] = time();
		$review['dismissed'] = true;
		update_option( 'photoblocks_review', $review );
		die;
	}
	
	public function admin_footer( $text )
	{
		global  $current_screen ;
		
		if ( !empty($current_screen->id) && strpos( $current_screen->id, 'ftg' ) !== false ) {
			$url = 'https://wordpress.org/support/plugin/photoblocks-grid-gallery/reviews/?filter=5#new-post';
			$text = sprintf( __( 'Please rate <strong>PhotoBlocks</strong> <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank">WordPress.org</a> to help us spread the word. Thank you from the PhotoBlocks team!', 'wpforms' ), $url, $url );
		}
		
		return $text;
	}

	/**
	 * Add menu
	 *
	 * @since    1.0.0
	 */
	public function menu() {

		$this->dashboard = add_menu_page('Dashboard - PhotoBlocks', 'PhotoBlocks', 'manage_options', $this->plugin_name . '-dashboard', array($this, 'dashboard'), plugin_dir_url( __FILE__ ) . '/icon.png');
		$this->add = add_submenu_page($this->plugin_name . '-dashboard', __('Add new') . " - PhotoBlocks", __('Add new'), 'manage_options', $this->plugin_name . '-edit', array($this, 'edit'));
	}

	/**
	 * Dashboard page
	 *
	 * @since    1.0.0
	 */
	public function dashboard()
	{
		global $wpdb;

		$_bag = array();
		$_bag["galleries"] = $wpdb->get_results('SELECT id, name from ' . $wpdb->photoblocks . ' order by id');
			

		include "partials/photoblocks-dashboard.php";
	}

	/**
	 * Add new gallery page
	 *
	 * @since    1.0.0
	 */
	public function edit()
	{
		include "partials/photoblocks-edit.php";
	}

	public function load_gallery()
	{
		global $wpdb;
	
		$data = null;

		if(isset($_POST['id']) && ! empty($_POST['id'])) {
			$data = $wpdb->get_row(
						$wpdb->prepare('SELECT * FROM ' . $wpdb->photoblocks . ' WHERE id=%d', intval($_POST['id'])),
							ARRAY_A
					);
			$data["blocks"] = json_decode($data["blocks"], true);

			if(! photob_fs()->is_plan_or_trial("ultimate"))
			{
				foreach($data["blocks"] as &$blocks)
				{
					if(isset($blocks["blocks"]) && is_array($blocks["blocks"]))
					{
						foreach($blocks["blocks"] as &$block)
						{
							if($block["type"] == "text")
								$block["type"] = "empty";
						}
					}
				}
			}

			$values = array_merge($this->settings->default_values(), json_decode($data["data"], true));
			$data["data"] = $values;
		} else {

			$data = array(
				"data" => $this->settings->default_values(),
				"blocks" => array()
			);
		}

		header("Content-type: application/json");
		echo json_encode($data);
		wp_die();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'minicolor', plugin_dir_url( __FILE__ ) . 'css/jquery.minicolors.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/photoblocks-admin.css', array('minicolor'), $this->version, 'all' );		
	}

	/**
	 * Add body classes
	 *
	 * @since    1.0.0
	 */
	public function body_class($classes) {

		if( isset( $_GET['page'] ) && $_GET['page'] == $this->plugin_name . '-edit' ) {
            $classes = "$classes photoblocks-app";
        }

        return $classes;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if (function_exists('wp_enqueue_media')) {
            wp_enqueue_media();
        }
		wp_enqueue_script('jquery');
        wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		
		wp_enqueue_script( 'minicolors', plugin_dir_url( __FILE__ ) . 'js/jquery.minicolors.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-toast', plugin_dir_url( __FILE__ ) . 'js/photoblocks.toast.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-map', plugin_dir_url( __FILE__ ) . '../public/js/photoblocks.map.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-grid', plugin_dir_url( __FILE__ ) . 'js/photoblocks.grid.js', array( 'jquery', 'photoblocks-map' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/photoblocks.admin.js', array( 'jquery', 'minicolors', $this->plugin_name . '-grid' ), $this->version, false );

	}

}

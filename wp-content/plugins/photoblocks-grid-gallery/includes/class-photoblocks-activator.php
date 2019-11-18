<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.greentreelabs.net
 * @since      1.0.0
 *
 * @package    Photoblocks
 * @subpackage Photoblocks/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Photoblocks
 * @subpackage Photoblocks/includes
 * @author     Diego Imbriani - GreenTreeLabs <diego@greentreelabs.net>
 */
class Photoblocks_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		global $photoblocks_db_version;

		$table_name = $wpdb->prefix . 'photoblocks';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		data text NULL,
		blocks text NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'photoblocks_db_version', $photoblocks_db_version );
	}

}

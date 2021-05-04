<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/Pasquill
 * @since      1.0.0
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/includes
 * @author     Pasquill <pasquill.x@gmail.com>
 */
class Products_Collector_For_Blog_Activator {

	/**
	 * Create table for products.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

        $table_name = $wpdb->prefix . 'pcfb_products_collector';

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			date_modified datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			title tinytext NOT NULL,
			image_url varchar(255) DEFAULT NULL,
			price_html longtext DEFAULT NULL,
			on_sale boolean DEFAULT 0,
			permalink varchar(255) DEFAULT '' NOT NULL,
			update_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			PRIMARY KEY  (id)
		  ) $charset_collate;";
		  
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		add_option( 'pcfb_db_version', '1.0' );
	}

}

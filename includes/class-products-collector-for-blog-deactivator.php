<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/Pasquill
 * @since      1.0.0
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/includes
 * @author     Pasquill <pasquill.x@gmail.com>
 */
class Products_Collector_For_Blog_Deactivator {

	/**
	 * Drop table for products.
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		
		$table_name = $wpdb->prefix . 'pcfb_products_collector';

		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query($sql);

		delete_option( 'pcfb_db_version' );
	}

}

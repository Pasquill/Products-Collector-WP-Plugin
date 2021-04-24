<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/Pasquill
 * @since      1.0.0
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/includes
 * @author     Pasquill <pasquill.x@gmail.com>
 */
class Products_Collector_For_Blog_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'products-collector-for-blog',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

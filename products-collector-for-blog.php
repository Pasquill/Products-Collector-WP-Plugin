<?php

/**
 * @link              https://github.com/Pasquill
 * @since             1.0.0
 * @package           Products_Collector_For_Blog
 *
 * @wordpress-plugin
 * Plugin Name:       Products Collector for Blog
 * Plugin URI:        https://github.com/Pasquill/products-collector-for-blog
 * Description:       Connect your blog with your woocommerce-driven shop via woocommerce rest api.
 * Version:           1.0.0
 * Author:            Pasquill
 * Author URI:        https://github.com/Pasquill
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       products-collector-for-blog
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRODUCTS_COLLECTOR_FOR_BLOG_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-products-collector-for-blog-activator.php
 */
function activate_products_collector_for_blog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-products-collector-for-blog-activator.php';
	Products_Collector_For_Blog_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-products-collector-for-blog-deactivator.php
 */
function deactivate_products_collector_for_blog() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-products-collector-for-blog-deactivator.php';
	Products_Collector_For_Blog_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_products_collector_for_blog' );
register_deactivation_hook( __FILE__, 'deactivate_products_collector_for_blog' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-products-collector-for-blog.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_products_collector_for_blog() {

	$plugin = new Products_Collector_For_Blog();
	$plugin->run();

}
run_products_collector_for_blog();

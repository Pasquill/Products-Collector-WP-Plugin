<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/Pasquill
 * @since      1.0.0
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/public
 * @author     Pasquill <pasquill.x@gmail.com>
 */
class Products_Collector_For_Blog_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/products-collector-for-blog-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/products-collector-for-blog-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Shortcodes.
	 *
	 * @since    1.0.0
	 */
	public function register_shortcodes() {

		add_shortcode( 'pcfb_product', array( $this, 'get_product_for_shortcode') );

	}

	/**
	 * Get Product for the shortcode.
	 *
	 * @since    1.0.0
	 */
	public function get_product_for_shortcode( $atts = array() ) {
		global $wpdb;

		$args = array();

		foreach ($atts as $key => $value) {

			switch ($key) {
				case 'id':
					$args[] = 'id = ' . $value;
					break;
				
				// case 'category': // tbd
				// 	$args[] = 'category = ' . $value;
				// 	break;

				default:
					break;
			}

		}

		if( count( $args ) != 0 ) {
			$condition = 'WHERE (' . implode( ' AND ', $args ) . ')';
		} else {
			$condition = 'ORDER BY RAND()';
		}

		$product = $wpdb->get_results("
			SELECT title, image_url, price_html, on_sale, permalink FROM {$wpdb->prefix}pcfb_products_collector
			{$condition}
			LIMIT 1
		");

		$html_sale_badge = ( $product[0]->on_sale ) ? '<span class="onsale">Sale!</span>' : '';
		$html_image = file_get_contents( plugin_dir_path( __FILE__ ) . 'assets/image-not-found.svg', false ); // tbd
		$html_price = html_entity_decode( $product[0]->price_html );

		$result = <<<HTML
		<div class="product sale-{$product[0]->on_sale}">
			<a href="{$product[0]->permalink}" class="product__link">
				{$html_sale_badge}
				<span class="product__image">
					{$html_image}
				</span>
				<h2 class="product__title">{$product[0]->title}</h2>
				<span class="product__price">
					{$html_price}
				</span>
			</a>
		</div>
		HTML;

		return $result;

	}

}

<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/Pasquill
 * @since      1.0.0
 *
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/admin
 */

/**
 * @package    Products_Collector_For_Blog
 * @subpackage Products_Collector_For_Blog/admin
 * @author     Pasquill <pasquill.x@gmail.com>
 */
class Products_Collector_For_Blog_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/products-collector-for-blog-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/products-collector-for-blog-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register plugin menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_options_page( 'Products Collector', 'Products Collector', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page') );

	}

	/**
     * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
    public function add_action_links( $links ) {

		$settings_link = array(
		 '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
		);
		return array_merge( $settings_link, $links );

	 }

	/**
	 * Render the settings page for the plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_setup_page() {

		include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}

	/**
	 * Register options in the allowed options list.
	 *
	 * @since    1.0.0
	 */
	public function register_plugin_options() {

		register_setting( $this->plugin_name, $this->plugin_name );

	}

	/**
	 * Get products from woo rest api.
	 *
	 * @since    1.0.0
	 */
	public function pcfb_get_products_from_api() {
		global $wpdb;

		$options = get_option( $this->plugin_name );

		$current_page = ( ! empty( $_POST['current_page'] ) ) ? $_POST['current_page'] : 1;
		$products = [];

		// Works with https only!
		$results = wp_remote_get(
			$options['endpoint'] . '?page=' . $current_page . '&per_page=5',
			array(
				'sslverify' => false, // for local
				'headers' => array(
					'authorization' => 'Basic ' . base64_encode( $options['ck'] . ':' . $options['cs'] ),
				)
			)
		);

		if( is_wp_error( $results ) ) {
			// tbd: log
			// print_r( $results->get_error_code() );
			// print_r( $results->get_error_message() );
			// print_r( $results->get_error_data() );
			return false;
		}

		$results = json_decode( wp_remote_retrieve_body( $results ) );

		if( ! is_array( $results ) || empty( $results ) ) {
			// tbd: log
			// stdClass Object ( [code] => woocommerce_rest_cannot_view [message] => Sorry, you cannot list resources. [data] => stdClass Object ( [status] => 401 ) )
			return false;
		}

		// Process & save
		foreach ($results as $key => $value) {

			switch ( $value->type ) {
				case 'variable':
					$data = array(
						'id' 			=> $value->id,
						'date_modified' => $value->date_modified,
						'title'			=> $value->name,
						'image_url' 	=> $value->images[0]->src,
						'price_html' 	=> htmlspecialchars( $value->price_html ),
						'on_sale'		=> $value->on_sale,
						'permalink' 	=> $value->permalink,
						'update_time' 	=> date('Y-m-d H:i:s'),
					);
					break;

				default: // assume type = simple
					$data = array(
						'id' 			=> $value->id,
						'date_modified' => $value->date_modified,
						'title'			=> $value->name,
						'image_url' 	=> $value->images[0]->src,
						'price_html' 	=> htmlspecialchars( $value->price_html ),
						'on_sale'		=> $value->on_sale,
						'permalink' 	=> $value->permalink,
						'update_time' 	=> date('Y-m-d H:i:s'),
					);
					break;
			}

			$query = $wpdb->replace(
				$wpdb->prefix . 'pcfb_products_collector',
				$data,
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
					'%s',
					'%s',
				)
			);

			if( false === $query ) {
				// tbd: log
			}
		}

		$current_page = $current_page + 1;
		wp_remote_post( admin_url( 'admin-ajax.php?action=pcfb_get_products_from_api' ), array(
			'blocking' => false,
			'sslverify' => false, // for local use
			'body' => array(
				'current_page' => $current_page
			)
		) );

	}

}

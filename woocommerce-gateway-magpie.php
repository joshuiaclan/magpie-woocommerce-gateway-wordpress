<?php
/**
 * Plugin Name: WooCommerce Magpie Gateway
 * Plugin URI: https://wordpress.org/plugins/woocommerce-gateway-stripe/
 * Description: Charge any card with a Visa or MasterCard logo, whether credit, debit, or prepaid. Soon: Accept bitcoins and other digital currencies and get paid in local money!
 * Author: Joshua Reden M. Aclan
 * Version: 1.0.0
 * Text Domain: woocommerce-gateway-magpie
 * Domain Path: /languages
 *
 */


// Include Gateway Class and Register Payment Gateway with WooCommerce
add_action( 'plugins_loaded', 'woocommerce_gateway_magpie_init', 0 );

// Initialize plugin
function woocommerce_gateway_magpie_init() {
	
	if ( ! class_exists( 'WC_Payment_Gateway' ) ) return ;


	class WC_Magpie_Gateway extends WC_Payment_Gateway {
		
		// Build the administration fields for this specific Gateway
		public function init_form_fields() {
			include(dirname(__FILE__) . "/includes/magpie-settings.php");
		}
		// Initialize woocommerce settings
		function __construct() {
			// The global ID for this Payment method
			$this->id = "woocommerce-magpie";

			// The Title shown on the top of the Payment Gateways Page next to all the other Payment Gateways
			$this->method_title = __( "Magpie", 'woocommerce-magpie' );

			// The description for this Payment Gateway, shown on the actual Payment options page on the backend
			$this->method_description = __( "Magpie Payment Gateway Plug-in for WooCommerce", 'woocommerce-magpie' );

			// The title to be used for the vertical tabs that can be ordered top to bottom
			$this->title = __( "Magpie", 'woocommerce-magpie' );

			// If you want to show an image next to the gateway's name on the frontend, enter a URL to an image.
			$this->icon = null;

			// Bool. Can be set to true if you want payment fields to show on the checkout 
			// if doing a direct integration, which we are doing in this case
			$this->has_fields = true;

			// Supports the default credit card form
			$this->supports = array( 'default_credit_card_form' );

			// This basically defines your settings which are then loaded with init_settings()
			$this->init_form_fields();

			// After init_settings() is called, you can get the settings and load them into variables, e.g:
			// $this->title = $this->get_option( 'title' );
			$this->init_settings();
			
			// Turn these settings into variables we can use
			foreach ( $this->settings as $setting_key => $value ) {
				$this->$setting_key = $value;
			}
			
			// Lets check for SSL
			// add_action( 'admin_notices', array( $this,	'do_ssl_check' ) );
			
			// Save settings
			if ( is_admin() ) {

				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
			}		
		}

		

	}

	add_filter( 'woocommerce_payment_gateways', 'add_woocommerce_magpie_class' );

	function add_woocommerce_magpie_class( $methods ) {
		$methods[] = 'WC_Magpie_Gateway'; 
		return $methods;
	}

}



// Add custom action links
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'woocommerce_magpie_action_links' );

function woocommerce_magpie_action_links( $links ) {
	$plugin_links = array(
		'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=woocommerce-magpie' ) . '" target="_blank">' . __( 'Settings', 'woocommerce-magpie' ) . '</a>',
	);
	// Merge our new link with the default ones
	return array_merge( $plugin_links, $links );	
}

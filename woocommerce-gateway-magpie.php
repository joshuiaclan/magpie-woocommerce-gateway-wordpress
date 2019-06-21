<?php
/**
 * Plugin Name: WooCommerce Magpie Gateway
 * Plugin URI: https://wordpress.org/plugins/woocommerce-gateway-stripe/
 * Description: Magpie's apps and tools allow you to collect customer payments easily on their mobile phones. Your web or native apps on iOS and Android just work.
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

	define( 'WC_MAGPIE_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );


	class WC_Magpie_Gateway extends WC_Payment_Gateway {
		
		// Build the administration fields for this specific Gateway
		public function init_form_fields() {
			include(dirname(__FILE__) . "/includes/magpie-settings.php");
		}
		// Initialize woocommerce settings
		function __construct() {
			include(dirname(__FILE__) . "/includes/woocommerce-magpie-settings.php");
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

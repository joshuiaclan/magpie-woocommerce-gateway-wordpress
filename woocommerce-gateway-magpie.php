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

		public function process_payment( $order_id ) {
			include(dirname(__FILE__) . "/includes/woocommerce-magpie-process-payment.php");
		}
		// Apply icon on credit card forms
		public function get_icon() {
			$icons = apply_filters(
				'wc_stripe_magpie_icons',
				array(
					'magpie'       => '<img src="' . WC_MAGPIE_PLUGIN_URL . '/assets/images/magpie-logo.svg" class="magpie-logo-icon magpie-icon"  style="height: 22px; width: 40px; border-radius: 5% 5%; background: #4e505f; padding: 5px; border: 9px;" alt="Magpie" />',
					'visa'       => '<img width="35px" src="' . WC_MAGPIE_PLUGIN_URL . '/assets/images/visa.svg" class="magpie-visa-icon magpie-icon"  alt="Visa" />',
					'mastercard' => '<img width="35px" src="' . WC_MAGPIE_PLUGIN_URL . '/assets/images/mastercard.svg" class="magpie-mastercard-icon magpie-icon" alt="Mastercard" />',
				)
			);;

			$icons_str = '';


			$icons_str .= isset( $icons['magpie'] ) ? $icons['magpie'] : '';
			$icons_str .= isset( $icons['visa'] ) ? $icons['visa'] : '';
			$icons_str .= isset( $icons['mastercard'] ) ? $icons['mastercard'] : '';

			return apply_filters( 'woocommerce_gateway_icon', $icons_str, $this->id );
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

<?php 
// The global ID for this Payment method
	$this->id = "woocommerce-magpie";

	// The Title shown on the top of the Payment Gateways Page next to all the other Payment Gateways
	$this->method_title = __( "Magpie", 'woocommerce-magpie' );

	// The description for this Payment Gateway, shown on the actual Payment options page on the backend
	$this->method_description = __( "Magpie Payment Gateway Plug-in for WooCommerce", 'woocommerce-magpie' );

	// The title to be used for the vertical tabs that can be ordered top to bottom
	$this->title = __( "Magpie", 'woocommerce-magpie' );

	// If you want to show an image next to the gateway's name on the frontend, enter a URL to an image.
	$this->icon = true;
	// __(WC_MAGPIE_PLUGIN_URL . '/assets/images/magpie-logo.svg', 'woocommerce-magpie')
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
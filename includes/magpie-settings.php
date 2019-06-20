<?php
	
	$this->form_fields = array(
		'enabled' => array(
			'title'		=> __( 'Enable / Disable', 'woocommerce-magpie' ),
			'label'		=> __( 'Enable this payment gateway', 'woocommerce-magpie' ),
			'type'		=> 'checkbox',
			'default'	=> 'no',
		),
		'title' => array(
			'title'		=> __( 'Title', 'woocommerce-magpie' ),
			'type'		=> 'text',
			'desc_tip'	=> __( 'Payment title the customer will see during the checkout process.', 'woocommerce-magpie' ),
			'default'	=> __( 'Credit card', 'woocommerce-magpie' ),
		),
		'description' => array(
			'title'		=> __( 'Description', 'woocommerce-magpie' ),
			'type'		=> 'textarea',
			'desc_tip'	=> __( 'Magpie\'s apps and tools allow you to collect customer payments easily on their mobile phones. Your web or native apps on iOS and Android just work.', 'woocommerce-magpie' ),
			'default'	=> __( 'Pay securely using your credit card.', 'woocommerce-magpie' ),
			'css'		=> 'max-width:350px;'
		),
		'testmode'        		=> array(
			'title'       => __( 'Test mode', 'woocommerce-magpie' ),
			'label'       => __( 'Enable Test Mode', 'woocommerce-magpie' ),
			'type'        => 'checkbox',
			'description' => __( 'Place the payment gateway in test mode using test API keys.', 'woocommerce-magpie' ),
			'default'     => 'yes',
			'desc_tip'    => true,
		),
		'test_publishable_key'	=> array(
			'title'       => __( 'Test Publishable Key', 'woocommerce-magpie' ),
			'type'        => 'password',
			'description' => __( 'Get your API keys from your stripe account.', 'woocommerce-magpie' ),
			'default'     => '',
			'desc_tip'    => true,
		),
		'test_secret_key'       => array(
			'title'       => __( 'Test Secret Key', 'woocommerce-magpie' ),
			'type'        => 'password',
			'description' => __( 'Get your API keys from your stripe account.', 'woocommerce-magpie' ),
			'default'     => '',
			'desc_tip'    => true,
		),
		'publishable_key'       => array(
			'title'       => __( 'Live Publishable Key', 'woocommerce-magpie' ),
			'type'        => 'password',
			'description' => __( 'Get your API keys from your stripe account.', 'woocommerce-magpie' ),
			'default'     => '',
			'desc_tip'    => true,
		),
		'secret_key'            => array(
			'title'       => __( 'Live Secret Key', 'woocommerce-magpie' ),
			'type'        => 'password',
			'description' => __( 'Get your API keys from your stripe account.', 'woocommerce-magpie' ),
			'default'     => '',
			'desc_tip'    => true,
		),
	);		

<?php

 global $woocommerce;

    $order = new WC_Order( $order_id );

    // Environment URL
    $environment_url = 'https://api.magpie.im/v1';
    $publishable_key = $this->test_publishable_key;
    $secret_key = $this->test_secret_key;

    $header = base64_encode('$publishable_key'. ':');

    $card_expiry = preg_split(' / ', $_POST['woocommerce-magpie-card-expiry']);
    
    $exp_month = $card_expiry[0];
    $exp_year = $card_expiry[1];

    // "amount"             	=> $order->order_total,
	$cardObj= array(
		// Credit Card Information
		"card_num"      => $_POST['woocommerce-magpie-card-number'],
		"cvc"          	=> ( isset( $_POST['woocommerce-magpie-card-cvc'] ) ) ? $_POST['woocommerce-magpie-card-cvc'] : '',
		"exp_month"     => $exp_month,
		"exp_year"		=> $exp_year,
		
		// Billing Information
		"address_line1"         => $order->billing_address_1,
		"address_city"          => $order->billing_city,
		
		// Some Customer Information
		"cust_id"            	=> $customer_order->user_id,
		"customer_ip"        	=> $_SERVER['REMOTE_ADDR'],
		
	);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.magpie.im/v1/tokens");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cardObj));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	  "Content-Type: application/json",
	  "Accept: application/json",
	  "Authorization: Basic " . $header
	));

	$response = curl_exec($ch);
	curl_close($ch);

	var_dump($response);

    
    // Remove cart
    // $woocommerce->cart->empty_cart();

    // Return thankyou redirect
    return array(
        'result' => 'success',
        'redirect' => $this->get_return_url( $order )
    );
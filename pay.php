<?php

require "core.php";

use Razorpay\Api\Api;

// Seo Title
$titleSeoHeader = getSeoTitle($translation['tr_1']);

// Seo Description
$descriptionSeoHeader = getSeoDescription($translation['tr_3']);

// Page Title
$pageTitle = $translation['tr_1'];

// Get Item Slug
$itemId = clearGetData(getItemId());

$errors = array();

if(empty($itemId)){

	header('Location: '. $urlPath->home());
}

if (!isLogged()){

	header('Location: '. $urlPath->signin());

}else{

    $planTaxes = [];
    $appliedTaxes = [];

	$userProfile = getUserInfo();
	$userDetails = getUserInfoById($userProfile['user_id']);
	$planDetails = getPlanById($connect, $itemId);

    if(!empty($planDetails['plan_taxes'])){
        $planTaxes = getTaxesByPlan($planDetails['plan_taxes']);
        $appliedTaxes = getAppliedTaxes($planTaxes);
    }


    $pricesArray = array(
        [
            'frequency' => 'monthly',
            'label' => $planDetails['plan_monthly_label'],
            'price' => $planDetails['plan_monthly'],
            'description' => $planDetails['plan_monthly_description'],
        ],
        [
            'frequency' => 'halfyear',
            'label' => $planDetails['plan_halfyear_label'],
            'price' => $planDetails['plan_halfyear'],
            'description' => $planDetails['plan_halfyear_description'],
        ],
        [
            'frequency' => 'annual',
            'label' => $planDetails['plan_annual_label'],
            'price' => $planDetails['plan_annual'],
            'description' => $planDetails['plan_annual_description'],
        ]
    );

    $data = [
        'payment_taxes' => $appliedTaxes
    ];

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        
		
		$frequency = clearGetData($_POST['frequency']);
		$planId = clearGetData($_POST['plan']);
		$codeCoupon = clearGetData($_POST['coupon']);
		$paymentProcessor = clearGetData($_POST['payment']);
		$paymentProcessor = clearGetData($_POST['payment']);
		
		$couponPrice = getCouponPrice($connect, $planId, $codeCoupon, $frequency);
		$planPrice = getPlanPrice($connect, $planId, $frequency);

        // checking if billing information is empty
        
        if(empty($userDetails['user_billing']) || $userDetails['user_billing'] == "[]"){

            $billing_name = mb_substr(trim(clearGetData($_POST['billing_name'])), 0, 128);
            $billing_address = mb_substr(trim(clearGetData($_POST['billing_address'])), 0, 128);
            $billing_city = mb_substr(trim(clearGetData($_POST['billing_city'])), 0, 64);
            $billing_zip = mb_substr(trim(clearGetData($_POST['billing_zip'])), 0, 32);
            $billing_country = array_key_exists($_POST['billing_country'], $countriesArray) ? clearGetData($_POST['billing_country']) : 'US';
            $billing_company = mb_substr(trim(clearGetData($_POST['billing_company'])), 0, 128);
            $billing_phone = mb_substr(trim(clearGetData($_POST['billing_phone'])), 0, 32);
            $billing_tax_id = mb_substr(trim(clearGetData($_POST['billing_tax_id'])), 0, 128);
            $_POST['billing'] = json_encode([
                'user_billing_name' => $billing_name,
                'user_billing_address' => $billing_address,
                'user_billing_city' => $billing_city,
                'user_billing_zip' => $billing_zip,
                'user_billing_country' => $billing_country,
                'user_billing_company' => $billing_company,
                'user_billing_phone' => $billing_phone,
                'user_billing_tax_id' => $billing_tax_id
            ]);
    
            $required_fields = ['frequency', 'plan', 'payment', 'billing_name', 'billing_address', 'billing_country', 'billing_city', 'billing_zip'];
            foreach($required_fields as $field) {
                if(!isset($_POST[$field]) || (isset($_POST[$field]) && empty($_POST[$field]) && $_POST[$field] != '0')) {
                    $errors[] = $translation['tr_191'];
                }
            }

        if (empty($errors)) {
            // update user billing info
            $statement = $connect->prepare("UPDATE users SET user_billing = :user_billing WHERE user_id = :user_id");
            $statement->execute(array(
                ':user_id' => $userInfo['user_id'],
                ':user_billing' => $_POST['billing']
            ));
        }

        }

        if (empty($errors)) {

            $applied_taxes = [];
            
            if(!empty($appliedTaxes)){

            $applied_taxes = array_column($appliedTaxes, 'tax_id');

            }

            $base_amount = $couponPrice['base_amount'];
            $discount_amount = $couponPrice['discount_amount'];
            $price = $couponPrice['price'];
            $code = $couponPrice['code'];

		switch($paymentProcessor) {

			case 'stripe':

				\Stripe\Stripe::setApiKey($settings['st_stripe_secret']);

                // taxes
                $price = calculateTaxes($couponPrice['price'], json_encode($applied_taxes));

				// price
				$stripe_formatted_price = in_array($settings['st_currencycode'], ['MGA', 'BIF', 'CLP', 'PYG', 'DJF', 'RWF', 'GNF', 'UGX', 'JPY', 'VND', 'VUV', 'XAF', 'KMF', 'KRW', 'XOF', 'XPF']) ? number_format($price, 0, '.', '') : number_format($price, 2, '.', '') * 100;

				$planPrice = number_format($price, 2, '.', '');

				try {
					$stripe_product = \Stripe\Product::retrieve($planId);
				} catch (\Exception $exception) {
					// The plan not exist
				}

				if(!isset($stripe_product)) {
					$stripe_product = \Stripe\Product::create([
						'id'    => $planId,
						'name'  => 'Plan - ' . $planDetails['plan_title'],
					]);
				}

				$stripe_plan_id = $planId . '_' . $frequency . '_' . $stripe_formatted_price . '_' . $settings['st_currencycode'];

				// Check if we already have a payment plan created and try to get it
				try {
					$stripe_plan = \Stripe\Plan::retrieve($stripe_plan_id);
				} catch (\Exception $exception) {
					// The plan not exist
				}

				if(!isset($stripe_plan)) {
					try {
						$stripe_plan = \Stripe\Plan::create([
							'amount' => $stripe_formatted_price,
							'interval' => 'day',
							'interval_count' => getFrequency($frequency),
							'product' => $stripe_product->id,
							'currency' => $settings['st_currencycode'],
							'id' => $stripe_plan_id
						]);
					} catch (\Exception $exception) {
						$urlPath->pay($planId);
					}
				}

					$stripe_session = \Stripe\Checkout\Session::create([
						'payment_method_types' => ['card'],
						'subscription_data' => [
							'items' => [
								['plan' => $stripe_plan->id]
							],
                            'metadata' => [
								'user_id' => $userInfo['user_id'],
								'plan_id' => $planId,
								'payment_frequency' => $frequency,
                                'base_amount' => $base_amount,
                                'code' => $code,
                                'discount_amount' => $discount_amount,
                            'taxes_ids' => json_encode($applied_taxes)
                            ],
                        ],
                        'metadata' => [
                            'user_id' => $userInfo['user_id'],
                            'plan_id' => $planId,
                            'payment_frequency' => $frequency,
                            'base_amount' => $base_amount,
                            'code' => $code,
                            'discount_amount' => $discount_amount,
                            'taxes_ids' => json_encode($applied_taxes)
                        ],
						'success_url' => $urlPath->success($planId, ['base_amount' => $base_amount, 'price' => $price, 'code' => $code, 'discount_amount' => $discount_amount]),
						'cancel_url' => $urlPath->cancel($planId),
					]); 


				header("HTTP/1.1 303 See Other");
				header('Location: ' . $stripe_session->url); die();

			break;

			case 'paypal':

                // taxes
                $price = calculateTaxes($couponPrice['price'], $planDetails['plan_taxes']);

				$price = in_array($settings['st_currencycode'], ['JPY', 'TWD', 'HUF']) ? number_format($price, 0, '.', '') : number_format($price, 2, '.', '');

				try {
					$paypal_api_url = get_api_url_paypal($settings);
					$headers = get_headers_paypal($settings);
				} catch (\Exception $exception) {
					echo $exception->getMessage();
					$urlPath->pay($planId);
				}

				$custom_id = $userInfo['user_id'] . '&' . $planId . '&' . $frequency . '&' . $base_amount . '&' . $code . '&' . $discount_amount . '&' . json_encode($applied_taxes);

                $paypal_plan_id = $planId . '_' . $frequency . '_' . $price . '_' . $settings['st_currencycode'];

                // Product
                $response = \Unirest\Request::get($paypal_api_url . 'v1/catalogs/products/' . $paypal_plan_id, $headers);

                // Check against errors
                if($response->code == 404) {
                    // Create the product if not existing
                    $response = \Unirest\Request::post($paypal_api_url . 'v1/catalogs/products', $headers, \Unirest\Request\Body::json([
                        'id' => $paypal_plan_id,
                        'name' => 'Plan - ' . $planDetails['plan_title'],
                        'type' => 'DIGITAL',
                    ]));

                    // Check against errors
                    if($response->code >= 400) {
                        if(isAdmin()) {
                            echo $response->body->name . ':' . $response->body->message;
                        }

						$urlPath->pay($planId);
                    }
                }

                // Create a new plan
                $response = \Unirest\Request::post($paypal_api_url . 'v1/billing/plans', $headers, \Unirest\Request\Body::json([
                    'product_id' => $paypal_plan_id,
                    'name' => 'Plan - ' . $planDetails['plan_title'] . ' - ' . ucfirst($frequency),
                    'description' => $planDetails['plan_title'],
                    'status' => 'ACTIVE',
                    'billing_cycles' => [[
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'currency_code' => $settings['st_currencycode'],
                                'value' => $price
                            ]
                        ],
                        'frequency' => [
                            'interval_unit' => 'DAY',
							'interval_count' => getFrequency($frequency),
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => $frequency == 'monthly' ? 60 : 15,
                    ]],
                    'payment_preferences' => [
                        'auto_bill_outstanding' => true,
                        'setup_fee' => [
                            'currency_code' => $settings['st_currencycode'],
                            'value' => $price
                        ],
                        'setup_fee_failure_action' => 'CANCEL',
                        'payment_failure_threshold' => 0
                    ]
                ]));

                // Check against errors
                if($response->code >= 400) {
                    if(isAdmin()) {
                        echo $response->body->name . ':' . $response->body->message;
                    }
					
					$urlPath->pay($planId);
                }

                // Create a new subscription
                $response = \Unirest\Request::post($paypal_api_url . 'v1/billing/subscriptions', $headers, \Unirest\Request\Body::json([
                    'plan_id' => $response->body->id,
                    'start_time' => (new \DateTime())->modify(getTimeFreq($frequency))->format(DATE_ISO8601),
                    'quantity' => 1,
                    'custom_id' => $custom_id,
                    'subscriber' => [
						"email_address" => $userInfo['user_email'],
                    ],
					"email_address" => $userInfo['user_email'],
                    'payment_method' => [
                        'payer_selected' => 'PAYPAL',
                        'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED'
                    ],
                    'application_context' => [
                        'brand_name' => $translation['tr_1'],
                        'shipping_preference' => 'NO_SHIPPING',
                        'user_action' => 'SUBSCRIBE_NOW',
						'return_url' => $urlPath->success($planId),
						'cancel_url' => $urlPath->cancel($planId)
                    ]
                ]));

                // Check against errors
                if($response->code >= 400) {
                    if(isAdmin()) {
                        echo $response->body->name . ':' . $response->body->message;
                    }

					$urlPath->pay($planId);
                }

                $paypal_payment_url = $response->body->links[0]->href;

                header('Location: ' . $paypal_payment_url); die();

			break;

			case 'paystack':

                
                /*if($settings['st_currencycode'] != "GHS" || $settings['st_currencycode'] != "NGN" || $settings['st_currencycode'] != "ZAR"){

                    echo "Invalid Currency use GHS/NGN/ZAR instead of " . $settings['st_currencycode'];
                    exit();

                }*/

				// Taxes
                $price = calculateTaxes($couponPrice['price'], $planDetails['plan_taxes']);
                
                $price = number_format($price, 2, '.', '');

				$response = \Unirest\Request::post(get_api_url_paystack() . 'plan', get_headers_paystack($settings), \Unirest\Request\Body::json([
                    'name' => $planDetails['plan_title'] . ' - ' . ucfirst(getFrePayStack($frequency)),
                    'interval' => getFrePayStack($frequency),
                    'amount' => (int) ($price * 100),
                    'currency' => 'ZAR',
                ]));

                if(!$response->body->status) {
                    if(isAdmin()) {
                        echo $response->body->message;
                    }
					$urlPath->pay($planId);
                }

                $paystack_plan_code = $response->body->data->plan_code;

                // Generate the payment url
                $response = \Unirest\Request::post(get_api_url_paystack() . 'transaction/initialize', get_headers_paystack($settings), \Unirest\Request\Body::json([
                    'key' => $settings['st_paystack_public'],
                    'email' => $userInfo['user_email'],
                    'first_name' => $userInfo['user_name'],
                    'currency' => 'ZAR',
                    'amount' => (int) ($price * 100),
                    'metadata' => [
                        'user_id' => $userInfo['user_id'],
                        'plan_id' => $planId,
                        'payment_frequency' => getFrePayStack($frequency),
						'base_amount' => $base_amount,
						'code' => (($code) ? $code : null),
						'discount_amount' => (($discount_amount) ? $discount_amount : 0),
                        'taxes_ids' => json_encode($applied_taxes)
                    ],
                    'customer' => [
                        'first_name' => $userInfo['user_name'],
                        'email' => $userInfo['user_email'],
                    ],
                    'callback_url' => $urlPath->success($planId, ['base_amount' => $base_amount, 'price' => $price, 'code' => $code, 'discount_amount' => $discount_amount]),
                    'plan' => $paystack_plan_code
                ]));

                if(!$response->body->status) {
                    if(isAdmin()) {
                        echo $response->body->message;
                    }
					$urlPath->pay($planId);
                }

                // Redirect to payment
                header('Location: ' . $response->body->data->authorization_url); die();

			break;

			case 'mollie':

            $mollie = new \Mollie\Api\MollieApiClient();
            
            $mollie->setApiKey($settings['st_mollie_api']);

            // Taxes
            $price = calculateTaxes($couponPrice['price'], $planDetails['plan_taxes']);

			$price = number_format($price, 2, '.', '');

            // Generate the customer
            try {
                $customer = $mollie->customers->create([
                    'name' => $userInfo['user_name'],
                    'email' => $userInfo['user_email'],
                ]);
            } catch (\Exception $exception) {
                if(isAdmin()) {
                    echo $exception->getMessage();
                }
					$urlPath->pay($planId);
            }

            // Generate the payment url
            try {
                $payment = $customer->createPayment([
                    'sequenceType' => 'first',
                    'amount' => [
                        'currency' => $settings['st_currencycode'],
                        'value' => $price,
                    ],
                    'description' => $frequency,
                    'metadata' => [
                        'user_id' => $userInfo['user_id'],
                        'plan_id' => $planId,
                        'payment_frequency' => $frequency,
						'base_amount' => $base_amount,
						'code' => (($code) ? $code : null),
						'discount_amount' => (($discount_amount) ? $discount_amount : 0),
                        'taxes_ids' => json_encode($applied_taxes)
                    ],
                    'redirectUrl' => $urlPath->success($planId, ['base_amount' => $base_amount, 'price' => $price, 'code' => $code, 'discount_amount' => $discount_amount]),
                    'webhookUrl'  => SITE_URL . '/hooks/webhook-mollie.php'
                ]);
            } catch (\Exception $exception) {
                if(isAdmin()) {
                    echo $exception->getMessage();
                }
					$urlPath->pay($planId);
            }

            // Redirect to payment
            header('Location: ' . $payment->getCheckoutUrl()); die();

            break;

            case 'razorpay':

            if($settings['st_currencycode'] != "INR"){

                echo "Invalid Currency use INR instead of " . $settings['st_currencycode'];
                exit();

            }
            
            $razorpay = new Api($settings['st_razorpay_publickey'], $settings['st_razorpay_secretkey']);

            // Taxes
            $price = calculateTaxes($couponPrice['price'], $planDetails['plan_taxes']);

            $price = number_format($price, 2, '.', '');

            try {
                $plan = $razorpay->plan->create([
                    'period' => 'daily',
                    'interval' => getFrequency($frequency),
                    'item' => [
                        'name' => $planDetails['plan_title'],
                        'description' => $frequency,
                        'amount' => $price * 100,
                        'currency' => $settings['st_currencycode'],
                    ],
                ]);
            }  catch (\Exception $exception) {
                if(isAdmin()) {
                    echo $exception->getMessage();
                }
					$urlPath->pay($planId);
            }

            // Generate the payment url
            try {
                $response = $razorpay->subscription->create([
                    'plan_id' => $plan['id'],
                    'total_count' => $frequency == 'monthly' ? 60 : 15,
                    'quantity' => 1,
                    'notes' => [
                        'user_id' => $userInfo['user_id'],
                        'plan_id' => $planId,
                        'payment_frequency' => $frequency,
						'base_amount' => $base_amount,
						'code' => (($code) ? $code : null),
						'discount_amount' => (($discount_amount) ? $discount_amount : 0),
                        'taxes_ids' => json_encode($applied_taxes)
                    ]
                ]);
            } catch (\Exception $exception) {
                if(isAdmin()) {
                    echo $exception->getMessage();
                } 
					$urlPath->pay($planId);
            }

            // Redirect to payment
            header('Location: ' . $response['short_url']); die();

            break;

            }

		}
		
			}

				include './header.php';
				require './views/pay.view.php';
				include './footer.php';
			
}

?>
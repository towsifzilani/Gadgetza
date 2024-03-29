<?php

    require '../core.php';

    if((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !isset($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'])) {
        die();
    }

    $payload = @file_get_contents('php://input');

    if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $payload, $settings['st_paystack_secret'])) {
        die();
    }

    $data = json_decode($payload);

    if(!$data) {
        die();
    }

    if($data->event == 'charge.success') {

        /* Get subscription details if needed */
        $payment_subscription_id = null;

        if(isset($data->data->plan->id)) {

            $response = \Unirest\Request::get(get_api_url_paystack() . 'plan/' . $data->data->plan->id, get_headers_paystack($settings));

            if(!$response->body->status) {

                    http_response_code(400); die();
            }

            $payment_subscription_id = $response->body->data->subscriptions[0]->subscription_code . '###' . $response->body->data->subscriptions[0]->email_token;
        }

        /* Start getting the payment details */
        $external_payment_id = $data->data->id;
        $payment_total = $data->data->amount / 100;
        $payment_currency = $data->data->currency;
        $payment_type = 'recurring';

        /* Payment payer details */
        $payer_email = $data->data->customer->email;
        $payer_name = $data->data->customer->first_name . $data->data->customer->last_name;

        /* Process meta data */
        $metadata = $data->data->metadata;
        $user_id = (int) $metadata->user_id;
        $plan_id = (int) $metadata->plan_id;
        $payment_frequency = ($metadata->payment_frequency == 'biannually') ? 'halfyear' : $metadata->payment_frequency;
        $code = isset($metadata->code) ? $metadata->code : '';
        $discount_amount = isset($metadata->discount_amount) ? $metadata->discount_amount : 0;
        $base_amount = isset($metadata->base_amount) ? $metadata->base_amount : 0;
        $taxes_ids = isset($metadata->taxes_ids) ? $metadata->taxes_ids : null;

        webhookProcessPayment($connect,
            $settings,
            'paystack',
            $taxes_ids,
            $external_payment_id,
            $payment_total,
            $payment_currency,
            $user_id,
            $plan_id,
            $payment_frequency,
            $code,
            $discount_amount,
            $base_amount,
            $payment_type,
            $payment_subscription_id,
            $payer_email,
            $payer_name
        );
    
        die('successful');

    }

    die('');

    


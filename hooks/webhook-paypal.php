<?php

    require '../core.php';

    $payload = @file_get_contents('php://input');
    $data = json_decode($payload);

    if($payload && $data) {

        try {
            $paypal_api_url = get_api_url_paypal($settings);
            $headers = get_headers_paypal($settings);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            http_response_code(400); die();
        }

        if($data->event_type == 'PAYMENT.SALE.COMPLETED') {

            $response = \Unirest\Request::get($paypal_api_url . 'v1/billing/subscriptions/' . $data->resource->billing_agreement_id . '?fields=plan', $headers);

            if($response->code >= 400) {

                echo $response->body->name . ':' . $response->body->message;
                http_response_code(400); die();
            }

            $external_payment_id = $data->resource->id;
            $payment_total = $data->resource->amount->total;
            $payment_currency = $data->resource->amount->currency;
            $payment_type = 'subscription';
            $payment_subscription_id = $data->resource->billing_agreement_id;

            /* Payment payer details */
            $payer_email = $response->body->subscriber->email_address;
            $payer_name = $response->body->subscriber->name->given_name . $response->body->subscriber->name->surname;

            if(isset($response->body->custom_id)) {
                $metadata = explode('&', $response->body->custom_id);
                $user_id = (int) $metadata[0];
                $plan_id = (int) $metadata[1];
                $payment_frequency = $metadata[2];
                $base_amount = $metadata[3];
                $code = $metadata[4];
                $discount_amount = $metadata[5] ? $metadata[5] : 0;
                $taxes_ids = $metadata[6];
            } else {

                $extra = explode('###', $response->body->plan->name);

                if(isset($extra[0], $extra[1], $extra[2])) {
                    $user_id = (int) $extra[0];
                    $plan_id = (int) $extra[1];
                    $payment_frequency = $extra[2];
                    $code = $extra[3];
                    $discount_amount = 0;
                    $base_amount = 0;
                } else {
                    $extra = explode('!!', $response->body->plan->name);

                    $user_id = (int) $extra[0];
                    $plan_id = (int) $extra[1];
                    $base_amount = $extra[2];
                    $payment_frequency = $extra[3];
                    $code = $extra[4];
                    $discount_amount = $extra[5] ? $extra[5] : 0;
                    $taxes_ids = $extra[6];
                }
            }

        }

    webhookProcessPayment($connect,
        $settings,
        'paypal',
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


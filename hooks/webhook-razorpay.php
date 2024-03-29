<?php

    require '../core.php';

    if((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !isset($_SERVER['HTTP_X_RAZORPAY_SIGNATURE'])) {
        die();
    }

    $payload = trim(@file_get_contents('php://input'));

    if($_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] !== hash_hmac('sha256', $payload, $settings['st_razorpay_webhook'])) {
        die();
    }

    $data = json_decode($payload);

    if(!$data) {
        die();
    }

    if($data->event == 'subscription.charged') {

        /* Start getting the payment details */
        $external_payment_id = $data->payload->payment->entity->id;
        $payment_total = $data->payload->payment->entity->amount / 100;
        $payment_currency = $data->payload->payment->entity->currency;
        $payment_type = 'recurring';
        $payment_subscription_id = $data->payload->subscription->entity->id;

        /* Payment payer details */
        $payer_email = $data->payload->payment->entity->email;
        $payer_name = '';

        /* Process meta data */
        $metadata = $data->payload->subscription->entity->notes;
        $user_id = (int) $metadata->user_id;
        $plan_id = (int) $metadata->plan_id;
        $payment_frequency = $metadata->payment_frequency;
        $code = isset($metadata->code) ? $metadata->code : '';
        $discount_amount = isset($metadata->discount_amount) ? $metadata->discount_amount : 0;
        $base_amount = isset($metadata->base_amount) ? $metadata->base_amount : 0;
        $taxes_ids = isset($metadata->taxes_ids) ? $metadata->taxes_ids : null;

        webhookProcessPayment($connect,
            $settings,
            'razorpay',
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

    


<?php

    require '../core.php';

	\Stripe\Stripe::setApiKey($settings['st_stripe_secret']);

    /*if(!isset($_SERVER['HTTP_STRIPE_SIGNATURE'])){
        die();
    }*/

    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $settings['st_stripe_webhook']
        );
    } catch(\UnexpectedValueException $e) {
        echo $e->getMessage();
        http_response_code(400);
        die();
    } catch(\Stripe\Exception\SignatureVerificationException $e) {
        echo $e->getMessage();
        http_response_code(400);
        die();
    }

    if(!in_array($event->type, ['invoice.paid'])) {
        die();
    }

    $session = $event->data->object;

    $external_payment_id = $session->id;
    $payer_id = $session->customer;
    $payer_object = \Stripe\Customer::retrieve($payer_id);
    $payer_email = $payer_object->email;
    $payer_name = $payer_object->name;

    switch($event->type) {

        case 'invoice.paid':

            $payment_total = in_array($settings['st_currencycode'], ['MGA', 'BIF', 'CLP', 'PYG', 'DJF', 'RWF', 'GNF', 'UGX', 'JPY', 'VND', 'VUV', 'XAF', 'KMF', 'KRW', 'XOF', 'XPF']) ? $session->amount_paid : $session->amount_paid / 100;
            $payment_currency = mb_strtoupper($session->currency);

            /* Process meta data */
            $metadata = $session->lines->data[0]->metadata;

            $user_id = (int) $metadata->user_id;
            $plan_id = (int) $metadata->plan_id;
            $payment_frequency = $metadata->payment_frequency;
            $code = isset($metadata->code) ? $metadata->code : '';
            $discount_amount = isset($metadata->discount_amount) ? $metadata->discount_amount : 0;
            $base_amount = isset($metadata->base_amount) ? $metadata->base_amount : 0;
            $taxes_ids = isset($metadata->taxes_ids) ? $metadata->taxes_ids : null;

            /* Vars */
            $payment_type = $session->subscription;
            $payment_subscription_id =  $session->subscription;

            break;

    }

    webhookProcessPayment($connect,
        $settings,
        'stripe',
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

    echo 'successful';

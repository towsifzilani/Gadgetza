<?php

    require '../core.php';

    if((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || empty($_POST['id'])) {
        die();
    }

    $mollie = new \Mollie\Api\MollieApiClient();
    $mollie->setApiKey($settings['st_mollie_api']);

    /* Retrieve the payment */
    $payment = $mollie->payments->get($_POST['id']);

    if($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) {

        if(!in_array($payment->sequenceType, ['oneoff', 'first', 'recurring'])) {
            die();
        }

    $payment_subscription_id = null;

    switch($payment->description) {
        case 'monthly':
            $plan_start_date = (new \DateTime())->modify('+1 month')->format('Y-m-d');
            break;

        case 'halfyear':
            $plan_start_date = (new \DateTime())->modify('+6 month')->format('Y-m-d');
            break;

        case 'annual':
            $plan_start_date = (new \DateTime())->modify('+1 year')->format('Y-m-d');
            break;
    }

    switch($payment->description) {
        case 'monthly':
            $plan_interval = '30 days';
            break;

        case 'halfyear':
            $plan_interval = '6 months';
            break;

        case 'annual':
            $plan_interval = '365 days';
            break;
    }

    if($payment->sequenceType == 'first') {
        /* Generate the subscription */
        try {
            $subscription = $mollie->subscriptions->createForId($payment->customerId, [
                'amount' => [
                    'currency' => $settings['st_currencycode'],
                    'value' => $payment->amount->value,
                ],
                'description' => $payment->description,
                'interval' => $plan_interval,
                'webhookUrl'  => SITE_URL . '/hooks/webhook-mollie.php',
                'startDate' => $plan_start_date
            ]);
        } catch (\Exception $exception) {
            echo $exception->getCode() . ':' . $exception->getMessage();
            http_response_code(400); die();
        }

        $payment_subscription_id = $subscription->customerId . '###' . $subscription->id;
    }

    /* Recurring payment */
    if($payment->sequenceType == 'recurring') {
        $payment_subscription_id = $payment->customerId . '###' . $payment->subscriptionId;
    }

    /* Start getting the payment details */
    $external_payment_id = $payment->id;
    $payment_total = $payment->amount->value;
    $payment_currency = $payment->amount->currency;
    $payment_type = 'recurring';

    /* Payment payer details */
    $payer_email = '';
    $payer_name = '';

    /* Process meta data */
    $metadata = $payment->metadata;
    $user_id = (int) $metadata->user_id;
    $plan_id = (int) $metadata->plan_id;
    $payment_frequency = $metadata->payment_frequency;
    $code = isset($metadata->code) ? $metadata->code : '';
    $discount_amount = isset($metadata->discount_amount) ? $metadata->discount_amount : 0;
    $base_amount = isset($metadata->base_amount) ? $metadata->base_amount : 0;
    $taxes_ids = isset($metadata->taxes_ids) ? $metadata->taxes_ids : null;

        webhookProcessPayment($connect,
            $settings,
            'mollie',
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

    


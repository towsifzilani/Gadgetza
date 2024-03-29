<?php

$getPlans = getPlans($connect);
$monthlyPlan = getMonthlyPlan($connect);
$halfYearPlan = gethalfYearPlan($connect);
$annualPlan = getAnnualPlan($connect);

$pricingFilter = array(
    [
        'interval' => $monthlyPlan,
        'label' => $translation['tr_202'],
        'key' => 'monthly'
    ],
    [
        'interval' => $halfYearPlan,
        'label' => $translation['tr_203'],
        'key' => 'halfyear'
    ],
    [
        'interval' => $annualPlan,
        'label' => $translation['tr_204'],
        'key' => 'annual'
    ]
);

require './sections/views/plans.view.php';

?>
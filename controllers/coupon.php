<?php 

require '../core.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['code']) && !empty($_POST['code'])
    && isset($_POST['frequency']) && !empty($_POST['frequency'])
    && isset($_POST['plan']) && !empty($_POST['plan'])
    ){

        $frequency = clearGetData($_POST['frequency']);
        $planId = clearGetData($_POST['plan']);
        $codeCoupon = clearGetData($_POST['code']);

        $statement = $connect->prepare("SELECT * FROM codes WHERE code_coupon = :code_coupon AND code_status = 1 LIMIT 1");
        $statement->execute(array(':code_coupon' => $codeCoupon));
        $codeDetails = $statement->fetch();
      
        if($codeDetails == false){

            $messageOutput = "<div class='uk-text-danger uk-text-small uk-text-left uk-border-rounded uk-margin-small-top uk-flex uk-flex-middle'><i class='ti ti-x uk-margin-small-right'></i> ".$translation['tr_224']."</div>";

            echo json_encode(array(
				"statusCode" => 201,
				"message" => $messageOutput,
				"value" => null,
                "discounted" => null,
                "percentage" => null
			));

        }else{

            $statement = $connect->prepare("SELECT COUNT(payment_id) AS total FROM payments WHERE payment_code = :payment_code");
            $statement->execute(array(':payment_code' => $codeDetails['code_coupon']));
            $usedQuantity = $statement->fetch()['total'];

            if($usedQuantity >= $codeDetails['code_quantity']){

                $messageOutput = "<div class='uk-text-danger uk-text-small uk-text-left uk-border-rounded uk-margin-small-top uk-flex uk-flex-middle'><i class='ti ti-x uk-margin-small-right'></i> ".$translation['tr_227']."</div>";
    
                echo json_encode(array(
                    "statusCode" => 201,
                    "message" => $messageOutput,
                    "value" => null,
                    "discounted" => null,
                    "percentage" => null
                ));

            }else{

                $statement = $connect->prepare("SELECT * FROM plans WHERE plan_id = :plan_id LIMIT 1");
                $statement->execute(array(':plan_id' => $planId));
                $planDetails = $statement->fetch();
    
                // comprobar si el coupon es habilitado para este plan

                $allowedCoupons = json_decode($planDetails['plan_codes']);

                if(!in_array($codeDetails['code_id'], $allowedCoupons)){

                    $messageOutput = "<div class='uk-text-danger uk-text-small uk-text-left uk-border-rounded uk-margin-small-top uk-flex uk-flex-middle'><i class='ti ti-x uk-margin-small-right'></i> ".$translation['tr_326']."</div>";
    
                    echo json_encode(array(
                        "statusCode" => 201,
                        "message" => $messageOutput,
                        "value" => null,
                        "discounted" => null,
                        "percentage" => null
                    ));

                }else{

                    if($frequency == "monthly"){
                        $getPrice = $planDetails['plan_monthly'];
                    }elseif($frequency == "halfyear"){
                        $getPrice = $planDetails['plan_halfyear'];
                    }elseif($frequency == "annual"){
                        $getPrice = $planDetails['plan_annual'];
                    }else{
                        $getPrice = $planDetails['plan_monthly'];
                    }
        
                    $calcPer = ($codeDetails['code_discount'] / 100) * $getPrice;
                    $totalPrice = ($getPrice - $calcPer);
        
                    $messageOutput = "<div class='uk-text-success uk-text-small uk-text-left uk-border-rounded uk-margin-small-top uk-flex uk-flex-middle'><i class='ti ti-circle-check uk-margin-small-right'></i> ".$translation['tr_226']."</div>";
        
                    echo json_encode(array(
                        "statusCode" => 200,
                        "message" => $messageOutput,
                        "value" => $totalPrice,
                        "discounted" => $calcPer,
                        "percentage" => $codeDetails['code_discount']
                    ));

                }

            }

        }

        }else{

            $messageOutput = "<div class='uk-text-danger uk-text-small uk-text-left uk-border-rounded uk-margin-small-top uk-flex uk-flex-middle'><i class='ti ti-x uk-margin-small-right'></i> ".$translation['tr_225']."</div>";

            echo json_encode(array(
				"statusCode" => 201,
				"message" => $messageOutput,
				"value" => null,
				"discounted" => null,
				"percentage" => null
			));

        }


}else{
    exit();
}

?>
<?php 

/*--------------------*/
// Description: Gadgetza - Offers & Deals Php Script
// Author: Wicombit
// Author URI: https://www.wicombit.com
/*--------------------*/

header('Content-Type: application/json');

require '../core.php';

$connect = connect($database);

if (isLogged($connect)){

    $userProfile = getUserInfo();
	$userDetails = getUserInfoById($userProfile['user_id']);

    /* check if user is seller*/

    if(isSeller()){

    switch(getTypeData()) {
        case 'chartclicks':

            $start_date = new DateTime("now", new DateTimeZone(getTimeZone()));
            $end_date = getDateByInterval(getIntervalParam());

            $sqlQuery = "SELECT tracking.*, DATE_FORMAT(track_datetime, '%Y-%m') AS months, DATE_FORMAT(track_datetime, '%Y-%m-%d') AS dias, COUNT(*) AS num, sum(case when track_is_unique = '1' then 1 else 0 end) AS uniquenum FROM tracking WHERE track_item IN (SELECT deal_id FROM deals WHERE deal_author = :deal_author)";
            
            if(getItemParam() && getItemParam() != "undefined"){
                $sqlQuery .= " AND track_item = ".getItemParam()."";
            }

            if(getIntervalParam()){

                if(getIntervalParam() && getIntervalParam() != "today"){

                    $sqlQuery .= " AND (track_datetime BETWEEN '".$end_date->format('Y-m-d 23:59:59')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

                }elseif(getIntervalParam() && getIntervalParam() == "today"){

                    $sqlQuery .= " AND (track_datetime BETWEEN '".$start_date->format('Y-m-d 00:00:00')."' AND '".$start_date->format('Y-m-d 23:59:59')."')";

                }

            }

            if(getIntervalParam() && getIntervalParam() == "last6months" || getIntervalParam() == "lastyear" || getIntervalParam() == "alltime"){
                $sqlQuery .= " GROUP BY months ORDER BY months DESC";
            }else{
                $sqlQuery .= " GROUP BY dias ORDER BY dias DESC";
            }

            $sentence = connect()->prepare($sqlQuery);
            $sentence->execute(array(
                ':deal_author' => $userDetails['user_id']
            ));
            $results = $sentence->fetchAll(PDO::FETCH_ASSOC);

            if(!$results){
                $data = array();
                echo json_encode($data);
            }else{
                foreach ($results as $row) {
                    $data[] = array(
                        //'date' => formatDate($row['track_datetime']),
                        'date' => (new \DateTime($row['track_datetime']))->format(getIntervalParam() == "last30days" || getIntervalParam() == "last7days" ? 'd-m' : 'm-Y'),
                        'clicks' => $row['num'],
                        'uniqueclicks' => $row['uniquenum']
                    );
                }
                echo json_encode($data);

            }

        break;

        case 'last10submissions':

            $sentence = $connect->prepare("SELECT deals.*, tracking.* FROM deals LEFT JOIN tracking ON deals.deal_id = tracking.track_item WHERE deals.deal_author = :deal_author GROUP BY deals.deal_id ORDER BY deal_created DESC LIMIT 10");
            $sentence->execute(array(
                ':deal_author' => $userDetails['user_id']
            ));

            $data = $sentence->fetchAll();
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData"=> $data);
            echo json_encode($results);

        break;

        case 'submissions':

            $sentence = $connect->prepare("SELECT deals.*, tracking.* FROM deals LEFT JOIN tracking ON deals.deal_id = tracking.track_item WHERE deals.deal_author = :deal_author GROUP BY deals.deal_id ORDER BY deal_created DESC");
            $sentence->execute(array(
                ':deal_author' => $userDetails['user_id']
            ));

            $data = $sentence->fetchAll();
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData"=>$data);
            echo json_encode($results);

        break;

        case 'payments':

            $sentence = $connect->prepare("SELECT payments.*, plans.*, users.*, DATE_FORMAT(payments.payment_date, '%d-%m-%Y') as date_payment FROM payments LEFT JOIN users ON payments.payment_user_id = users.user_id LEFT JOIN plans ON payments.payment_plan_id = plans.plan_id WHERE payment_user_id = :payment_user_id ORDER BY payments.payment_date DESC");
            $sentence->execute(array(
                ':payment_user_id' => $userDetails['user_id']
            ));

            $data = $sentence->fetchAll();
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData"=>$data);
            echo json_encode($results);

        break;

    }
    

}else{

    header('Location: ./denied.php');
}
    
}else{
    
    header('Location: ./home.php');

}

?>
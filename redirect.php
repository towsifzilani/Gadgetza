<?php

require_once "core.php";

$itemID = clearGetData(getItemId());

if(empty($itemID) || !isset($itemID)){

	header('Location: '. $urlPath->home());
    exit;

}else{

    $statement = $connect->prepare("SELECT * FROM deals WHERE deal_id = :deal_id AND deal_status = 1 LIMIT 1");
    $statement->execute(array(':deal_id' => $itemID));
    $result = $statement->fetch();
  
    if ($result != false) {
      
	    header('Location: '. $result['deal_link']);
        exit;

    }else{

	    header('Location: '. $urlPath->error());
        
    }

}

?>
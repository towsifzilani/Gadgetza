<?php 

require '../core.php';

$validateEmail = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $subscriber_email = filter_var(strtolower($_POST['subscriber_email']), FILTER_SANITIZE_STRING);

    if (empty($subscriber_email)) {
        echo "<div class='uk-text-danger uk-text-small uk-text-center uk-border-rounded uk-margin-small-top'>".$translation['tr_158']."</div>";
    }elseif (!filter_var($subscriber_email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='uk-text-danger uk-text-small uk-text-center uk-border-rounded uk-margin-small-top'>".$translation['tr_163']."</div>";
    }else{
        $validateEmail = true;
    }

if ($validateEmail) {

    $statement = $connect->prepare("SELECT * FROM subscribers WHERE subscriber_email = :subscriber_email LIMIT 1");
    $statement->execute(array(':subscriber_email' => $subscriber_email));
    $result = $statement->fetch();
  
    if ($result != false) {
      
        echo "<div class='uk-text-danger uk-text-small uk-text-center uk-border-rounded uk-margin-small-top'>".$translation['tr_459']."</div>";
    
    }else{

        $statement = $connect->prepare("INSERT INTO subscribers (subscriber_id, subscriber_email, subscriber_date) VALUES (null, :subscriber_email, CURRENT_TIME)");
        $statement->execute(array(
        ':subscriber_email' => $subscriber_email
        ));

        echo "<div class='uk-text-success uk-text-small uk-text-center uk-border-rounded uk-margin-small-top'>".$translation['tr_189']."</div>";
    }
}

}else{

    exit();
}


?>
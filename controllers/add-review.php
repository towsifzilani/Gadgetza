<?php 

require '../core.php';

if (!isLogged()){

    exit();

}else{

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $item = clearGetData($_POST['item']);
    $user = clearGetData($userInfo['user_id']);
    $comment = clearGetData($_POST['comment']);
    $rating = clearGetData($_POST['rating']);

    $statement = $connect->prepare("SELECT * FROM reviews WHERE user = :user AND item = :item LIMIT 1");
    $statement->execute(array(':user' => $user, ':item' => $item));
    $result = $statement->fetch();
  
    if ($result != false) {
      
        echo "<div class='uk-alert-danger uk-border-rounded' uk-alert> <p>".$translation['tr_129']."</p> </div>";
    
    }else{

        $statment = $connect->prepare("INSERT INTO reviews (id, item, user, comment, rating, created) VALUES (null, :item, :user, :comment, :rating, CURRENT_TIMESTAMP)");
    
            $statment->execute(array(
                ':item' => $item,
                ':user' => $user,
                ':comment' => $comment,
                ':rating' => $rating
                ));

        echo "<div class='uk-alert-success uk-border-rounded' uk-alert> <p>".$translation['tr_128']."</p> </div>";
    }

}

}

?>
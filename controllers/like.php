<?php 

require '../core.php';

if (!isLogged()){

    exit();

}else{

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    if (isset($_GET['action']) && $_GET['action'] == 'add') {

        $item_id = clearGetData($_POST['item']);
        $user_id = clearGetData($_POST['user']);

        $statement = $connect->prepare("SELECT * FROM favorites WHERE user = :user AND item = :item");
        $statement->execute(array(':user' => $user_id, ':item' => $item_id));
        $result = $statement->fetch();

        if ($result == false) {

        $statment = $connect->prepare("INSERT INTO favorites (id,item,user) VALUES (null, :item, :user)");

        $statment->execute(array(
            ':item' => $item_id,
            ':user' => $user_id
        ));

        echo countFormat(getLikesCountById($item_id));

        }else{
            exit();
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'remove') {

        $item_id = clearGetData($_POST['item']);
        $user_id = clearGetData($_POST['user']);
                
        $sentence = $connect->prepare("DELETE FROM favorites WHERE item = :item AND user = :user");

        $sentence->execute(array(
            ':item' => $item_id,
            ':user' => $user_id
        ));

        echo countFormat(getLikesCountById($item_id));
    }
}

}


?>
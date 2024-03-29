<?php

require '../core.php';

if(isLogged($connect)){

    $userProfile = getUserInfo();
    $userDetails = getUserInfoById($userProfile['user_id']);

    if (!empty($userDetails['user_payment_subscription_id'])) {
        header('Location: ./home.php');
    }

    include './header.php';
    require './views/canceled.view.php';
    include './footer.php';

}else{
    
    header('Location: ./login.php');
}

?>
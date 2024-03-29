<?php require 'menu.php'; ?>

<div class="content-padder">

    <div class="uk-container uk-container-large uk-padding">

    <h4><b><?php echo echoOutput($translation['tr_450']); ?></b></h4>

    <hr>

    <h4 class="uk-margin-remove"><?php echo echoOutput($translation['tr_451']); ?></h4>
    <p><?php echo echoOutput($translation['tr_452']); ?> <b><?php echo formatDate($userDetails['user_plan_expiration_date']); ?></b>.</p>
    <a href="<?php echo $urlPath->pricing(); ?>" class="uk-button uk-button-secondary uk-border-rounded" target="_blank"><?php echo echoOutput($translation['tr_453']); ?></a>
    </div>

</div>
<?php

include_once "../core.php";

$id = clearGetData($_POST['id']);
$page = clearGetData($_POST['page']);

if ($id && $page){

	$items_per_page = $site_config['reviews_page'];

    $limit = ($page > 1) ? $page * $items_per_page - $items_per_page : 0;

    $sentence = $connect->query("SELECT SQL_CALC_FOUND_ROWS reviews.*, users.* FROM reviews LEFT JOIN users ON users.user_id = reviews.user WHERE item = $id ORDER BY verified DESC, created DESC LIMIT $limit, $items_per_page");
    $sentence->execute();

    $total = $connect->query("SELECT FOUND_ROWS()")->fetchColumn();

	while ($res = $sentence->fetch(PDO::FETCH_ASSOC)){ ?>

    <article class="uk-comment review">
    <header class="uk-comment-header uk-margin-remove">
    <div class="uk-grid-small uk-flex-middle" uk-grid>
    <div class="uk-width-auto">
        <div class="avatar">
            <?php echo firstLetter($res['user_name']); ?>
        </div>
    </div>
    <div class="uk-width-expand">
    <div class="uk-grid-collapse" uk-grid>
    <div class="uk-text-left uk-width-expand">
    <span class="name uk-margin-remove"><?php echo echoOutput($res['user_name']); ?></span>
    </div>
    <div class="uk-text-right uk-width-auto"><span class="rating"><?php echo showStars($res['rating']); ?></span></div>
    </div>
    <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
        <li>
        <span>
            <?php echo formatDate($res['created']); ?>
            <?php if($res['verified']): ?>
            <span class="verified">
                <i class="ti ti-check"></i>
                <?php echo echoOutput($translation['tr_81']); ?></span>
            <?php endif; ?>
        </span>
        </li>
    </ul>
    </div>
    </div>
    </header>
    <?php if(!empty($res['comment'])): ?>
    <div class="uk-comment-body">
    <p class="comment"><?php echo echoOutput($res['comment']); ?></p>
    </div>
    <?php endif; ?>
    </article>

	<?php }

}else{
	
	exit();

}


?>

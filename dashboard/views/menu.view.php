<div uk-sticky class="uk-section-primary uk-preserve-color">
<div class="uk-navbar-container uk-navbar-transparent">
    <div class="uk-container uk-container-expand uk-dark">
        <nav uk-navbar>
            <div class="uk-navbar-left">
                <a id="sidebar_toggle" class="uk-navbar-toggle" uk-navbar-toggle-icon ></a>
                <a href="home.php" class="uk-navbar-item uk-logo">
                <img class="uk-logo-navbar" src="<?php echo $urlPath->image($theme['th_whitelogo']); ?>">
                </a>
            </div>

            <div class="uk-navbar-right uk-light uk-margin-small-right">
            <a class="uk-button uk-button-default uk-text-capitalize uk-border-rounded" href="signout.php">
            <i uk-icon="icon: sign-out"></i>
            <span class="uk-visible@s"><?php echo echoOutput($translation['tr_181']); ?></span>
            </a>
            </div>
        </nav>
    </div>
</div>
</div>

<div id="sidebar" class="tm-sidebar-left uk-background-default">
<center>
    <div class="user">
        <div class="uk-inline">
        <img id="avatar" width="100" class="uk-border-circle" src="<?php echo $urlPath->image((isset($userDetails['seller_logo']) ? $userDetails['seller_logo'] : $userDetails['user_avatar'])); ?>" />
        </div>
        <div class="uk-margin-top"></div>
        <div id="name" class="uk-text-truncate uk-text-bold">
            <?php echo echoOutput((isset($userDetails['seller_title']) ? $userDetails['seller_title'] : $userDetails['user_name'])); ?>
        </div>
        <div id="email" class="uk-text-truncate uk-text-muted"><?php echo maskEmail($userDetails['user_email']); ?></div>
    </div>
    <br />
</center>
    <ul class="uk-nav uk-nav-default uk-nav-parent-icon" data-uk-nav>
    <?php foreach($menuItems as $item): ?>
    <li><a href="<?php echo echoOutput($item['url']); ?>"><span class="uk-margin-small-right" uk-icon="icon: <?php echo echoOutput($item['icon']); ?>"></span> <?php echo echoOutput($item['title']); ?></a></li>
    <?php endforeach; ?>
    </ul>

</div>

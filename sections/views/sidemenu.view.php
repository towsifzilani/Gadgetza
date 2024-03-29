<!-- SIDEMENU -->

<div class="tas-sidemenu" id="sidemenu" uk-offcanvas="overlay: true;">

    <div class="uk-offcanvas-bar uk-flex uk-flex-column">

        <?php if(!isLogged()): ?>

        <div class="uk-width-1-1 uk-flex uk-flex-middle uk-flex-center">
            <a href="<?php echo $urlPath->home(); ?>">
            <img class="uk-logo" src="<?php echo $urlPath->image($theme['th_logo']); ?>" alt="<?php echo $translation['tr_1']; ?>">
            </a>
        </div>

        <a href="<?php echo $urlPath->signin(); ?>" class="tas-btn uk-button uk-button-primary uk-border-rounded">
        <?php echo $translation['tr_48']; ?>
        </a>
        <?php endif; ?>

        <?php if(isLogged()): ?>

            <div class="uk-flex uk-flex-left uk-padding-small">
                <article class="uk-comment tas-profile-header">
                <header class="uk-comment-header">
                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                        <div class="uk-width-auto">

                        <div class="uk-cover-container uk-border-circle">
                            <img src="<?php echo $urlPath->image($userInfo['user_avatar']); ?>" alt="<?php echo echoOutput($userInfo['user_name']); ?>" class="uk-comment-avatar" uk-cover>
                            <canvas width="50" height="50"></canvas>
                        </div>

                        </div>
                            <div class="uk-width-expand">
                        <a class="uk-link-reset" href="<?php echo $urlPath->profile(); ?>">
                            <h5 class="uk-comment-title uk-margin-remove uk-text-truncate"><?php echo echoOutput(textTruncate($userInfo['user_name'], 10)); ?></h5>
                        </a>
                            </div>
                    </div>
                </header>
            </article>
        </div>
        <?php endif; ?>


        <form class="uk-search uk-search-default uk-margin-small-top uk-margin-small-bottom" method="get" action="<?php echo $urlPath->search(); ?>">
    <span uk-search-icon></span>
    <?php if(!getSearchQuery() && empty(getSearchQuery())): ?>
                <input class="uk-search-input uk-border-rounded" name="query" placeholder="<?php echo $translation['tr_4']; ?>">
                <?php endif; ?>

                <?php if(getSearchQuery() && !empty(getSearchQuery())): ?>
                <input class="uk-search-input uk-border-rounded" name="query" value="<?php echo echoOutput(getSearchQuery()); ?>" placeholder="<?php echo $translation['tr_4']; ?>">
                <?php endif; ?>
</form>

        <ul class="tas-main-menu uk-nav-default uk-margin-small-bottom uk-margin-small-top" uk-nav>
        <?php foreach($navigationSidebar as $item): ?>
        <?php if ($item['navigation_type'] == 'custom') { ?>
        <?php if($item['navigation_url'] == '/'){ ?>
        <li><a href="<?php echo $urlPath->home(); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
        <?php }else{ ?>
        <li><a href="<?php echo $item['navigation_url']; ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
        <?php } ?>
        <?php } else { ?>
        <li><a href="<?php echo $urlPath->page($item['navigation_url']); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
        <?php } ?>
        <?php endforeach; ?>
        </ul>

        <?php if(isLogged()): ?>
        <hr class="uk-margin-small">
        <a href="<?php echo $urlPath->signout(); ?>" class="tas-btn uk-button uk-button-default uk-border-rounded">
        <?php echo $translation['tr_181']; ?>
        </a>
        <?php endif; ?>



    </div>

</div>

<!-- END SIDEMENU -->
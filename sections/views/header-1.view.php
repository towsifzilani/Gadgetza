<div class="uk-container">

    <nav class="tas_nav uk-navbar-container uk-padding-small uk-section-white uk-flex uk-flex-center uk-flex-middle uk-visible@m" uk-navbar>

    <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="<?php echo $urlPath->home(); ?>">
                <img src="<?php echo $urlPath->image($theme['th_logo']); ?>" alt="<?php echo $translation['tr_1']; ?>">
            </a>
        </div>

        <div class="uk-width-expand search">
        <form method="get" action="<?php echo $urlPath->search(); ?>">
            <div class="uk-inline uk-width-1-1">
                <span class="uk-form-icon uk-form-icon-flip btnSubmitForm"><i class="ti ti-search"></i></span>

                <?php if(!getSearchQuery() && empty(getSearchQuery())): ?>
                <input class="uk-input uk-width-1-1 uk-border-pill uk-form-large" name="query" placeholder="<?php echo $translation['tr_4']; ?>">
                <?php endif; ?>

                <?php if(getSearchQuery() && !empty(getSearchQuery())): ?>
                <input class="uk-input uk-width-1-1 uk-border-pill uk-form-large" name="query" value="<?php echo echoOutput(getSearchQuery()); ?>" placeholder="<?php echo $translation['tr_4']; ?>">
                <?php endif; ?>

            </div>
            </form>
        </div>

        <div class="uk-navbar-right">

        <?php if (isLogged()): ?>

            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                <div class="uk-cover-container uk-border-circle">
                    <img src="<?php echo $urlPath->image($userInfo['user_avatar']); ?>" alt="<?php echo echoOutput($userInfo['user_name']); ?>" uk-cover>
                    <canvas width="50" height="50"></canvas>
                </div>
                </div>
                <div class="uk-width-expand">
                    <h5 class="uk-margin-remove-bottom uk-text-bold"><?php echo echoOutput(textTruncate($userInfo['user_name'], 10)); ?></h5>
                    <p class="uk-comment-meta uk-margin-remove-top"><a href="<?php echo $urlPath->profile(); ?>" class="uk-link-muted"><?php echo $translation['tr_10']; ?></a></p>
                </div>
            </div>

        <?php endif; ?>

        <?php if (!isLogged()): ?>

            <a href="<?php echo $urlPath->signin(); ?>" class="uk-button uk-button-primary uk-button-large uk-text-bold uk-border-pill button-header">
                <i class="ti ti-lock"></i> <?php echo $translation['tr_5']; ?>
            </a>

        <?php endif; ?>

        </div>

    </nav>

</div>
<!-- END MAIN NAVBAR -->

<!-- MAIN NAVBAR -->

<div class="uk-section-primary uk-preserve-color">
<nav class="uk-container tas_nav uk-navbar-container uk-navbar-transparent uk-visible@m" uk-navbar>

    <div class="uk-navbar-center">
        <ul class="uk-navbar-nav">
        <?php foreach($navigationHeader as $item): ?>
                 <?php if ($item['navigation_type'] == 'custom') { ?>
                    <?php if($item['navigation_url'] == '/'){ ?>
                    <li <?php if ($index_url == "index.php") echo ' class="uk-active"'; ?>><a href="<?php echo $urlPath->home(); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
                    <?php }else{ ?>
                    <li <?php if ($current_url == $item['navigation_url']) echo ' class="uk-active"'; ?>><a href="<?php echo $item['navigation_url']; ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
                    <?php } ?>
                 <?php } else { ?>
                     <li <?php if ($current_url == $item['navigation_url']) echo ' class="uk-active"'; ?>><a href="<?php echo $urlPath->page($item['navigation_url']); ?>" target="<?php echo $item['navigation_target']; ?>"><?php echo echoOutput($item['navigation_label']); ?></a></li>
                 <?php } ?>
             <?php endforeach; ?>
        </ul>
    </div>

</nav>

</div>

<!-- END MAIN NAVBAR -->

<?php require './sections/mobile-header.php'; ?>

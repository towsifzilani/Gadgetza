<!-- HEADER -->
<?php require './sections/header.php'; ?>

    <!-- PAGE TITLE -->
    
    <div class="page-title uk-section uk-section-small uk-section-default uk-margin-remove">
    <div class="uk-container">
        <h3 class="uk-heading-line uk-text-center uk-text-left@m"><span><?php echo echoOutput($translation['tr_profilepage']) ?></span></h3>
        </div>
    </div>

<!-- END PAGE TITLE -->

<!-- PAGE CONTENT -->

<div class="uk-container">
<div class="uk-grid-medium" uk-grid>

        <div class="uk-width-1-3@s uk-width-1-4@m">

            <div class="profile uk-box-shadow-small uk-border-rounded uk-padding">

                <div class="uk-block uk-margin-remove uk-text-center">
                    <div class="uk-inline uk-margin">

                    <div class="uk-cover-container uk-border-pill uk-box-shadow-small">
                        <img src="<?php echo $urlPath->image($userDetails['user_avatar']); ?>" alt="<?php echo echoOutput($userDetails['user_name']); ?>" uk-cover>
                        <canvas width="130" height="130"></canvas>
                    </div>
                    </div>

                </div>

                <div class="uk-margin uk-margin-remove-top uk-text-center">
                    <div class="uk-flex uk-flex-middle uk-flex-center">
                    <a class="uk-link-reset"><p class="uk-text-bold uk-margin-remove"><?php echo echoOutput($userDetails['user_name']); ?></p></a>
                    </div>
                    <p class="uk-text-muted uk-text-small uk-margin-remove"><?php echo maskEmail($userDetails['user_email']); ?></p>
                </div>

                <hr>

                <ul class="uk-list">
				    <?php if(isAdmin()): ?>
				    <li><a class="uk-link-muted" href="<?php echo $urlPath->admin(); ?>"><span class="uk-margin-small-right" uk-icon="icon: cog"></span> <?php echo echoOutput($translation['tr_179']); ?></a></li>
					<?php endif; ?>
				    <?php if(isSeller()): ?>
				    <li><a class="uk-link-muted" href="<?php echo $urlPath->dashboard(); ?>"><span class="uk-margin-small-right" uk-icon="icon: cart"></span> <?php echo echoOutput($translation['tr_267']); ?></a></li>
					<?php endif; ?>
				    <li><a class="uk-link-muted" href="<?php echo $urlPath->profile('edit'); ?>"><span class="uk-margin-small-right" uk-icon="icon: file-edit"></span> <?php echo echoOutput($translation['tr_180']); ?></a></li>
				    <li><a class="uk-link-muted" href="<?php echo $urlPath->profile('favorites'); ?>"><span class="uk-margin-small-right" uk-icon="icon: heart"></span> <?php echo echoOutput($translation['tr_182']); ?></a></li>
                </ul>

                <hr>

                <a class="uk-button uk-button-secondary uk-text-truncate uk-border-rounded uk-width-1-1" href="<?php echo $urlPath->signout(); ?>">
                <?php echo echoOutput($translation['tr_181']); ?>
            </a>

        </div>

    </div>

<div class="uk-width-expand">

<?php if (!isset($_GET['action'])): ?>

<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_profilepage']); ?></span></h5>

<div class="uk-grid-small uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>

<div>
<dl class="uk-description-list">
    <dt><?php echo echoOutput($translation['tr_139']); ?></dt>
    <dd class="uk-text-light"><?php echo echoOutput($userInfo['user_name']); ?></dd>
</dl>
</div>

<div>
<dl class="uk-description-list">
    <dt><?php echo echoOutput($translation['tr_145']); ?></dt>
    <dd class="uk-text-light"><?php echo echoOutput($userInfo['user_email']); ?></dd>
</dl>
</div>

</div>

<div class="uk-margin-top">
<dl class="uk-description-list">
    <dt><?php echo echoOutput($translation['tr_92']); ?></dt>
    <dd class="uk-text-light"><?php echo echoOutput($userInfo['user_description']); ?></dd>
</dl>
</div>

<div class="uk-margin-top">
<dl class="uk-description-list">
    <dt><?php echo echoOutput($translation['tr_178']); ?></dt>
    <dd class="uk-text-light"><?php echo memberSince($userInfo['user_created']); ?></dd>
</dl>
</div>

<?php endif;?>

<?php if (isEditing()): ?>

<?php require './views/edit-profile.view.php'; ?>

<?php endif;?>

<?php if (isFavorites()): ?>

<?php require './views/favorites-profile.view.php'; ?>

<?php endif;?>

</div>

</div>
</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

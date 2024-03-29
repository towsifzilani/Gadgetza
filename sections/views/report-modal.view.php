<div id="report-modal" class="uk-flex-top" uk-modal>
    <div class="tas-modal uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="modal_title"><?php echo echoOutput($translation['tr_346']); ?></h2>
        </div>

        <div class="uk-modal-body">

        <?php if (isLogged()): ?>

        <form class="uk-form" method="post" id="reportForm">

        <div class="form_fields">
            
        <input value="<?php echo $itemDetails['deal_id']; ?>" name="item_id" type="text" hidden>
        <input value="<?php echo $itemDetails['deal_title']; ?>" name="item_title" type="text" hidden>
        <input value="<?php echo $urlPath->image($itemDetails['deal_image']); ?>" name="item_image" type="text" hidden>
        <input value="<?php echo $urlPath->deal($itemDetails['deal_id'], $itemDetails['deal_slug']); ?>" name="item_url" type="text" hidden>

<div class="uk-margin-small">
        <div class="uk-width-1-1 uk-inline">
        <span class="uk-form-icon" uk-icon="icon: user"></span>
        <input class="uk-input uk-border-rounded uk-form-large" placeholder="<?php echo echoOutput($translation['tr_139']); ?>" name="name" type="text" required="">
        </div>
        </div>

<div class="uk-margin-small">
        <div class="uk-width-1-1 uk-inline">
        <span class="uk-form-icon" uk-icon="icon: mail"></span>
        <input class="uk-input uk-border-rounded uk-form-large" placeholder="<?php echo echoOutput($translation['tr_145']); ?>" name="email" type="email" required="">
        </div>
        </div>

        <textarea class="uk-width-1-1 uk-textarea uk-border-rounded uk-margin-small-top" name="message" cols="30" rows="3" placeholder="<?php echo echoOutput($translation['tr_348']); ?>" required=""></textarea>
        <button type="submit" class="uk-button uk-button-primary uk-margin-small-top uk-border-rounded" value="<?php echo echoOutput($translation['tr_349']); ?>" id="btn-report"><?php echo echoOutput($translation['tr_349']); ?></button>
        
        </div>

        <div id="showReportresults"></div>

        </form>
            
        <?php endif; ?>

        <?php if (!isLogged()): ?>

        <p><?php echo echoOutput($translation['tr_347']); ?></p>
        <a href="<?php echo $urlPath->signin(); ?>" class="uk-button uk-button-primary uk-border-rounded"><?php echo echoOutput($translation['tr_48']); ?></a>
            
        <?php endif; ?>

        </div>

    </div>
</div>
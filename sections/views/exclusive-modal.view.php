<div id="exclusive-modal" class="uk-flex-top" uk-modal>
    <div class="tas-modal uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="modal_title"><?php echo echoOutput($translation['tr_22']); ?></h2>
        </div>

        <div class="uk-modal-body">

        <p><?php echo echoOutput($translation['tr_119']); ?></p>
        <a href="<?php echo $urlPath->signin(); ?>" class="uk-button uk-button-primary uk-border-rounded"><?php echo echoOutput($translation['tr_48']); ?></a>

        </div>

    </div>
</div>
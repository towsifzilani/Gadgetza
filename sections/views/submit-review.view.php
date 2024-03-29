<div id="submit-review" class="uk-flex-top" uk-modal>
    <div class="tas-modal uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="modal_title"><?php echo echoOutput($translation['tr_118']); ?></h2>
        </div>

        <div class="uk-modal-body">

        <?php if (isLogged()): ?>

        <form class="uk-form" method="post" id="formRating">

        <div class="form_fields">

        <input value="<?php echo $itemDetails['deal_id']; ?>" name="item" type="text" hidden>

        <select id="rating-form" name="rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>

        <textarea class="uk-width-1-1 uk-textarea uk-border-rounded uk-margin-small-top" name="comment" cols="30" rows="3" placeholder="<?php echo echoOutput($translation['tr_125']); ?>"></textarea>
        <button type="submit" class="uk-button uk-button-primary uk-margin-small-top uk-border-rounded" value="<?php echo echoOutput($translation['tr_126']); ?>" id="btn-review"><?php echo echoOutput($translation['tr_126']); ?></button>
        
        </div>
        
        <div id="showReviewresults"></div>

        </form>
            
        <?php endif; ?>

        <?php if (!isLogged()): ?>

        <p><?php echo echoOutput($translation['tr_124']); ?></p>
        <a href="<?php echo $urlPath->signin(); ?>" class="uk-button uk-button-primary uk-border-rounded"><?php echo echoOutput($translation['tr_48']); ?></a>
            
        <?php endif; ?>

        </div>

    </div>
</div>
<?php require 'menu.php'; ?>

<div class="content-padder uk-background-muted">

    <div class="uk-section-small">
        <div class="uk-container uk-container-large">     

        <form enctype="multipart/form-data" class="uk-form-stacked" id="seller-update-form" method="post">

        <input type="hidden" value="<?php echo echoOutput($userDetails['user_id']); ?>" name="user_id">
        <input type="hidden" value="<?php echo echoOutput((isset($sellerDetails['seller_id']) ? $sellerDetails['seller_id'] : '')); ?>" name="seller_id">
        <input type="hidden" value="<?php echo echoOutput((isset($sellerDetails['seller_user']) ? $sellerDetails['seller_user'] : '')); ?>" name="seller_user">

        <div uk-grid>

        <!-- EXPAND BLOCK -->
        <div class="uk-width-1-1 uk-width-expand@m">

        <div id="errors" class="uk-width-1-1 uk-text-left" style="display: none;">
        <div class="uk-margin">
        <div class="tas-notify tas-notify-danger uk-border-rounded uk-margin-remove uk-padding-small">
        <ul class="uk-margin-remove" id="errorsMsg">
        </ul>
        </div>
        </div>
        </div>

        <div id="success" class="uk-width-1-1 uk-text-left" style="display: none;">
        <div class="uk-margin">
        <div class="tas-notify tas-notify-success uk-border-rounded uk-margin-remove uk-padding-small">
        <ul class="uk-margin-remove" id="successMsg">
        </ul>
        </div>
        </div>
        </div>

        <?php if(hasStore($userDetails['user_id'])): ?>
        <div class="uk-width-1-1 uk-margin-bottom uk-text-right">
        <a class="uk-button uk-button-secondary uk-text-capitalize uk-border-rounded" target="_blank" href="<?php echo $urlPath->user($sellerDetails['seller_slug']); ?>">
        <i uk-icon="icon: link"></i>
        <span><?php echo echoOutput($translation['tr_455']); ?></span>
        </a>
        </div>
        <?php endif; ?>

        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_241']); ?></span></h3>

        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_274']); ?> <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput((isset($sellerDetails['seller_title']) ? $sellerDetails['seller_title'] : '')); ?>" maxlength="100" name="seller_title" required="">
        </div>

        <input class="uk-input uk-border-rounded" type="hidden" value="<?php echo echoOutput((isset($sellerDetails['seller_slug']) ? $sellerDetails['seller_slug'] : '')); ?>" name="seller_slug">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_276']); ?></label>
        <textarea type="text" class="uk-textarea uk-border-rounded" maxlength="350" name="seller_description"><?php echo echoOutput((isset($sellerDetails['seller_description']) ? $sellerDetails['seller_description'] : '')); ?></textarea>
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_443']); ?></label>
        <input class="uk-input uk-border-rounded" type="url" placeholder="https://example.com" pattern="https://.*" value="<?php echo echoOutput((isset($sellerDetails['seller_website']) ? $sellerDetails['seller_website'] : '')); ?>" name="seller_website">
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_371']); ?> <b class="uk-text-danger">*</b>
        <?php if(isset($sellerDetails['seller_logo']) && !empty($sellerDetails['seller_logo'])): ?>
        <div class="uk-inline" style="margin-bottom: 2px;margin-left:5px" uk-lightbox><a href="<?php echo $urlPath->image($sellerDetails['seller_logo']); ?>">Preview</a></div>
        <?php endif; ?>
        </label>

        <div class="uk-margin">
        <input type="hidden" name="seller_logo_save" value="<?php echo echoOutput((isset($sellerDetails['seller_logo']) ? $sellerDetails['seller_logo'] : '')); ?>"/>
        <div uk-form-custom="target: true">
            <input type="file" name="seller_logo">
            <input class="uk-input uk-form-width-medium uk-border-rounded" type="text" placeholder="Select file" disabled>
            <button class="uk-button uk-button-default uk-border-rounded padding-left-5 padding-right-5" type="button" tabindex="-1"><span uk-icon="folder"></span></button>
        </div>
        </div>
        <p class="uk-text-danger uk-text-small uk-margin-remove"><?php echo echoOutput($translation['tr_312']); ?> 350x350px </p>
        <p class="uk-text-small uk-margin-remove"><?php echo echoOutput($translation['tr_192']); ?></p>
        </div>

        </div>

        </div>

        <hr>

        <div class="uk-margin">
        <button class="uk-button uk-button-success uk-flex-center uk-flex uk-flex-middle uk-border-rounded uk-text-capitalize" value="<?php echo echoOutput($translation['tr_291']); ?>" type="submit"><?php echo echoOutput($translation['tr_291']); ?> <span id="loading" class="uk-margin-small-left"></span></button>
        </div>

        </div>

        </div>

        </div>
        <!-- EXPAND BLOCK -->

    </form>
</div>
</div>
</div>
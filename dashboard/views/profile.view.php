<?php require 'menu.php'; ?>

<div class="content-padder uk-background-muted">

    <div class="uk-section-small">
        <div class="uk-container uk-container-large">     

        <form enctype="multipart/form-data" class="uk-form-stacked" id="profile-update-form" method="post">

        <input type="hidden" value="<?php echo $userDetails['user_id']; ?>" name="user_id">

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

        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_244']); ?></span></h3>

        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_139']); ?> <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput($userDetails['user_name']); ?>" maxlength="100" name="user_name" required="">
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_145']); ?> <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput($userDetails['user_email']); ?>" name="user_email" disabled>
        </div>

        <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_184']); ?></label>
        <div class="uk-form-controls">
        <input type="text" value="<?php echo echoOutput($userDetails['user_password']); ?>" id="user_password_save" name="user_password_save" hidden>
        <input class="uk-input uk-border-rounded" id="user_password" name="user_password" type="password">
        </div>
        </div>

        <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_185']); ?></label>
        <div class="uk-form-controls">
        <input class="uk-input uk-border-rounded" id="user_confirm_password" name="user_confirm_password" type="password">
        </div>
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_92']); ?></label>
        <textarea type="text" class="uk-textarea uk-border-rounded" rows="3" maxlength="255" name="user_description"><?php echo echoOutput($userDetails['user_description']); ?></textarea>
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_133']); ?> <b class="uk-text-danger">*</b> <div class="uk-inline" style="margin-bottom: 2px;margin-left:5px" uk-lightbox><a href="<?php echo $urlPath->image($userDetails['user_avatar']); ?>">Preview</a></div></label>

        <div class="uk-margin">
        <input type="hidden" name="user_avatar_save" value="<?php echo echoOutput($userDetails['user_avatar']); ?>"/>
        <div uk-form-custom="target: true">
            <input type="file" name="user_avatar">
            <input class="uk-input uk-form-width-medium uk-border-rounded" type="text" placeholder="Select file" disabled>
            <button class="uk-button uk-button-default uk-border-rounded padding-left-5 padding-right-5" type="button" tabindex="-1"><span uk-icon="folder"></span></button>
        </div>
        </div>
        <p class="uk-text-danger uk-text-small uk-margin-remove"><?php echo echoOutput($translation['tr_312']); ?> 350x350px </p>
        <p class="uk-text-small uk-margin-remove"><?php echo echoOutput($translation['tr_192']); ?></p>
        </div>

        </div>

        </div>

        </div>

        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered uk-margin-top">

<h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_325']); ?></span></h3>

<div class="uk-grid-small" uk-grid>

<div class="uk-width-1-1">

<div class="uk-grid-small billing" uk-grid>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_356']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-border-rounded" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_name : null); ?>" type="text" name="user_billing_name">
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_357']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_address : null); ?>" name="user_billing_address" required="">
    </div>
    <div class="uk-width-1-2@s">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_358']); ?> <small class="uk-text-danger">*</small></label>
        <select class="nice-select wide uk-select uk-border-rounded" name="user_billing_country" required="">
        <?php foreach($countriesArray as $item => $value){
        if((!empty($userBilling) ? $userBilling->user_billing_country : 0) == $item){
        echo '<option value="'.$item.'" selected="selected">'.$value.'</option>';
        }else{
        echo '<option value="'.$item.'">'.$value.'</option>';
        }
        }
        ?>
        </select>
        </select>
    </div>
    <div class="uk-width-1-4@s">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_359']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_city : null); ?>" name="user_billing_city" required="">
    </div>
    <div class="uk-width-1-4@s">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_360']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_zip : null); ?>" name="user_billing_zip" required="">
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_361']); ?></label>
        <input class="uk-input uk-border-rounded" type="tel" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_phone : null); ?>" name="user_billing_phone">
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_362']); ?></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_company : null); ?>" name="user_billing_company">
        <p class="uk-text-muted uk-text-small"><?php echo echoOutput($translation['tr_363']); ?></p>
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_364']); ?></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo echoOutput(!empty($userBilling) ? $userBilling->user_billing_tax_id : null); ?>" name="user_billing_tax_id">
    </div>
    </div>

<hr>

<div class="uk-margin">
<button class="uk-button uk-button-success uk-flex-center uk-flex uk-flex-middle uk-border-rounded uk-text-capitalize" value="<?php echo echoOutput($translation['tr_291']); ?>" type="submit"><?php echo echoOutput($translation['tr_291']); ?> <span id="loading" class="uk-margin-small-left"></span></button>
</div>

<hr>

<a class="deleteAccount uk-text-danger" data-url="delete_account.php?id=<?php echo $userDetails['user_id']; ?>"><?php echo echoOutput($translation['tr_456']); ?></a>

</div>

        </div>

        </div>

        </div>

        </div>

        <!-- EXPAND BLOCK -->

    </form>
</div>
</div>
</div>
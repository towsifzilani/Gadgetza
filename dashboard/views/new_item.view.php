<?php require 'menu.php'; ?>

<div class="content-padder">
    <div class="uk-section-small uk-background-muted">
        <div class="uk-container uk-container-large">   
            
        <?php if(isset($planDetails) && !empty($planDetails)): ?>
        <?php if($userTotalOUploaded >= $planDetails['plan_total'] && $planDetails['plan_total'] != -1): ?>
        <div class="uk-border-rounded uk-flex uk-flex-middle tas-notify tas-notify-warning uk-margin-bottom">
        <p class="uk-margin-remove"><?php echo echoOutput($translation['tr_445']); ?></p>
        <a class="uk-margin-small-left uk-button uk-button-default uk-text-bold uk-border-rounded uk-button-small uk-text-warning" href="<?php echo $urlPath->pricing(); ?>"><?php echo echoOutput($translation['tr_248']); ?></a>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <form enctype="multipart/form-data" class="uk-form-stacked" id="submission-form" method="post">

        <input type="hidden" value="<?php echo $userDetails['user_id']; ?>" name="deal_author">

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

        <div id="formInputs">

        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_293']); ?></span></h3>

        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_274']); ?> <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="text" maxlength="100" name="deal_title" required="">
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_276']); ?></label>
        <textarea type="text" class="advancedtinymce uk-textarea" name="deal_description"></textarea>
        </div>


        </div>

        </div>

        </div>


        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_294']); ?></span></h3>


        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-2@s">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_277']); ?> <b class="uk-text-danger">*</b></label>
        <select class="uk-select uk-border-rounded" name="deal_category" id="categories-dropdown" required="">
        <option value="">---</option>
        <?php foreach($getCategories as $item){
        echo '<option value="'.$item['category_id'].'">'.$item['category_title'].'</option>';
        } ?>
        </select>
        </div>

        </div>

        <div class="uk-width-1-2@s">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_278']); ?></label>
        <select class="uk-select uk-border-rounded" name="deal_subcategory" id="subcategories-dropdown">
        <option value="">---</option>
        <?php foreach($getSubCategories as $item){
        echo '<option value="'.$item['subcategory_id'].'">'.$item['subcategory_title'].'</option>';
        } ?>
        </select>
        </div>

        </div>

        <div class="uk-width-1-2@s">
        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_279']); ?></label>
        <select class="uk-select uk-border-rounded" name="deal_store">
        <option value="">---</option>
            <?php foreach($getStores as $item){
            echo '<option value="'.$item['store_id'].'">'.$item['store_title'].'</option>';
            }
            ?>
        </select>
        </div>
        </div>

        <div class="uk-width-1-2@s">
        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_280']); ?></label>
        <select class="uk-select uk-border-rounded" name="deal_location">
        <option value="">---</option>
            <?php foreach($getLocations as $item){
                echo '<option value="'.$item['location_id'].'">'.$item['location_title'].'</option>';
            }
            ?>
        </select>
        </div>
        </div>

        <div class="uk-width-1-1">
        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_275']); ?></label>
        <input class="uk-input uk-border-rounded" type="text" maxlength="200" name="deal_tagline">
        </div>
        </div>

        </div>

        </div>

<div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_295']); ?></span></h3>


        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-2@s">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_281']); ?> (<?php echo echoOutput($settings['st_currencycode']); ?>) <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="number" name="deal_price" required="">

        </div>

        </div>

        <div class="uk-width-1-2@s">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_282']); ?> (<?php echo echoOutput($settings['st_currencycode']); ?>)</label>
        <input class="uk-input uk-border-rounded" type="number" name="deal_oldprice">

        </div>

        </div>

        </div>

        </div>

<div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_296']); ?></span></h3>


        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_286']); ?> <b class="uk-text-danger">*</b></label>

        <div class="uk-margin">
        <div uk-form-custom="target: true">
            <input type="file" name="deal_image">
            <input class="uk-input uk-form-width-medium uk-border-rounded" type="text" placeholder="Select file" disabled>
            <button class="uk-button uk-button-default uk-border-rounded padding-left-5 padding-right-5" type="button" tabindex="-1"><span uk-icon="folder"></span></button>
        </div>
        </div>
        <p class="uk-text-danger uk-text-small uk-margin-remove"><?php echo echoOutput($translation['tr_312']); ?> 650x350px </p>
        <p class="uk-text-small uk-margin-remove"><?php echo echoOutput($translation['tr_192']); ?></p>
        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_287']); ?> <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="url" pattern="https://.*" name="deal_link" required="">

        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_288']); ?> (<b>Youtube/Vimeo</b>) </label>
        <input class="uk-input uk-border-rounded" type="text" name="deal_video">

        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_289']); ?></label>
        <input class="uk-input uk-border-rounded" type="text" name="deal_gif">

        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_300']); ?></label>
        <input type="file" name="files">

        </div>
            
        </div>

        </div>

        </div>


        <div class="uk-margin">
<button class="uk-button uk-button-success uk-flex-center uk-flex uk-flex-middle uk-border-rounded uk-text-capitalize" value="<?php echo echoOutput($translation['tr_292']); ?>" type="submit">
<span id="loadingText"><?php echo echoOutput($translation['tr_292']); ?></span> <span id="loading" class="uk-margin-small-left"></span>
</button>
</div>

</div>

        </div>
        <!-- EXPAND BLOCK -->


        <!-- SIDEMENU -->
        <div class="uk-width-1-1 uk-width-1-3@m">
            
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

        <h4 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_440']); ?></span></h4>

        <p><?php echo echoOutput($translation['tr_441']); ?></p>

        <p><?php echo $translation['tr_442']; ?></p>

        </div>

        </div>
        
        <!-- SIDEMENU BLOCK -->

        </div>
    </form>
</div>
</div>
</div>

<script>
    'use strict';
$(document).ready(function() {

  // enable fileuploader plugin
  $('input[name="files"]').fileuploader({
    limit: 8,
    fileMaxSize: 1,
    extensions: ['jpg', 'png', 'jpeg'],
    addMore: true
  });
  
});
</script>
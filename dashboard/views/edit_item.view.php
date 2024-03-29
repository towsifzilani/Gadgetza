<?php require 'menu.php'; ?>

<div class="content-padder">

    <div class="uk-section-small uk-background-muted">
        <div class="uk-container uk-container-large">     

        <form enctype="multipart/form-data" class="uk-form-stacked" id="update-form" method="post">

        <input type="hidden" value="<?php echo $userDetails['user_plan']; ?>" name="user_plan">
        <input type="hidden" value="<?php echo $itemDetails['deal_author']; ?>" name="deal_author">
        <input type="hidden" value="<?php echo $itemDetails['deal_id']; ?>" name="deal_id">
        <input type="hidden" value="<?php echo $itemDetails['deal_slug']; ?>" name="deal_slug">

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

        <?php if(!empty($itemDetails['reviewer_message'])): ?>
        <div class="uk-border-rounded tas-notify tas-notify-info uk-margin-bottom">
        <p class="uk-margin-remove"><?php echo echoOutput($translation['tr_454']); ?></p>
        <hr class="uk-margin-small">
        <p class="uk-margin-remove uk-text-emphasis"><?php echo echoOutput($itemDetails['reviewer_message']); ?></p>
        </div>
        <?php endif; ?>

        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_293']); ?></span></h3>

        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_274']); ?> <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo $itemDetails['deal_title']; ?>" maxlength="100" name="deal_title" required="">
        <input class="uk-input uk-border-rounded" type="hidden" value="<?php echo $itemDetails['deal_slug']; ?>" name="deal_slug">
        </div>

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_276']); ?></label>
        <textarea type="text" class="advancedtinymce uk-textarea" name="deal_description"><?php echo $itemDetails['deal_description']; ?></textarea>
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
        if($itemDetails['deal_category'] == $item['category_id']){
        echo '<option value="'.$itemDetails['deal_category'].'" selected="selected">'.$item['category_title'].'</option>';
        }else{
        echo '<option value="'.$item['category_id'].'">'.$item['category_title'].'</option>';
            }
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
        if($itemDetails['deal_subcategory'] == $item['subcategory_id']){
        echo '<option value="'.$itemDetails['deal_subcategory'].'" selected="selected">'.$item['subcategory_title'].'</option>';
        }else{
        echo '<option value="'.$item['subcategory_id'].'">'.$item['subcategory_title'].'</option>';
            }
        } ?>
        </select>
        </div>

        </div>

        <div class="uk-width-1-2@s">
        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_279']); ?></label>
        <select class="uk-select uk-border-rounded" name="deal_store">
            <?php foreach($getStores as $item){
            if($itemDetails['deal_store'] == $item['store_id']){
            echo '<option value="'.$itemDetails['deal_store'].'" selected="selected">'.$item['store_title'].'</option>';
            } else{
            echo '<option value="'.$item['store_id'].'">'.$item['store_title'].'</option>';
                }
            }
            ?>
        </select>
        </div>
        </div>

        <div class="uk-width-1-2@s">
        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_280']); ?></label>
        <select class="uk-select uk-border-rounded" name="deal_location">
            <?php foreach($getLocations as $item){
            if($itemDetails['deal_location'] == $item['location_id']){
                echo '<option value="'.$itemDetails['deal_category'].'" selected="selected">'.$item['location_title'].'</option>';
            } else{
                echo '<option value="'.$item['location_id'].'">'.$item['location_title'].'</option>';
                }
            }
            ?>
        </select>
        </div>
        </div>

        <div class="uk-width-1-1">
        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_275']); ?></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo $itemDetails['deal_tagline']; ?>" maxlength="200" name="deal_tagline">
        </div>
        </div>

        <input class="uk-input uk-border-rounded" type="hidden" value="<?php echo $itemDetails['deal_expire']; ?>" name="deal_expire">

        </div>

        </div>

<div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_295']); ?></span></h3>


        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-2@s">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_281']); ?> (<?php echo echoOutput($settings['st_currencycode']); ?>) <b class="uk-text-danger">*</b></label>
        <input class="uk-input uk-border-rounded" type="number" value="<?php echo $itemDetails['deal_price']; ?>" name="deal_price" required="">

        </div>

        </div>

        <div class="uk-width-1-2@s">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_282']); ?> (<?php echo echoOutput($settings['st_currencycode']); ?>)</label>
        <input class="uk-input uk-border-rounded" type="number" value="<?php echo $itemDetails['deal_oldprice']; ?>" name="deal_oldprice">

        </div>

        </div>

        </div>

        </div>

<div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

        <h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_296']); ?></span></h3>


        <div class="uk-grid-small" uk-grid>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_286']); ?> <b class="uk-text-danger">*</b> <div class="uk-inline" style="margin-bottom: 2px;margin-left:5px" uk-lightbox><a href="<?php echo $urlPath->image($itemDetails['deal_image']); ?>">Preview</a></div></label>

        <div class="uk-margin">
        <input type="hidden" name="deal_image_save" value="<?php echo $itemDetails['deal_image']; ?>"/>
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
        <input class="uk-input uk-border-rounded" type="url" pattern="https://.*" value="<?php echo $itemDetails['deal_link']; ?>" name="deal_link" required="">

        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_288']); ?> (<b>Youtube/Vimeo</b>) <div class="uk-inline" style="margin-bottom: 2px;margin-left:5px" uk-lightbox><a href="<?php echo $itemDetails['deal_video']; ?>">Preview</a></div></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo $itemDetails['deal_video']; ?>" name="deal_video">

        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_289']); ?> <div class="uk-inline" style="margin-bottom: 2px;margin-left:5px" uk-lightbox><a href="<?php echo $itemDetails['deal_gif']; ?>">Preview</a></div></label>
        <input class="uk-input uk-border-rounded" type="text" value="<?php echo $itemDetails['deal_gif']; ?>" name="deal_gif">

        </div>

        </div>

        <div class="uk-width-1-1">

        <div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_300']); ?></label>
        <input type="file" name="files">

        </div>

        <div class="uk-grid-small uk-child-width-1-3 uk-child-width-1-4@s uk-child-width-1-6@m uk-text-center" uk-grid>
            <?php foreach($itemGallery as $item): ?>
                <div>
                    <div uk-lightbox>
                    <a href="<?php echo $urlPath->image($item['picture']); ?>">
                    <div class="uk-cover-container uk-border-rounded">
                        <canvas width="100" height="100"></canvas>
                        <img src="<?php echo $urlPath->image($item['picture']); ?>" uk-cover>
                    </div>
                    </a>
                    </div>
                    <a class="uk-text-small uk-text-danger deleteItem" data-url="./delete_gallery.php?id=<?php echo $item['id']; ?>"><?php echo echoOutput($translation['tr_272']); ?></a>
                    <?php if($item['status'] == 0): ?>
                        <span uk-icon="info" uk-tooltip="Pending approval"></span>
                    <?php endif; ?>
                </div>
                <?php endforeach;?>

        </div>
            
        </div>

        </div>

        </div>


        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-margin-medium-bottom uk-card-bordered">

<h3 class="uk-heading-line uk-margin-medium-bottom uk-text-bold"><span><?php echo echoOutput($translation['tr_297']); ?></span></h3>


<div class="uk-grid-small" uk-grid>

<div class="uk-width-1-1">

<div class="uk-margin">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_298']); ?><b class="uk-text-danger">*</b></label>
        <textarea type="text" class="uk-textarea uk-border-rounded" name="author_message" required=""></textarea>
        </div>

</div>

</div>

<!--<div class="uk-flex uk-flex-right uk-margin-top">

<div class="uk-width-1-1 uk-width-1-4@m">
<button class="uk-button uk-button-primary uk-flex-center uk-flex uk-flex-middle uk-width-1-1 uk-border-rounded uk-text-capitalize" value="<?php echo echoOutput($translation['tr_291']); ?>" type="submit">
<?php echo echoOutput($translation['tr_291']); ?>
<span id="loading" class="uk-margin-small-left"></span>
</button>
</div>

</div>-->

</div>

        </div>
        <!-- EXPAND BLOCK -->

        <!-- SIDEMENU BLOCK -->
        <div class="uk-width-1-1 uk-width-1-4@m">
            
        <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

        <h3 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_299']); ?></span></h3>

        <dl class="uk-description-list uk-description-list-divider item-info">
            <dt><?php echo echoOutput($translation['tr_270']); ?></dt>
            <dd>
            <?php if ($itemDetails['deal_status'] == 1) {
                echo '<span class="uk-text-success uk-text-capitalize">'.$translation['tr_250'].'</span>';
            }else if ($itemDetails['deal_status'] == 2) {
                echo '<span class="uk-text-warning uk-text-capitalize">'.$translation['tr_251'].'</span>';
            }else if ($itemDetails['deal_status'] == 3) {
                echo '<span class="uk-text-warning uk-text-capitalize">'.$translation['tr_252'].'</span>';
            }else if ($itemDetails['deal_status'] == 4) {
                echo '<span class="uk-text-danger uk-text-capitalize">'.$translation['tr_266'].'</span>';
            }else if ($itemDetails['deal_status'] == 5) {
                echo '<span class="uk-text-warning uk-text-capitalize">'.$translation['tr_447'].'</span>';
            } ?>
            </dd>
            <dt><?php echo echoOutput($translation['tr_268']); ?></dt>
            <dd><?php echo formatDate($itemDetails['deal_created']); ?></dd>
            <dt><?php echo echoOutput($translation['tr_269']); ?></dt>
            <dd><?php echo formatDate($itemDetails['deal_updated']); ?></dd>

            <?php if(!empty($itemDetails['deal_expire'])): ?>
            <dt><?php echo echoOutput($translation['tr_446']); ?></dt>
            <dd><?php echo formatDate($itemDetails['deal_expire']); ?></dd>
            <?php endif; ?>

        </dl>

        </div>

        <div class="uk-margin-top uk-margin-large-bottom">
        <div class="uk-child-width-1-1 uk-grid-small" uk-grid>
        <?php if($itemDetails['deal_status'] != 4): ?>
        <?php if($itemDetails['deal_status'] == 1): ?>
        <div><a class="uk-button uk-button-warning uk-flex-center uk-flex uk-flex-middle uk-width-1-1 uk-border-rounded uk-text-capitalize disableItem" data-url="disable_item.php?id=<?php echo echoOutput($itemDetails['deal_id']); ?>"><?php echo echoOutput($translation['tr_273']); ?> <span class="uk-margin-small-left" uk-icon="ban"></span></a></div>
        <?php endif; ?>
        <?php if($itemDetails['deal_status'] == 2): ?>
        <div><a class="uk-button uk-button-primary uk-flex-center uk-flex uk-flex-middle uk-width-1-1 uk-border-rounded uk-text-capitalize enableItem" data-url="enable_item.php?id=<?php echo echoOutput($itemDetails['deal_id']); ?>"><?php echo echoOutput($translation['tr_321']); ?> <span class="uk-margin-small-left" uk-icon="check"></span></a></div>
        <?php endif; ?>
        <!--<div><a class="uk-button uk-button-danger uk-flex-center uk-flex uk-flex-middle uk-width-1-1 uk-border-rounded uk-text-capitalize deleteItem" data-url="delete_item.php?id=<?php echo $itemDetails['deal_id']; ?>" data-redirect="submissions.php"><?php echo echoOutput($translation['tr_272']); ?> <span class="uk-margin-small-left" uk-icon="trash"></span></a></div>-->
        <?php if($itemDetails['deal_status'] == 1 || $itemDetails['deal_status'] == 5): ?>
        <div><button class="uk-button uk-button-success uk-flex-center uk-flex uk-flex-middle uk-width-1-1 uk-border-rounded uk-text-capitalize" value="<?php echo echoOutput($translation['tr_291']); ?>" type="submit"><?php echo echoOutput($translation['tr_291']); ?> <span id="loading" class="uk-margin-small-left"></span></button></div>
        <?php endif; ?>
        </div>
        <?php endif; ?>

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

  $('input[name="files"]').fileuploader({
    limit: <?= (8-count($itemGallery)); ?>,
    fileMaxSize: <?= (allowedFileSize()/1024/1024); ?>,
    extensions: <?= json_encode(allowedFileExt()); ?>,
    addMore: true
  });
  
});
</script>

<?php if($itemDetails['page_show_title'] == 1): ?>
<?php include './sections/page-title.php'; ?>
<?php else: ?>
<div class="uk-margin-medium-top"></div>
<?php endif; ?>

<?php if($itemDetails['page_ad_header'] == 1): ?>
<?php include './sections/views/header-ad.view.php'; ?>
<?php endif; ?>

<?php if(!empty($itemDetails['page_content'])): ?>
<div class="uk-container">
<div class="uk-width-1-1">
<?php echo $itemDetails['page_content']; ?>
</div>
</div>
<?php endif; ?>

<div class="uk-container uk-margin-large-top">

<div class="uk-text-center">
<h2 class="uk-text-bold"><?php echo echoOutput($translation['tr_376']); ?></h2>
<h4 class="uk-margin-small"><?php echo echoOutput($translation['tr_377']); ?></h4>
</div>

</div>

<div class="uk-container uk-margin-top">
    <?php include './sections/plans.php'; ?>
</div>

<div class="uk-section uk-section-muted uk-margin-large-top uk-margin-large-bottom">
    <div class="uk-container">

<div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
        <div class="uk-width-expand">
            <h3 class="uk-heading-line uk-text-center"><span><?php echo echoOutput($translation['tr_378']); ?></span></h3>
        </div>
</div>

<div class="uk-grid-large uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>
    <div>
        <h4 class="uk-text-bold"><?php echo echoOutput($translation['tr_379']); ?></h4>
        <p><?php echo echoOutput($translation['tr_380']); ?></p>
    </div>

    <div>
        <h4 class="uk-text-bold"><?php echo echoOutput($translation['tr_381']); ?></h4>
        <p><?php echo echoOutput($translation['tr_382']); ?></p>
    </div>

    <div>
        <h4 class="uk-text-bold"><?php echo echoOutput($translation['tr_383']); ?></h4>
        <p><?php echo echoOutput($translation['tr_384']); ?></p>
    </div>

    <div>
        <h4 class="uk-text-bold"><?php echo echoOutput($translation['tr_385']); ?></h4>
        <p><?php echo echoOutput($translation['tr_386']); ?></p>
    </div>
</div>

</div>
</div>

<div class="uk-container">

<div class="uk-text-center">
<h4><?php echo echoOutput($translation['tr_387']); ?></h4>

<a class="uk-button uk-button-primary uk-border-rounded" href="<?php echo $urlPath->contact(); ?>"><?php echo echoOutput($translation['tr_388']); ?></a>
</div>

</div>


<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE CONTENT -->

<div class="uk-container uk-flex uk-flex-center">

<div class="uk-text-center uk-margin-large-top uk-width-1-1 uk-width-1-2@m">

    <i class="ti ti-circle-check uk-heading-large uk-text-success uk-margin-medium-top"></i>
    <h3 class="uk-text-bold uk-margin-small-top uk-text-emphasis"><?php echo echoOutput($translation['tr_327']); ?></h3>
    <p><?php echo echoOutput($translation['tr_328']); ?></p>

    <a href="<?php echo $urlPath->dashboard(); ?>" class="uk-button uk-button-default uk-border-rounded">
    <?php echo echoOutput($translation['tr_329']); ?>
    </a>

</div>

</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

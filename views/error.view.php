<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE CONTENT -->

<div class="uk-container uk-flex uk-flex-center">

<div class="uk-text-center uk-margin-large-top uk-width-1-1 uk-width-1-2@m">

    <i class="ti ti-mood-sad uk-heading-large uk-text-danger uk-margin-medium-top"></i>
    <h4 class="uk-text-bold uk-margin-small-top uk-text-emphasis"><?php echo echoOutput($translation['tr_epsubtitle']); ?></h4>
    <p><?php echo echoOutput($translation['tr_eptagline']); ?></p>

    <a href="<?php echo $urlPath->home(); ?>" class="uk-button uk-button-default uk-border-rounded">
    <?php echo echoOutput($translation['tr_epbutton']); ?>
    </a>

</div>

</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

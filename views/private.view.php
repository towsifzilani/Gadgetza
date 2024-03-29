<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE CONTENT -->

<div class="uk-container uk-flex uk-flex-center">

<div class="uk-text-center uk-margin-large-top uk-width-1-1 uk-width-1-2@m">

    <i class="ti ti-eye-off uk-heading-large uk-text-danger uk-margin-medium-top"></i>
    <h4 class="uk-text-bold uk-margin-small-top uk-text-emphasis"><?php echo echoOutput($translation['tr_333']); ?></h4>
    <p><?php echo echoOutput($translation['tr_353']); ?></p>

    <a href="<?php echo $urlPath->signin(); ?>" class="uk-button uk-button-default uk-border-rounded">
    <?php echo echoOutput($translation['tr_154']); ?>
    </a>

</div>

</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE CONTENT -->

<div class="uk-container uk-flex uk-flex-center">

<div class=" uk-text-center uk-margin-large-top uk-width-1-1 uk-width-1-2@m">

<?php if(!empty($success)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-success uk-text-small uk-border-rounded uk-margin-remove">
<ul class="uk-margin-remove">
<li><?php echo echoOutput($success); ?></li>
</ul>
</div>
</div>
</div>
<?php endif; ?>

<?php if(!empty($errors) && empty($verifiedAlready)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove">
<ul class="uk-margin-remove">
<?php foreach($errors as $key => $value):?>
<li><?php echo echoOutput($value); ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>
<?php endif; ?>

<?php if(!empty($verifiedAlready)): ?>

<i class="ti ti-circle-check uk-heading-large uk-text-success uk-margin-medium-top"></i>
<h3 class="uk-text-bold uk-margin-small-top uk-text-emphasis"><?php echo echoOutput($translation['tr_339']); ?></h3>
<p><?php echo echoOutput($translation['tr_337']); ?></p>

<?php endif; ?>

<?php if(empty($verifiedAlready) && empty($errors) && empty($success)): ?>

    <i class="ti ti-mail-forward uk-heading-large uk-text-success uk-margin-medium-top"></i>
    <h3 class="uk-text-bold uk-margin-small-top uk-text-emphasis"><?php echo echoOutput($translation['tr_340']); ?></h3>
    <p><?php echo echoOutput($translation['tr_335']); ?></p>

    <p class="uk-margin-large-top uk-text-small"><?php echo echoOutput($translation['tr_341']); ?></p>

    <form action="<?php echo htmlspecialchars($urlPath->verify(['user' => clearGetData($_GET['user'])])); ?>" method="post">
    <input name="user_email" type="hidden" value="<?php echo clearGetData($_GET['user']); ?>">
    <button class="uk-button uk-button-default uk-border-rounded" type="submit">
    <?php echo echoOutput($translation['tr_342']); ?>
    </button>
    </form>

<?php endif; ?>


</div>

</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

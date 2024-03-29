<!-- HEADER -->
<?php require './sections/header.php'; ?>

<!-- PAGE CONTENT -->

<div class="uk-container uk-flex uk-flex-center">

<div class="uk-text-center uk-margin-large-top uk-width-1-1 uk-width-1-2@m">

<?php if(!empty($errors) && empty($success)): ?>
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

<?php if(!empty($success) && empty($errors)): ?>

<i class="ti ti-circle-check uk-heading-large uk-text-success uk-margin-medium-top"></i>
<h3 class="uk-text-bold uk-margin-small-top uk-text-emphasis"><?php echo echoOutput($translation['tr_343']); ?></h3>
<p><?php echo echoOutput($translation['tr_344']); ?></p>

<?php endif; ?>


</div>

</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

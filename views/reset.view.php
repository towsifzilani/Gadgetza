<div class="uk-height-1-1 tas-section-padding-v-s uk-panel uk-flex uk-flex-wrap uk-flex-middle uk-flex-center" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">

<div class="tas-auth-1">

<a href="<?php echo $urlPath->home(); ?>">
<img class="tas-logo" src="<?php echo $urlPath->image($theme['th_logo']); ?>">
</a>

<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_156']); ?></span></h5>

<?php if(empty($errors_reset) && empty($success)): ?>

<form class="uk-form" action="" name="update" method="post">

<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-border-pill" placeholder="<?php echo echoOutput($translation['tr_184']); ?>" name="new_password" type="password" required="">
</div>
</div>

<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-border-pill" placeholder="<?php echo echoOutput($translation['tr_185']); ?>" name="confirm_password" type="password" required="">
</div>
</div>

<?php if(!empty($errors_update)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove">
<ul class="uk-margin-remove">
<?php foreach($errors_update as $key => $value):?>
<li><?php echo echoOutput($value); ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>
<?php endif; ?>

<button class="uk-button uk-button-primary uk-width-1-1 uk-border-pill" type="submit"><?php echo echoOutput($translation['tr_150']); ?></button>

<div class="uk-margin uk-width-1-1 uk-link uk-text-center">
<a class="uk-link" href="<?php echo $urlPath->signin(); ?>"><?php echo echoOutput($translation['tr_157']); ?></a>
</div>

</form>

<?php endif; ?>

<?php if(!empty($success)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-success uk-text-small uk-border-rounded uk-margin-remove">
<p><i class="fas fa-check uk-margin-small-right"></i> <?php echo echoOutput($success); ?></p>
</div>
</div>
</div>
<?php endif; ?>

<?php if(!empty($errors_reset)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove">
<ul class="uk-margin-remove">
<?php foreach($errors_reset as $key => $value):?>
<li><?php echo echoOutput($value); ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>
<?php endif; ?>

</div>

</div>
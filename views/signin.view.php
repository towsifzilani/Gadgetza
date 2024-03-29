<div class="uk-position-top-right uk-position-z-index uk-padding-small">
<a onclick="goBack()" uk-close></a>
</div>

<div class="uk-height-1-1 tas-section-padding-v-s uk-panel uk-flex uk-flex-wrap uk-flex-middle uk-flex-center" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">

<div class="tas-auth-1">

<a href="<?php echo $urlPath->home(); ?>">
<img class="tas-logo" src="<?php echo $urlPath->image($theme['th_logo']); ?>">
</a>

<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_144']); ?></span></h5>

<form class="uk-form" action="<?php echo htmlspecialchars($urlPath->signin()); ?>" method="post">

<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-border-pill" placeholder="<?php echo echoOutput($translation['tr_145']); ?>" name="user_email" type="email" required="">
</div>
</div>
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<input class="uk-input uk-border-pill" placeholder="<?php echo echoOutput($translation['tr_146']); ?>" name="user_password" type="password" required="">
</div>
</div>

<?php if(!empty($errors)): ?>
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

<button class="uk-button uk-button-primary uk-width-1-1 uk-border-pill" type="submit"><?php echo echoOutput($translation['tr_150']); ?></button>

<div class="uk-margin uk-width-1-1">
<a class="uk-margin uk-link uk-display-block" href="<?php echo $urlPath->forgot(); ?>"><?php echo echoOutput($translation['tr_148']); ?></a>
<?php echo echoOutput($translation['tr_147']); ?> <a class="tas-link-primary uk-text-bold" href="<?php echo $urlPath->signup(); ?>"><?php echo echoOutput($translation['tr_149']); ?></a>
</div>

</form>

</div>

</div>



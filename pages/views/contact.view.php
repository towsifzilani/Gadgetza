<?php if($itemDetails['page_show_title'] == 1): ?>
<?php include './sections/page-title.php'; ?>
<?php else: ?>
<div class="uk-margin-medium-top"></div>
<?php endif; ?>

<?php if($itemDetails['page_ad_header'] == 1): ?>
<?php include './sections/views/header-ad.view.php'; ?>
<?php endif; ?>

<div class="uk-container">

<div class="uk-grid-large" uk-grid>

<div class="uk-width-expand@m">

<h3 class="uk-text-bold uk-margin-small-bottom"><?php echo echoOutput($translation['tr_229']); ?></h3>
<p class="uk-margin-small-top uk-margin-medium-bottom"><?php echo echoOutput($translation['tr_230']); ?></p>

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

<?php if(!empty($success)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-success uk-text-small uk-border-rounded uk-margin-remove">
<p><i class="fas fa-check uk-margin-small-right"></i> <?php echo echoOutput($success); ?></p>
</div>
</div>
</div>
<?php endif; ?>

<form class="tas-contact-1 uk-grid-small uk-margin-medium-top" action="<?php echo htmlspecialchars($urlPath->contact()); ?>" method="post" id="submit-form" uk-grid>
<div class="uk-width-1-2@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: user"></span>
<input class="uk-input uk-border-rounded uk-form-large" placeholder="<?php echo echoOutput($translation['tr_139']); ?>" id="name" name="name" type="text" required="">
</div>

</div>
</div>
<div class="uk-width-1-2@s">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: receiver"></span>
<input class="uk-input uk-border-rounded uk-form-large" placeholder="<?php echo echoOutput($translation['tr_140']); ?>" name="phone" type="text">
</div>

</div>
</div>
<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<span class="uk-form-icon" uk-icon="icon: mail"></span>
<input class="uk-input uk-border-rounded uk-form-large" placeholder="<?php echo echoOutput($translation['tr_145']); ?>" name="email" type="email" required="">
</div>

</div>
</div>

<div class="uk-width-1-1">
<div class="uk-margin">
<div class="uk-width-1-1 uk-inline">
<textarea class="uk-textarea uk-border-rounded uk-form-large" rows="3" placeholder="<?php echo echoOutput($translation['tr_141']); ?>" name="message" required=""></textarea>
</div>

</div>
</div>

<div class="uk-width-1-1 uk-text-left uk-margin-small-left">
<label id="checked">
<input class="uk-checkbox uk-margin-small-right" type="checkbox" name="ischecked" required=""> <span class="tas-checkbox-label" style="max-width: 450px"> <span class="uk-link-reset"> <?php echo echoOutput($translation['tr_155']); ?> <a class="uk-link-reset" target="_blank" href="<?php echo $urlPath->privacy(); ?>"> <b><?php echo echoOutput($defaultPrivacyPage['page_title']); ?></b></a>, <a class="uk-link-reset" target="_blank" href="<?php echo $urlPath->terms(); ?>"> <b><?php echo echoOutput($defaultTermsPage['page_title']); ?></b></a></span></span></label>
</div>

<div class="uk-width-1-1 uk-width-1-4@s">
<div class="uk-margin">
<?php if($settings['st_recaptcha_enable'] == 1): ?>
    <button class="g-recaptcha uk-button uk-button-primary uk-border-rounded uk-width-1-1" type="submit" data-sitekey="<?php echo echoOutput($settings['st_recaptchakey']); ?>" data-callback="onRecaptchaSuccess">
	<?php echo echoOutput($translation['tr_143']); ?>
	</button>
<?php else: ?>
    <button class="uk-button uk-button-primary uk-border-rounded uk-width-1-1" type="submit">
	<?php echo echoOutput($translation['tr_143']); ?>
	</button>
<?php endif; ?>

</div>
</div>


</form>

</div>

</div>

<?php if(!empty($itemDetails['page_content'])): ?>
<div class="uk-width-1-1">
<?php echo $itemDetails['page_content']; ?>
</div>
<?php endif; ?>

</div>
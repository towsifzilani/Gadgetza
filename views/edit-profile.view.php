<h5 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_180']); ?></span></h5>

<div class="update-profile">

<form class="uk-child-width-1-1 uk-child-width-1-1@s uk-margin-medium-top" uk-grid enctype="multipart/form-data" method="post">

<input type="hidden" name="user_id" id="user_id" value="<?php echo echoOutput($userInfo['user_id']); ?>">

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_139']); ?></label>
<div class="uk-form-controls">
<input class="uk-input uk-border-rounded" type="text" id="user_name" maxlength="100" name="user_name" value="<?php echo echoOutput($userInfo['user_name']); ?>">
</div>
</div>

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_184']); ?></label>
<div class="uk-form-controls">
<input type="text" value="<?php echo echoOutput($userInfo['user_password']); ?>" id="user_password_save" name="user_password_save" hidden>
<input class="uk-input uk-border-rounded" id="user_password" name="user_password" type="password">
</div>
</div>

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_185']); ?></label>
<div class="uk-form-controls">
<input class="uk-input uk-border-rounded" id="user_confirm_password" name="user_confirm_password" type="password">
</div>
</div>

<div>
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_92']); ?></label>
<div class="uk-form-controls">
<textarea class="uk-textarea uk-border-rounded uk-padding-small" rows="5" maxlength="255" id="user_description" name="user_description"><?php echo echoOutput($userInfo['user_description']); ?></textarea>
</div>
</div>

<div class="uk-width-1-1">
<label class="uk-form-label" for="form-stacked-text"><?php echo echoOutput($translation['tr_133']); ?></label>

<div class="new-image" id="image-preview" style="background: url(<?php echo $urlPath->image($userInfo['user_avatar']); ?>); height: 200px; width: 200px;margin-top: 5px;">
  <label for="image-upload" id="image-label"><?php echo echoOutput($translation['tr_113']); ?></label>
  <input type="file" id="image-upload" name="user_avatar" />
  <input type="text" value="<?php echo echoOutput($userInfo['user_avatar']); ?>" id="user_avatar_save" name="user_avatar_save" hidden>
</div>

</div>

<div class="uk-width-1-1">

<hr>

<button class="uk-button uk-button-primary uk-border-rounded" value="<?php echo echoOutput($translation['tr_186']); ?>" type="submit" id="submit-send"><?php echo echoOutput($translation['tr_186']); ?></button>
<a class="uk-button uk-button-default uk-border-rounded" onclick="window.history.back();"><?php echo echoOutput($translation['tr_187']); ?></a>

<div id="showresults"></div>

</div>

</form>
</div>

</div>
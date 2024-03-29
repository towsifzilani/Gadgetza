<div class="uk-height-1-1 ev-section-padding-v-s uk-panel uk-flex uk-flex-wrap uk-flex-middle uk-flex-center">

<div class="uk-container-small ev-section-padding-h-m">

	<div class="uk-flex uk-flex-middle" uk-grid>

	<div class="uk-width-1-1 uk-width-1-2@s uk-text-center uk-text-left@s">
		<img src="<?php echo $urlPath->assets_img('offline.gif'); ?>">
	</div>

	<div class="uk-width-1-1 uk-width-1-2@s uk-text-center uk-text-left@s">
		<h2 class="uk-margin-small uk-text-bold"><?php echo echoOutput($translation['tr_maintenancetitle']); ?></h2>
		<h4 class="uk-margin-small uk-text-light"><?php echo echoOutput($translation['tr_maintenancesub']); ?></h4>

		<hr class="uk-divider-small">

		<?php foreach($socialMedia as $item): ?>
		<?php if (!empty($item['st_facebook'])): ?>
		<a class="uk-icon-button" href="<?php echo $item['st_facebook'] ?>" uk-icon="icon: facebook;"></a>
		<?php endif;?>
		<?php if (!empty($item['st_twitter'])): ?>
		<a class="uk-icon-button" href="<?php echo $item['st_twitter'] ?>" uk-icon="icon: twitter"></a>
		<?php endif;?>
		<?php if (!empty($item['st_youtube'])): ?>
		<a class="uk-icon-button" href="<?php echo $item['st_youtube'] ?>" uk-icon="icon: youtube"></a>
		<?php endif;?>
		<?php if (!empty($item['st_linkedin'])): ?>
		<a class="uk-icon-button" href="<?php echo $item['st_linkedin'] ?>" uk-icon="icon: linkedin"></a>
		<?php endif;?>
		<?php if (!empty($item['st_instagram'])): ?>
		<a class="uk-icon-button" href="<?php echo $item['st_instagram'] ?>" uk-icon="icon: instagram"></a>
		<?php endif;?>
		<?php if (!empty($item['st_whatsapp'])): ?>
		<a class="uk-icon-button" href="<?php echo $item['st_whatsapp'] ?>" uk-icon="icon: whatsapp"></a>
		<?php endif;?>
		<?php endforeach; ?>
		</ul>

	</div>
		
	</div>

</div>

</div>


<!--<script type="text/javascript">    
setInterval(function() {
    window.location.reload();
}, 30000); // Refresh Every 3 Min
</script>-->



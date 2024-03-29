<?php if ($itemDetails['page_ad_header'] == 1): ?>
<?php if(!empty($headerAd)): ?>
<div class="tas_ads uk-container uk-margin-large-bottom">
<div class="uk-width-1-1 uk-text-center">
<?php foreach($headerAd as $item): ?>
<?php echo $item['ad_html']; ?>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
<?php endif; ?>
<?php if ($itemDetails['page_ad_footer'] == 1): ?>
<?php if(!empty($footerAd)): ?>
<div class="tas_ads uk-container uk-margin-large-top">
<div class="uk-width-1-1 uk-text-center">
<?php foreach($footerAd as $item): ?>
<?php echo $item['ad_html']; ?>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
<?php endif; ?>
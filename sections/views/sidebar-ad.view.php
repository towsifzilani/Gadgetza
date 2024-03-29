<?php if (isset($itemDetails['page_ad_sidebar']) && $itemDetails['page_ad_sidebar'] == 1): ?>
<?php if(!empty($sidebarAd)): ?>
<div class="ev-container">
<div class="uk-width-1-1">
<div class="ev-sidebar-ads">
<?php foreach($sidebarAd as $item): ?>

<div class="ev-item">
<?php echo $item['ad_html']; ?>
</div>	

<?php endforeach; ?>
</div>
</div>
</div>
<?php endif; ?>
<?php endif; ?>
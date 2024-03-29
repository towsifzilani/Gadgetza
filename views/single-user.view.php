
<?php require './sections/header.php'; ?>

<div class="uk-container">

<div class="uk-grid-large" uk-grid uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">

<div class="uk-width-expand@m">

<div class="uk-grid-medium uk-margin-large-top uk-margin-medium-bottom" uk-grid>

<div class="uk-width-auto@s">

<div class="uk-border-pill uk-box-shadow-small profile_image" style="background: url(<?php echo $urlPath->image($itemDetails['seller_logo']); ?>);">
</div> 

</div>

<div class="uk-width-expand@s">

<div class="uk-width-1-1 uk-text-center uk-text-left@s">
<div class="uk-flex uk-flex-middle uk-flex-center uk-flex-left@s uk-margin-small-bottom">
<h3 class="uk-text-bold uk-margin-remove"><?php echo echoOutput($itemDetails['seller_title']) ?></h3>
<span class="pro_badge"><?php echo echoOutput($translation['tr_201']); ?></span>
</div>
<?php if(!empty($itemDetails['seller_description'])): ?>
<h5 class="uk-margin-small-top uk-margin-bottom uk-text-muted">
<?php echo echoOutput($itemDetails['seller_description']); ?>
</h5>
<?php endif; ?>

<div class="uk-grid-divider uk-flex uk-flex-center uk-flex-left@s uk-grid-medium uk-margin-small-top uk-margin-medium-bottom" uk-grid>

<div>
	<h5 class="uk-margin-remove uk-text-small"><?php echo echoOutput($translation['tr_178']); ?></h5>
	<p class="uk-margin-remove uk-text-muted uk-text-small"><?php echo memberSince($itemDetails['seller_created']); ?></p>
</div>

<div>
	<h5 class="uk-margin-remove uk-text-small"><?php echo echoOutput($translation['tr_443']); ?></h5>
	<p class="uk-margin-remove uk-text-muted uk-text-small"><a class="uk-text-muted" href="<?php echo echoOutput($itemDetails['seller_website']); ?>" target="_blank"><?php echo echoOutput($translation['tr_444']); ?> <i class="ti ti-external-link"></i></a></p>
</div>

</div>

</div>

</div>

</div>

</div>

</div>

<div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
<div class="uk-width-expand">
<h3 class="uk-heading-line uk-text-left"><span><?php echo echoOutput($translation['tr_436']); ?></span></h3>
</div>
</div>

<?php if(!empty($items)): ?>

<div class="uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid>

<?php foreach($items as $item): ?>

<div>

<a href="<?php echo $urlPath->deal($item['deal_id'], $item['deal_slug']); ?>">

<div class="tas_card_1">

<div class="exclusive">
<div class="uk-card uk-card-default uk-border-rounded">
<div class="uk-card-media-top uk-cover-container">
<img src="<?php echo !empty($item['deal_gif']) ? echoOutput($item['deal_gif']) : $urlPath->image($item['deal_image']); ?>" alt="<?php echo echoOutput($item['deal_title']); ?>" uk-cover>
<canvas width="600" height="300"></canvas>

<?php if(timeLeft(echoOutput($item['deal_expire']), $translation)): ?>
<div class="uk-overlay tas_time uk-overlay-default uk-position-bottom">
<p><i class="ti ti-clock"></i> <span><?php echo timeLeft(echoOutput($item['deal_expire']), $translation); ?></span></p>
</div>
<?php endif; ?>

</div>

<div class="uk-card-body">

<div class="rating uk-flex uk-flex-middle"><?php echo showStars($item['deal_rating']); ?> <?php if($item['total_reviews'] > 1):; ?> <span class="uk-text-small uk-text-light uk-margin-small-left">(<?php echo echoOutput($item['total_reviews']); ?> <?php echo echoOutput($translation['tr_49']); ?>) </span> <?php endif; ?></div>
<div class="brand"><?php echo echoOutput($item['category_title']); ?></div>

<?php if($item['deal_exclusive'] == 1): ?>
<div class="badge exclusive_badge"><?php echo echoOutput($translation['tr_16']); ?></div>
<?php endif; ?>

<h2 class="uk-card-title uk-text-truncate"><?php echo echoOutput($item['deal_title']); ?></h2>
<p class="uk-card-subtitle uk-text-truncate"><?php echo echoOutput($item['deal_tagline']); ?></p>

<ul class="uk-subnav" uk-margin>
<?php if(!empty(echoOutput($item['deal_oldprice']))): ?>
<li><span class="oldprice"><?php echo getPrice($item['deal_oldprice']); ?></span></li>
<?php endif; ?>
<li><span class="price"><?php echo getPrice($item['deal_price']); ?></span></li>
<?php if(!empty(echoOutput($item['deal_oldprice']))): ?>
<li><span class="discount"><?php echo getPercent($item['deal_price'], $item['deal_oldprice'], $translation); ?></span></li>
<?php endif; ?>
</ul>
</div>
</div>
</div>
</div>
</a>
</div>

<?php endforeach; ?>

            </div>

            <?php endif; ?>

            <?php if(empty($items)): ?>
                <div class="uk-width-1-1 uk-flex uk-flex-center uk-text-center uk-margin-large-top">
                <div class="uk-width-1-1 uk-width-1-2@s">
                <h3 class="uk-text-bold uk-margin-small"><?php echo echoOutput($translation['tr_109']); ?></h3>
                </div>
                </div>
            <?php endif; ?>


<?php require './sections/pagination.php'; ?>

</div>

<?php require './sections/footer.php'; ?>
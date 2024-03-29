<div class="uk-hidden">
<div itemtype="https://schema.org/Product" itemscope>
      <meta itemprop="name" content="<?php echo echoOutput($itemDetails['deal_title']); ?>" />
      <link itemprop="image" href="<?php echo $urlPath->image($itemDetails['deal_image']); ?>" />
      <meta itemprop="description" content="<?php echo echoOutput($itemDetails['deal_tagline']); ?>" />
      <div itemprop="offers" itemtype="https://schema.org/Offer" itemscope>
        <link itemprop="url" href="<?php echo $urlPath->deal($itemDetails['deal_id'], $itemDetails['deal_slug']); ?>" />
        <meta itemprop="availability" content="https://schema.org/InStock" />
        <meta itemprop="priceCurrency" content="USD" />
        <meta itemprop="itemCondition" content="https://schema.org/UsedCondition" />
        <meta itemprop="price" content="<?php echo getPriceNoCurrency($itemDetails['deal_price']); ?>" />
		<?php if($itemDetails['deal_expire']): ?>
        <meta itemprop="priceValidUntil" content="<?php echo echoOutput($itemDetails['deal_expire']); ?>" />
		<?php endif; ?>
      </div>
      <div itemprop="aggregateRating" itemtype="https://schema.org/AggregateRating" itemscope>
        <meta itemprop="reviewCount" content="<?php echo echoOutput($itemDetails['total_reviews']); ?>" />
        <meta itemprop="ratingValue" content="<?php echo formatRating($itemDetails['deal_rating']); ?>" />
      </div>
	  <?php if($itemDetails['store_title']): ?>
      <div itemprop="brand" itemtype="https://schema.org/Brand" itemscope>
        <meta itemprop="name" content="<?php echo echoOutput($itemDetails['store_title']); ?>" />
      </div>
	  <?php endif; ?>
    </div>
</div>

<?php require './sections/header.php'; ?>

<?php if(!empty($headerAd)): ?>
<div class="tas_ads uk-container uk-margin-medium-top uk-margin-small-bottom">
<div class="uk-width-1-1 uk-text-center">
<?php foreach($headerAd as $item): ?>
<?php echo $item['ad_html']; ?>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

<div class="uk-container uk-margin-medium-top">
<div class="tas_single">

<div class="uk-width-1-1 uk-margin-bottom">

<?php if(isExclusive(echoOutput($itemDetails['deal_exclusive']))): ?>
<div class="top_exclusive"><?php echo echoOutput($translation['tr_16']); ?></div>
<?php endif; ?>

<ul class="breadcrumb uk-breadcrumb">
<?php if(!empty($itemDetails['category_title'])): ?>
<li><a href="<?php echo $urlPath->search(['category' => $itemDetails['category_slug']]); ?>" class="single_link"><?php echo echoOutput($itemDetails['category_title']); ?></a></li>
<?php endif; ?>
<?php if(!empty($itemDetails['subcategory_title'])): ?>
<li><a href="<?php echo $urlPath->search(['subcategory' => $itemDetails['subcategory_slug']]); ?>" class="single_link"><?php echo echoOutput($itemDetails['subcategory_title']); ?></a></li>
<?php endif; ?>
</ul>

<h1 class="single_title"><?php echo echoOutput($itemDetails['deal_title']); ?></h1>
<h2 class="single_subtitle"><?php echo echoOutput($itemDetails['deal_tagline']); ?></h2>

</div>

<div class="uk-grid-medium uk-grid-match" uk-grid>

<div class="uk-width-1-1 uk-width-expand@m">

<?php if(isExpired(echoOutput($itemDetails['deal_expire']))): ?>
<div class="tas_alert_danger uk-alert-danger" uk-alert>
    <p><?php echo echoOutput($translation['tr_37']); ?></p>
</div>
<?php endif; ?>

<div uk-slideshow="animation: slide">

<div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
<div uk-lightbox>

<ul class="uk-slideshow-items">
<li>
<a href="<?php echo $urlPath->image($itemDetails['deal_image']); ?>">
<img src="<?php echo $urlPath->image($itemDetails['deal_image']); ?>" uk-cover>

<?php if(!empty($itemDetails['deal_video'])): ?>
<div class="uk-position-center">
<span class="uk-transition-fade">
<a class="play-btn" href="//www.youtube.com/watch?v=<?php echo echoOutput($itemDetails['deal_video']); ?>" data-lity>
<i class="ion-play"></i>
</a>
</span>
</div>
<?php endif; ?>

</a>
</li>

<?php foreach($itemsGallery as $item): ?>
<li>
<a href="<?php echo $urlPath->image($item['picture']); ?>">
<img src="<?php echo $urlPath->image($item['picture']); ?>" uk-cover>
</a>
</li>
<?php endforeach; ?>
</ul>

</div>

<a class="uk-position-center-left uk-position-small uk-hidden-hover nextprevbtn" href="#" uk-slidenav-previous uk-slideshow-item="previous"><i class="ti ti-chevron-left"></i></a>
<a class="uk-position-center-right uk-position-small uk-hidden-hover nextprevbtn" href="#" uk-slidenav-next uk-slideshow-item="next"><i class="ti ti-chevron-right"></i></a>

</div>

<div class="uk-margin-small uk-visible@m">
<ul class="thumbnav uk-thumbnav">
<li class="uk-active" uk-slideshow-item="0">
<a href="#">
<img src="<?php echo $urlPath->image($itemDetails['deal_image']); ?>" width="100">
<?php if(!empty($itemDetails['deal_video'])): ?>
<div class="uk-position-center">
<span class="play-btn-thumnav">
<i class="ion-play"></i>
</span>
</div>
<?php endif; ?>
</a>
</li>

<?php $i = 1; ?>
<?php foreach($itemsGallery as $item): ?>
<li uk-slideshow-item="<?php echo $i++; ?>">
<a href="#">
<img src="<?php echo $urlPath->image($item['picture']); ?>" width="100">
</a>
</li>
<?php endforeach; ?>
</ul>
</div>

</div>

</div>

<div class="uk-width-1-1 uk-width-1-3@m top_side">

<div>

<?php if(formatRating($itemDetails['deal_rating']) >= 4.5): ?>
<div class="toprated">
<i class="ion-android-star"></i>
<?php echo echoOutput($translation['tr_88']); ?>
</div>
<?php endif; ?>

<?php if(isNew($itemDetails['deal_start'])): ?>
<div class="newitem">
<i class="ion-flash"></i>
<?php echo echoOutput($translation['tr_20']); ?>
</div>
<?php endif; ?>


<div class="uk-flex uk-flex-middle">
<?php if(!empty(echoOutput($itemDetails['deal_oldprice']))): ?>
<h3 class="oldprice"><?php echo getPrice($itemDetails['deal_oldprice']); ?></h3>
<?php endif; ?>

<h3 class="price"><?php echo getPrice($itemDetails['deal_price']); ?></h3>
<?php if(!empty(echoOutput($itemDetails['deal_oldprice']))): ?>
<h3 class="discount"><?php echo getPercent($itemDetails['deal_price'], $itemDetails['deal_oldprice'], $translation); ?></h3>
<?php endif; ?>
</div>

<?php if(!isExpired(echoOutput($itemDetails['deal_expire']))): ?>
<?php if(timeLeft(echoOutput($itemDetails['deal_expire']), $translation)): ?>
<div class="left_time">
<p><?php echo echoOutput($translation['tr_38']); ?></p>
<div>
<span>

<div class="countdown uk-grid-collapse uk-child-width-auto uk-flex uk-flex-center uk-text-center" uk-grid uk-countdown="date: <?php echo getCountDown($itemDetails['deal_expire']); ?>">
    <div>
        <div class="uk-countdown-number uk-countdown-days"></div>
        <div class="uk-countdown-label"><?php echo echoOutput($translation['tr_120']); ?></div>
    </div>
    <div class="uk-countdown-separator">:</div>
    <div>
        <div class="uk-countdown-number uk-countdown-hours"></div>
        <div class="uk-countdown-label"><?php echo echoOutput($translation['tr_121']); ?></div>
    </div>
    <div class="uk-countdown-separator">:</div>
    <div>
        <div class="uk-countdown-number uk-countdown-minutes"></div>
        <div class="uk-countdown-label"><?php echo echoOutput($translation['tr_122']); ?></div>
    </div>
    <div class="uk-countdown-separator">:</div>
    <div>
        <div class="uk-countdown-number uk-countdown-seconds"></div>
        <div class="uk-countdown-label"><?php echo echoOutput($translation['tr_123']); ?></div>
    </div>
</div>

</span>
</div>
</div>
<?php endif; ?>

<?php endif; ?>

<?php if(!isExpired(echoOutput($itemDetails['deal_expire']))): ?>
<div class="uk-grid-small uk-margin-small-top" uk-grid>
<div class="uk-width-expand">

<a href="<?php echo $urlPath->redirect($itemDetails['deal_id']); ?>" class="uk-button buybtn">
<?php echo echoOutput($translation['tr_39']); ?>
</a>
</div>
<div class="uk-width-auto">

<?php if(isset($isFav) && empty($isFav)): ?>
<span class="like"><a class="addfav uk-button favbtn unfav" data-item="<?php echo echoOutput($itemDetails['deal_id']); ?>" data-user="<?php echo echoOutput($userInfo['user_id']); ?>"></a></span>
<span class="unlike uk-hidden"><a class="removefav uk-button favbtn infav" data-item="<?php echo echoOutput($itemDetails['deal_id']); ?>" data-user="<?php echo echoOutput($userInfo['user_id']); ?>"></a></span>
<?php endif; ?>

<?php if(isset($isFav) && !empty($isFav)): ?>
<span class="like uk-hidden"><a class="addfav uk-button favbtn unfav" data-item="<?php echo echoOutput($itemDetails['deal_id']); ?>" data-user="<?php echo echoOutput($userInfo['user_id']); ?>"></a></span>
<span class="unlike"><a class="removefav uk-button favbtn infav" data-item="<?php echo echoOutput($itemDetails['deal_id']); ?>" data-user="<?php echo echoOutput($userInfo['user_id']); ?>"></a></span>
<?php endif; ?>

<?php if(!isLogged()): ?>
<span><a href="<?php echo $urlPath->signin(); ?>" class="uk-button favbtn unfav"></a></span>
<?php endif; ?>


</div>
</div>

<?php endif; ?>

<div class="uk-hidden@m">
<?php if(echoOutput($itemDetails['deal_expire'])): ?>
<p class="uk-text-muted uk-margin-small-top uk-margin-remove-bottom">
<span class="uk-text-bold"><?php echo echoOutput($translation['tr_36']); ?></span>
<?php echo formatDate($itemDetails['deal_expire']); ?>
</p>
<?php endif; ?>
</div>

<dl class="uk-description-list uk-description-list-divider uk-visible@m">

	<?php if(echoOutput($itemDetails['deal_expire'])): ?>
	<dt><?php echo echoOutput($translation['tr_36']); ?></dt>
	<dd><?php echo formatDate($itemDetails['deal_expire']); ?></dd>
	<?php endif; ?>

	<?php if(!empty($itemDetails['store_title'])): ?>
	<dt><?php echo echoOutput($translation['tr_85']); ?></dt>
	<dd><?php echo echoOutput($itemDetails['store_title']); ?></dd>
	<?php endif; ?>

	<?php if(!empty($itemDetails['location_title'])): ?>
	<dt><?php echo echoOutput($translation['tr_87']); ?></dt>
	<dd><?php echo echoOutput($itemDetails['location_title']); ?></dd>
	<?php endif; ?>

</dl>

</div>

</div>

</div>

<div class="uk-grid-medium uk-margin-small-top" uk-grid>

<div class="uk-width-1-1 uk-width-expand@m">

<hr>

<div class="uk-grid-collapse" uk-grid>

<div class="uk-width-1-2 uk-flex uk-flex-left uk-flex-middle">

	<div class="rating uk-grid-small uk-flex uk-flex-middle" uk-grid>

		<?php if(formatRating($itemDetails['deal_rating'])): ?>
		<div class="uk-width-auto uk-visible@s">
			<p class="rate"><?php echo formatRating($itemDetails['deal_rating']); ?></p>
		</div>
		<?php endif; ?>

		<div class="uk-width-expand">
			<a href="#reviews-item" uk-scroll>
			<p class="stars">
			<?php echo showStars($itemDetails['deal_rating']); ?>
			</p>
			<span class="total"><?php echo echoOutput($itemDetails['total_reviews']); ?> <?php echo echoOutput($translation['tr_49']); ?></span>
			</a>
		</div>
	</div>

</div>

<div class="uk-width-1-2 uk-flex uk-flex-right uk-flex-middle">
<a href="#share-item" class="share uk-text-truncate" uk-scroll>
<?php echo echoOutput($translation['tr_50']); ?> <i class="ti ti-share"></i>
</a>

</div>

</div>

<hr>

<div class="uk-grid-small uk-grid-divider uk-flex uk-flex-middle" uk-grid>

<?php if(!empty($itemDetails['location_title'])): ?>
<div>
<a href="<?php echo $urlPath->search(['location' => $itemDetails['location_slug']]); ?>" class="single_location">
<i class="ion-android-pin"></i>
<?php echo echoOutput($itemDetails['location_title']); ?>
</a>
</div>
<?php endif; ?>


<?php if(!empty($itemDetails['deal_store'])): ?>
<div>
<a href="<?php echo $urlPath->search(['store' => $itemDetails['store_slug']]); ?>" class="single_link"><?php echo echoOutput($itemDetails['store_title']); ?></a>
</div>
<?php endif; ?>

</div>

<?php if(!empty($itemDetails['location_title']) || !empty($itemDetails['store_title'])): ?>

<hr>

<?php endif; ?>


<div class="description">
<?php echo $itemDetails['deal_description']; ?>

<?php if($settings['st_enable_report_form'] == 1): ?>
<a class="uk-button uk-button-default uk-border-rounded uk-flex uk-flex-middle uk-flex-center" href="#report-modal" uk-toggle>
	<i class="ti ti-flag uk-margin-small-right"></i>
	<?php echo echoOutput($translation['tr_351']); ?>
</a>
<?php endif; ?>

</div>

<hr>

<div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>

<div class="uk-width-expand">

<div class="uk-grid-small uk-flex-middle" uk-grid>
	<div class="uk-width-auto">
		<img class="uk-border-pill" src="<?php echo $urlPath->image($itemDetails['seller_logo'] ? $itemDetails['seller_logo'] : $itemDetails['user_avatar']); ?>" width="50" height="50" alt="<?php echo echoOutput($itemDetails['seller_title'] ? $itemDetails['seller_title'] : $itemDetails['user_name']); ?>">
	</div>
	<div class="uk-width-expand">
		<p class="uk-margin-remove">
            <?php if(hasStore($itemDetails['seller_user'])): ?>
            <a class="uk-link-reset" href="<?php echo $urlPath->user($itemDetails['seller_slug']); ?>"><?php echo echoOutput($itemDetails['seller_title'] ? $itemDetails['seller_title'] : $itemDetails['user_name']); ?></a>
            <?php else: ?>
            <?php echo echoOutput($itemDetails['seller_title'] ? $itemDetails['seller_title'] : $itemDetails['user_name']); ?>
            <?php endif; ?>
            <?php if(isActiveSeller($itemDetails['seller_user'])): ?>
            <span class="pro_badge"><?php echo echoOutput($translation['tr_201']); ?></span>
            <?php endif; ?>
        </p>
	</div>
</div>

</div>

<?php if(hasStore($itemDetails['seller_user'])): ?>
<div class="uk-width-auto uk-visible@s">
<a class="uk-button uk-button-default uk-border-pill" href="<?php echo $urlPath->user($itemDetails['seller_slug']); ?>"><?php echo echoOutput($translation['tr_435']); ?></a>
</div>
<?php endif; ?>

</div>

<hr>

<?php require './sections/views/share.view.php'; ?>

<hr>

<?php require './sections/reviews.php'; ?>

</div>

<!-- SIDEBAR -->
<div class="uk-width-1-1 uk-width-1-3@m">

<?php if(!empty($sidebarAd)): ?>
<div class="widget uk-text-center">
<?php foreach($sidebarAd as $item): ?>
<?php echo $item['ad_html']; ?>
<?php endforeach; ?>
</div>
<?php endif; ?>

</div>
<!-- END SIDEBAR -->

</div>
</div>

<?php require './sections/related-deals.php'; ?>

<?php if(!empty($footerAd)): ?>
<div class="tas_ads uk-container uk-margin-large-top">
<div class="uk-width-1-1 uk-text-center">
<?php foreach($footerAd as $item): ?>
<?php echo $item['ad_html']; ?>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

<?php if($settings['st_enable_report_form'] == 1): ?>
<?php require './sections/views/report-modal.view.php'; ?>
<?php endif; ?>
<?php require './sections/views/exclusive-modal.view.php'; ?>
<?php require './sections/footer.php'; ?>
<?php require './sections/reviews-modal.php'; ?>


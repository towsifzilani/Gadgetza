
<?php require './sections/header.php'; ?>

<div class="tas_singlecategory">

<div class="uk-background-cover uk-height-medium uk-panel uk-flex uk-flex-center uk-flex-middle" style="background-image: url(<?php echo $urlPath->image($itemDetails['location_image']); ?>);">
  <div class="overlay">
      <h1 class="title"><?php echo echoOutput($itemDetails['location_title']); ?></h1>
  </div>
</div>


<div class="uk-section-gray uk-padding">

<div class="uk-container">

  <div class="uk-grid-large uk-flex uk-flex-middle" uk-grid>

    <div class="uk-width-expand@s">

    <h3><?php echo echoOutput($translation['tr_200']); ?></h3>
    <p class="uk-text-muted"><?php echo echoOutput($itemDetails['location_description']); ?></p>

    </div>

  </div>
  
</div>

</div>


<div class="uk-container">

<div class="uk-width-1-1 uk-margin-large-top">

<div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
        <div class="uk-width-expand">
            <h4 class="uk-heading-line uk-text-left"><span><?php echo echoOutput($translation['tr_91']); ?></span></h4>
        </div>
        <div class="uk-width-auto">
            <a href="<?php echo $urlPath->search(['location' => $itemDetails['location_slug']]); ?>" class="uk-button uk-button-default uk-border-pill uk-flex uk-flex-middle">
                <?php echo echoOutput($translation['tr_21']); ?> 
                <i class="ti ti-chevron-right uk-text-primary"></i>
            </a>
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

</div>
</div>
</div>

<?php require './sections/footer.php'; ?>
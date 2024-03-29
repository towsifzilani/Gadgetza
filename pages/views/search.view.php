<?php if($itemDetails['page_show_title'] == 1): ?>
<?php include './sections/page-title.php'; ?>
<?php else: ?>
<div class="uk-margin-medium-top"></div>
<?php endif; ?>

<?php if($itemDetails['page_ad_header'] == 1): ?>
<?php include './sections/views/header-ad.view.php'; ?>
<?php endif; ?>

<div class="uk-container page">
    <div class="uk-grid-large" uk-grid>

        <!-- SIDEBAR -->
        <div class="uk-width-1-1 uk-width-1-4@m sidebar uk-visible@m">
        
            <?php require './sections/views/search-form.view.php'; ?>

        </div>
        <!-- END SIDEBAR -->

        <!-- CONTENT -->
        <div class="uk-width-1-1 uk-width-expand@m content">

        <?php if(!empty($itemDetails['page_content'])): ?>
        <div class="uk-container">
        <div class="uk-width-1-1">
        <?php echo $itemDetails['page_content']; ?>
        </div>
        </div>
        <?php endif; ?>

        <div class="uk-hidden@m uk-margin-bottom">
            <a class="uk-button uk-button-default uk-border-rounded uk-flex uk-flex-center uk-flex-middle uk-width-1-1 fltr" uk-toggle="target: #searchModal">
            <i class="ti ti-filter uk-text-primary uk-margin-small-right"></i>
            <?php echo echoOutput($translation['tr_90']); ?>
            </a>
        </div>

        <?php if(false !== strpos($_SERVER['REQUEST_URI'], '?')): ?>

            <div class="uk-margin-bottom" uk-grid>
            
            <div class="uk-width-expand uk-flex uk-flex-middle">
            
            <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slider>
            <ul class="uk-slider-items uk-grid-small" uk-grid>
            
            <?php if(getQParam()): ?>
            <li>
                <a class="filterTag" data-value="q">
                    <p><?php echo echoOutput(getQParam()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSearchQuery()): ?>
            <li>
                <a class="filterTag" data-value="query">
                    <p><?php echo echoOutput(getSearchQuery()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugCategory()): ?>
            <li>
                <a class="filterTag" data-value="category">
                    <p><?php echo getTagCategoryBySlug(getSlugCategory()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugSubCategory()): ?>
            <li>
                <a class="filterTag" data-value="subcategory">
                    <p><?php echo getTagSubCategoryBySlug(getSlugSubCategory()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugStore()): ?>
            <li>
                <a class="filterTag" data-value="store">
                    <p><?php echo getTagStoreBySlug(getSlugStore()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getSlugLocation()): ?>
            <li>
                <a class="filterTag" data-value="location">
                    <p><?php echo getTagLocationBySlug(getSlugLocation()); ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getFilterParam() && getFilterParam() != "all-deals"): ?>
            <li>
                <a class="filterTag" data-value="filter">
                    <p>
                        <?php echo echoOutput(getFilterParam()); ?>
                    </p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>
            <?php if(getTypeParam()): ?>
                <li>
                    <a class="filterTag" data-value="type">
                        <p><?php echo getTypeParam(); ?></p>
                        <i class="ti ti-x"></i>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(getIDPrice() && getIDPrice() != "all"): ?>
            <li>
                <a class="filterTag" data-value="price">
                    <p>
                    <?php

                    $values = explode(',', getIDPrice());
                    $from = (isset($values[0]) ? $values[0] : "0");
                    $to = (isset($values[1]) ? $values[1] : "999999999");

                    if($from < 75){
                        echo getPrice($from)." - ".getPrice($to);
                    }else{
                        echo getPrice($from)." +";
                    }
                    
                    ?></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            <?php if(getIDRating() && getIDRating() != "all" && getIDRating() <= 5): ?>
            <li>
                <a class="filterTag" data-value="rating">
                    <p><?php echo echoOutput(getIDRating()); ?><i class="ion-android-star"></i></p>
                    <i class="ti ti-x"></i>
                </a>
            </li>
            <?php endif; ?>

            </ul>
            </div>
            </div>

            </div>


        <?php endif; ?>


    <div class="uk-grid-small" uk-grid>

    <div class="uk-width-1-2 uk-flex uk-flex-left uk-flex-middle">
        <div>
        <h5 class="uk-text-small uk-margin-remove"><?php echo $total; ?> <?php echo echoOutput($translation['tr_96']); ?></h5>
        </div>
    </div>

    <div class="uk-width-1-2 uk-flex uk-flex-right">

        <a class="uk-text-secondary uk-text-small uk-flex uk-flex-middle" id="filterBtn"><?php echo echoOutput($translation['tr_93']); ?> <i class="ti ti-chevron-down uk-text-primary uk-margin-small-left"></i></a>
        <div class="uk-border-rounded" uk-dropdown="mode: click; pos: bottom-justify">
            <ul class="uk-nav uk-dropdown-nav sortBy">
                <li <?php echo (getParamsSort() == "relevance") ? 'class="uk-active"' : NULL; ?>><a data-value="relevance"><?php echo echoOutput($translation['tr_97']); ?></a></li>
                <li class="uk-nav-divider"></li>
                <li <?php echo (getParamsSort() == "price-asc") ? 'class="uk-active"' : NULL; ?>><a data-value="price-asc"><?php echo echoOutput($translation['tr_98']); ?></a></li>
                <li class="uk-nav-divider"></li>
                <li <?php echo (getParamsSort() == "price-desc") ? 'class="uk-active"' : NULL; ?>><a data-value="price-desc"><?php echo echoOutput($translation['tr_99']); ?></a></li>
                <li class="uk-nav-divider"></li>
                <li <?php echo (getParamsSort() == "best-rated") ? 'class="uk-active"' : NULL; ?>><a data-value="best-rated"><?php echo echoOutput($translation['tr_100']); ?></a></li>
            </ul>
        </div>

    </div>

    </div>

            <?php if(!empty($items)): ?>
            <div class="uk-grid-medium uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m" uk-grid>

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

            <?php require './sections/pagination.php'; ?>
            
            <?php endif; ?>

            <?php if(empty($items)): ?>
                <div class="uk-width-1-1 uk-flex uk-flex-center uk-text-center uk-margin-large-top">
                <div class="uk-width-1-1 uk-width-1-2@s">
                <h3 class="uk-text-bold uk-margin-small"><?php echo echoOutput($translation['tr_109']); ?></h3>
                <p class="uk-margin-small"><?php echo echoOutput($translation['tr_110']); ?></p>
                </div>
                </div>
            <?php endif; ?>

        
        </div>
        <!-- END CONTENT -->

    <div>

<?php require './sections/views/search-modal.view.php'; ?>

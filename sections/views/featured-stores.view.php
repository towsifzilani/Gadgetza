<div class="uk-container uk-margin-large-top uk-margin-large-bottom" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">

<div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle uk-margin-medium-bottom" uk-grid>
        <div class="uk-width-expand">
            <h3 class="uk-heading-line uk-text-left"><span><?php echo echoOutput($translation['tr_34']); ?></span></h3>
        </div>
        <div class="uk-width-auto">
            <a href="<?php echo $urlPath->stores(); ?>" class="uk-button uk-button-default uk-border-pill btn">
                <?php echo echoOutput($translation['tr_21']); ?>
                <i class="ti ti-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-5@l uk-grid-small" uk-grid>
    <?php foreach($featuredStores as $item): ?>
        <div class="cat_3">
            <a href="<?php echo $urlPath->search(['store' => $item['store_slug']]); ?>">
            <div class="uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <div class="cover uk-cover-container">
                    <img src="<?php echo $urlPath->image($item['store_image']); ?>" alt="<?php echo echoOutput($item['store_title']); ?>" uk-cover>
                    <canvas width="60" height="60"></canvas>
                    </div>
                </div>
                <div class="uk-width-expand">
                <h2 class="title"><?php echo echoOutput($item['store_title']); ?></h2>
                </div>
            </div>
            </a>
        </div>
    <?php endforeach; ?>
    </div>
</div>
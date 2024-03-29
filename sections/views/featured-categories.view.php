<div class="cat_1 uk-container uk-margin-large-top uk-margin-large-bottom" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">

<div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle uk-margin-medium-bottom" uk-grid>
        <div class="uk-width-expand">
            <h3 class="uk-heading-line uk-text-left"><span><?php echo echoOutput($translation['tr_11']); ?></span></h3>
        </div>
        <div class="uk-width-auto">
            <a href="<?php echo $urlPath->categories(); ?>" class="uk-button uk-button-default uk-border-pill btn">
                <?php echo echoOutput($translation['tr_21']); ?>
                <i class="ti ti-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l uk-grid-small" uk-grid>
    <?php foreach($featuredCategories as $item): ?>
        <div>
            <a href="<?php echo $urlPath->search(['category' => $item['category_slug']]); ?>">
            <div class="card">
            <div class="cover" style="background: url(<?php echo $urlPath->image($item['category_image']); ?>)">
            </div>
            <h5 class="card-title uk-text-truncate"><?php echo echoOutput($item['category_title']); ?></h5>
            </div>
            </a>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<div class="uk-container uk-margin-top uk-margin-large-bottom" uk-scrollspy="target: > div; cls: uk-animation-fade; delay: 100">

<div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
        <div class="uk-width-expand">
            <h3 class="uk-heading-line uk-text-left"><span><?php echo echoOutput($translation['tr_19']); ?></span></h3>
        </div>
        <div class="uk-width-auto">
            <a href="<?php echo $urlPath->locations(); ?>" class="uk-button uk-button-default uk-border-pill btn">
                <?php echo echoOutput($translation['tr_21']); ?>
                <i class="ti ti-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-2@m uk-child-width-1-5@l uk-margin-medium-top" uk-grid>

<?php foreach ($featuredLocations as $item): ?>

        <a href="<?php echo $urlPath->location($item['location_slug']); ?>">
            <div class="cat_2 uk-cover-container">
            <img src="<?php echo $urlPath->image($item['location_image']); ?>" alt="<?php echo echoOutput($item['location_title']); ?>" uk-cover>
            <canvas width="600" height="300"></canvas>

            <div class="uk-overlay-primary uk-position-cover"></div>
            <div class="uk-overlay uk-position-center uk-light">
                <p><?php echo echoOutput($item['location_title']); ?></p>
                <span><?php echo echoOutput($item['total_items']); ?> <?php echo echoOutput($translation['tr_35']); ?></span>
            </div>

            </div>
</a>

<?php endforeach ?>

</div>

</div>

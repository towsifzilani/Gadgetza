<?php if($itemDetails['page_show_title'] == 1): ?>
<?php include './sections/page-title.php'; ?>
<?php else: ?>
<div class="uk-margin-medium-top"></div>
<?php endif; ?>

<?php if($itemDetails['page_ad_header'] == 1): ?>
<?php include './sections/views/header-ad.view.php'; ?>
<?php endif; ?>

<div class="uk-container">

    <div class="uk-flex uk-flex-center uk-grid-small" uk-grid>
        <?php foreach ($translation['arrayLetter'] as $char): ?>
            <a class="uk-link-text" href="#section-<?php echo echoOutput($char); ?>" uk-scroll><?php echo echoOutput($char); ?></a>
        <?php endforeach; ?>
            <a class="uk-link-text" href="#section-09" uk-scroll>0-9</a>
    </div>

    <div class="uk-margin-medium-top uk-margin-bottom">

        <?php foreach ($translation['arrayLetter'] as $char): ?>
        <h3 class="uk-heading-line uk-text-bold" id="section-<?php echo echoOutput($char); ?>"><span><?php echo echoOutput($char); ?></span></h3>

        <div class="uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m uk-child-width-1-6@l uk-grid-small" uk-grid>
            <?php $getLocations = getLocationsByLetter($connect, $char); ?>
            <?php foreach($getLocations as $item): ?>
                
                <div>
                    <a class="uk-text-secondary" href="<?php echo $urlPath->search(['location' => $item['location_slug']]); ?>">
                    <span class="uk-text-middle"><?php echo echoOutput($item['location_title']); ?></span>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

    <h3 class="uk-heading-line uk-text-bold" id="section-09"><span>0-9</span></h3>
        <div class="uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m uk-child-width-1-6@l uk-grid-small" uk-grid>
            <?php $getLocations = getLocationsByLetter($connect); ?>
            <?php foreach($getLocations as $item): ?>
                
                <div>
                    <a class="uk-text-secondary" href="<?php echo $urlPath->search(['location' => $item['location_slug']]); ?>">
                    <span class="uk-text-middle"><?php echo echoOutput($item['location_title']); ?></span>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>

    <div class="uk-position-fixed uk-position-bottom-right uk-padding">
    <a href="#" uk-totop uk-scroll></a>
    </div>

</div>
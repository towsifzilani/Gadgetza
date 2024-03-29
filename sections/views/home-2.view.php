<div class="tas_home_2 uk-flex uk-flex-center uk-flex-middle">

<div class="uk-width-1-1 uk-padding uk-text-center uk-position-z-index">
    <h1 class="title"><?php echo echoOutput($translation['tr_7']); ?></h1>
    <h4 class="subtitle"><?php echo echoOutput($translation['tr_8']); ?></h4>

<div class="uk-container uk-margin-large-top" uk-slider="finite: true">
<div class="uk-position-relative">

<div class="uk-slider-container">
    <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m uk-child-width-1-6@l uk-grid-small" uk-grid>
    <?php foreach($featuredCategories as $item): ?>
        <li>
            <a href="<?php echo $urlPath->search(['category' => $item['category_slug']]); ?>">
            <div class="card">
            <div class="cover" style="background: url(<?php echo $urlPath->image($item['category_image']); ?>)">
            </div>
            <h5 class="card-title uk-text-truncate"><?php echo echoOutput($item['category_title']); ?></h5>
            </div>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>

        <div class="uk-visible@m">
            <a class="uk-position-center-left-out uk-position-small nextprevbtn" href="#" uk-slidenav-previous uk-slider-item="previous"><i class="ti ti-chevron-left"></i></a>
            <a class="uk-position-center-right-out uk-position-small nextprevbtn" href="#" uk-slidenav-previous uk-slider-item="next"><i class="ti ti-chevron-right"></i></a>
        </div>

</div>

</div>
</div>


</div>


</div>

</div>
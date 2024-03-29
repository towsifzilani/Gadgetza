<?php if($itemDetails['page_show_title'] == 1): ?>
<?php include './sections/page-title.php'; ?>
<?php else: ?>
<div class="uk-margin-medium-top"></div>
<?php endif; ?>

<?php if($itemDetails['page_ad_header'] == 1): ?>
<?php include './sections/views/header-ad.view.php'; ?>
<?php endif; ?>

<div class="uk-container tas_categories">

<div class="uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-5@m uk-child-width-1-6@l uk-grid-medium" uk-grid>
    <?php foreach($getFeaturedCategories as $item): ?>
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

<div class="uk-grid-small uk-flex uk-flex-middle uk-margin-large-top" uk-grid>
        <div class="uk-width-expand">
            <h5 class="uk-heading-line uk-text-left uk-text-bold"><span><?php echo echoOutput($translation['tr_195']); ?></span></h5>
        </div>
</div>


<div class="uk-grid-medium uk-margin-top uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-5@l" uk-grid>

<?php foreach ($getCategories as $item): ?>
<div>

<ul class="uk-nav uk-nav-default">
    <li class="uk-nav-header"><a class="uk-text-secondary uk-text-capitalize" href="<?php echo $urlPath->search(['category' => $item['category_slug']]); ?>"><?php echo echoOutput($item['category_title']); ?></a></li>
    <?php $getSubCategories = getSubCategories($connect, $item['category_id']); ?>
    <?php foreach ($getSubCategories as $item): ?>
    <li><a href="<?php echo $urlPath->search(['subcategory' => $item['subcategory_slug']]); ?>"><?php echo echoOutput($item['subcategory_title']); ?></a></li>
    <?php endforeach ?>
</ul>

</div>
<?php endforeach ?>

</div>

</div>
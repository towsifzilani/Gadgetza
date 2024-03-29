<div class="uk-container uk-margin-top">

<div class="uk-width-1-1 uk-margin-medium-top">

<hr class="uk-margin-medium-top uk-margin-medium-bottom">

    <div class="uk-grid-medium uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-5@l" uk-grid>

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

</div>


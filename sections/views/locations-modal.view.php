<div id="locations-modal" class="uk-flex-top reviews" uk-modal>
    <div class="tas-modal uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="modal_title"><?php echo echoOutput($translation['tr_131']); ?></h2>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>

        <input id="filterInput_1" class="uk-input uk-border-rounded" type="text" placeholder="">

        <ul id="filterData_1" class="uk-nav-default filterLocation uk-grid-collapse uk-margin uk-child-width-1-2 uk-child-width-1-3@s" uk-nav uk-grid>
            <?php foreach ($getModalLocations as $item): ?>
                <li class="uk-margin-small-bottom">
                <label class="uk-text-secondary" data-current="<?php echo echoOutput(getSlugLocation()); ?>" data-value="<?php echo echoOutput($item['location_slug']); ?>">
                    <input class="uk-checkbox uk-margin-small-right" type="checkbox" <?php echo (getSlugLocation() == $item['location_slug']) ? 'checked' : NULL ?>><?php echo echoOutput($item['location_title']); ?>
                </label>
                </li>
            <?php endforeach ?>
            </ul>

        </div>

    </div>
</div>

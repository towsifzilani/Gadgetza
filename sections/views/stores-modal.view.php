<div id="stores-modal" class="uk-flex-top reviews" uk-modal>
    <div class="tas-modal uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="modal_title"><?php echo echoOutput($translation['tr_138']); ?></h2>
        </div>
        <div class="uk-modal-body" uk-overflow-auto>

        <input id="filterInput_2" class="uk-input uk-border-rounded" type="text" placeholder="">

        <ul id="filterData_2" class="uk-nav-default filterStore uk-grid-collapse uk-margin uk-child-width-1-2 uk-child-width-1-3@s" uk-nav uk-grid>
            <?php foreach ($getModalStores as $item): ?>
                <a data-value="<?php echo echoOutput($item['store_slug']); ?>">
            <div class="uk-grid-small uk-flex uk-flex-middle uk-margin-bottom" uk-grid>
                <div class="uk-width-auto">
                    <div class="uk-border-rounded uk-cover-container">
                    <img src="<?php echo $urlPath->image($item['store_image']); ?>" alt="<?php echo echoOutput($item['store_title']); ?>" uk-cover>
                    <canvas width="50" height="50"></canvas>
                    </div>
                </div>
                <div class="uk-width-expand">
                <p <?php echo getSlugStore() == $item['store_slug'] ? "class='uk-text-primary'" : "class='uk-text-secondary'" ?>><?php echo echoOutput($item['store_title']); ?></p>
                </div>
            </div>
                        </a>
            <?php endforeach ?>
            </ul>

        </div>

    </div>
</div>

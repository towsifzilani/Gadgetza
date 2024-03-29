<div class="tas_home_1 uk-cover-container uk-background-cover uk-flex uk-flex-center uk-flex-middle uk-margin-medium-bottom" style="background-image: url(<?php echo $urlPath->image($theme['th_homebg']); ?>);">

<div class="uk-overlay-primary uk-position-cover"></div>

<div class="uk-width-1-1 uk-padding uk-text-center uk-position-z-index">
    <h1 class="title"><?php echo echoOutput($translation['tr_7']); ?></h1>
    <h4 class="subtitle"><?php echo echoOutput($translation['tr_8']); ?></h4>

    <div class="uk-flex uk-flex-center">
    
    <form id="searchForm" class="search uk-grid-small uk-width-1-1 uk-width-1-2@m uk-flex uk-flex-middle" method="get" action="<?php echo $urlPath->search(); ?>" uk-grid>

    <div class="uk-width-expand">
        <div class="uk-grid-collapse" uk-grid>

        <div class="uk-width-expand">
            <div class="uk-inline uk-width-1-1">
                <?php if(!getSearchQuery() && empty(getSearchQuery())): ?>
                <input class="uk-input uk-form-large" name="query" placeholder="<?php echo $translation['tr_4']; ?>">
                <?php endif; ?>

                <?php if(getSearchQuery() && !empty(getSearchQuery())): ?>
                <input class="uk-input uk-form-large" name="query" value="<?php echo echoOutput(getSearchQuery()); ?>" placeholder="<?php echo $translation['tr_4']; ?>">
                <?php endif; ?>
            </div>
        </div>	

        <div class="uk-width-auto">

        <a class="uk-button uk-button-large searchbtn btnSubmitForm">
        <i class="ti ti-search icon-search"></i>
        </a>

        </div>

        </div>
    </div>	

    <div class="uk-width-auto">
    <select class="uk-select" name="location">
        <?php foreach($getLocations as $item): ?>
            <option value="<?php echo echoOutput($item['location_slug']); ?>"><?php echo echoOutput($item['location_title']); ?></option>
        <?php endforeach; ?>
    </select>

    </div>

    </form>

</div>


</div>

</div>
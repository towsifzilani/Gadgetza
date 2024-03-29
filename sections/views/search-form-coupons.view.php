<div class="widget">
        <!-- <form class="searchForm">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>

                    <?php if(!getSearchQuery() && empty(getSearchQuery())): ?>
                    <input class="uk-input uk-border-rounded uk-form-large" name="query" placeholder="<?php echo echoOutput($translation['tr_137']); ?>" type="search">
                    <?php endif; ?>

                    <?php if(getSearchQuery() && !empty(getSearchQuery())): ?>
                    <input class="uk-input uk-border-rounded uk-form-large" name="query" value="<?php echo echoOutput(getSearchQuery()); ?>" placeholder="<?php echo echoOutput($translation['tr_137']); ?>" type="search">
                    <?php endif; ?>

                </div>
            </div>
        </form> -->
        <form class="searchAllCoupon">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>

                    <input 
                        class="uk-input uk-border-rounded uk-form-large" 
                        name="searhcCoupon" 
                        value="<?php echo getQParam() ? echoOutput(getQParam()) : ""; ?>" 
                        placeholder="<?php echo echoOutput($translation['tr_137']); ?>" 
                        type="search"
                    >

                </div>
            </div>
        </form>
        </div>

            <?php if(!empty($getCategories)): ?>
                <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_130']); ?></h4>

                <?php foreach ($getCategories as $item): ?>
                <?php $subCategories = getSubCategories($connect, $item['category_id']); ?>
                <ul class="uk-nav-default filterCategory <?php echo (empty(!$subCategories)) ? "uk-nav-parent-icon" : NULL; ?>" uk-nav>
                    <li class="uk-parent <?php echo (getSlugCategory() == $item['category_slug']) ? 'uk-open' : NULL ?>">
                        <a class="uk-text-secondary uk-text-capitalize" data-current="<?php echo echoOutput(getSlugCategory()); ?>"><span data-value="<?php echo echoOutput($item['category_slug']); ?>"><?php echo echoOutput($item['category_title']); ?></span></a>
                        <?php if(!empty($subCategories)): ?>
                            <ul class="uk-nav-sub filterSubCategory">
                            <?php foreach ($subCategories as $item): ?>
                            <li <?php echo (getSlugSubCategory() == $item['subcategory_slug']) ? 'class="uk-active"' : NULL ?>"><a data-value="<?php echo echoOutput($item['subcategory_slug']); ?>"><?php echo echoOutput($item['subcategory_title']); ?></a></li>
                            <?php endforeach ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                </ul>
                <?php endforeach ?>
                </div>
            <?php endif; ?>

            <?php if(!empty($getStores)): ?>
                <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_138']); ?></h4>
                <div class="uk-grid-small filterStore" uk-grid>
                    
                <?php foreach ($getStores as $item): ?>
                    <div class="uk-width-1-4">

                        <a data-value="<?php echo echoOutput($item['store_slug']); ?>">
                            <div class="uk-cover-container uk-border-pill uk-inline uk-light uk-visible-toggle uk-animation-toggle" tabindex="-1">
                            <img src="<?php echo $urlPath->image($item['store_image']); ?>" alt="<?php echo echoOutput($item['store_title']); ?>" uk-cover>
                            <canvas width="50" height="50"></canvas>

                            <?php if(getSlugStore() != $item['store_slug']): ?>
                            <div class="uk-hidden-hover uk-animation-fade uk-flex uk-flex-middle uk-flex-center uk-animation-fast uk-overlay uk-overlay-primary uk-position-center">
                                <i class="ti ti-plus"></i>
                            </div>
                            <?php endif; ?>

                            <?php if(getSlugStore() == $item['store_slug']): ?>
                            <div class="uk-flex uk-flex-middle uk-flex-center uk-overlay uk-overlay-primary uk-position-center">
                                <i class="ti ti-check"></i>
                            </div>
                            <?php endif; ?>

                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
                </div>

                <?php if(count($getStores) > 15): ?>
                    <div class="uk-margin-small-top">
                    <a class="uk-button uk-button-default uk-width-1-1 uk-border-rounded uk-margin-small-top" href="#stores-modal" uk-toggle>
                    <?php echo echoOutput($translation['tr_116']); ?>
                    </a>
                    </div>
                <?php endif; ?>

                </div>

            <?php endif; ?>

            <?php if(getFilterParam() == "all-coupons") : ?> 
                <div class="widget">
                    <h4 class="widget_heading"><?php echo echoOutput($translation['tr_198']); ?></h4>
                    <ul class="uk-nav-default otherFilters2" uk-nav>
                        <li>
                            <label class="uk-text-secondary" data-value="exclusive-coupon">
                                <input class="uk-checkbox" type="checkbox" <?php echo (getTypeParam() == 'exclusive-coupon') ? 'checked' : NULL ?>><?php echo echoOutput($translation['tr_460']); ?>
                            </label>
                        </li>
                        <li>
                            <label class="uk-text-secondary" data-value="featured-coupon">
                                <input class="uk-checkbox" type="checkbox" <?php echo (getTypeParam() == 'featured-coupon') ? 'checked' : NULL ?>><?php echo echoOutput($translation['tr_461']); ?>
                            </label>
                        </li>
                    </ul>
                </div>
            <?php else : ?>
                <div class="widget">
                    <h4 class="widget_heading"><?php echo echoOutput($translation['tr_198']); ?></h4>
                    <ul class="uk-nav-default otherFilters" uk-nav>
                        <li>
                            <label class="uk-text-secondary" data-value="exclusive-coupon">
                                <input class="uk-checkbox" type="checkbox" <?php echo (getFilterParam() == 'exclusive-coupon') ? 'checked' : NULL ?>><?php echo echoOutput($translation['tr_460']); ?>
                            </label>
                        </li>
                        <li>
                            <label class="uk-text-secondary" data-value="featured-coupon">
                                <input class="uk-checkbox" type="checkbox" <?php echo (getFilterParam() == 'featured-coupon') ? 'checked' : NULL ?>><?php echo echoOutput($translation['tr_461']); ?>
                            </label>
                        </li>
                    </ul>
                </div>
            <?php endif?> 


            <?php require './sections/locations-modal.php'; ?>
            <?php require './sections/stores-modal.php'; ?>

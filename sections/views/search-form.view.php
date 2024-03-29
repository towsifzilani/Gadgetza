<div class="widget">
        <form class="searchDeal">
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: search"></span>

                    <input 
                        class="uk-input uk-border-rounded uk-form-large" 
                        name="searchDeal" 
                        value="<?php echo getQParam() ? echoOutput(getQParam()): ""; ?>" 
                        placeholder="<?php echo echoOutput($translation['tr_137']); ?>" 
                        type="search">

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


            <?php if(!empty($getLocations)): ?>
                <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_131']); ?></h4>
                <?php foreach ($getLocations as $item): ?>
                <ul class="uk-nav-default filterLocation" uk-nav>
                    <li>
                    <label class="uk-text-secondary" data-current="<?php echo echoOutput(getSlugLocation()); ?>" data-value="<?php echo echoOutput($item['location_slug']); ?>">
                        <input class="uk-checkbox" type="checkbox" <?php echo (getSlugLocation() == $item['location_slug']) ? 'checked' : NULL ?>><?php echo echoOutput($item['location_title']); ?>
                    </label>
                    </li>
                </ul>
                <?php endforeach ?>

                <?php if(count($getLocations) > 3): ?>
                    <div class="uk-margin-small-top">
                    <a class="uk-button uk-button-default uk-width-1-1 uk-border-rounded uk-margin-small-top" href="#locations-modal" uk-toggle>
                    <?php echo echoOutput($translation['tr_116']); ?>
                    </a>
                    </div>
                <?php endif; ?>

                </div>
            <?php endif; ?>

            <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_132']); ?></h4>
                <ul class="uk-nav-default filterRating rating" uk-nav>
                    <li>
                    <label data-value="all"><input class="uk-radio" type="radio" <?php echo (!getIDRating() || getIDRating() == "all") ? 'checked' : NULL ?>> <?php echo echoOutput($translation['tr_135']); ?></label>
                    </li>
                    <?php for($i=5;$i > 0;$i-=1) {?>
                    <li>
                    <label data-value="<?php echo echoOutput($i); ?>"><input class="uk-radio" type="radio" <?php echo (getIDRating() == $i) ? 'checked' : NULL ?>> <?php echo showStars($i); ?></label>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        
            <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_136']); ?></h4>
                <ul class="uk-nav-default filterPrice price" uk-nav>
                    <li>
                    <label data-value="all"><input class="uk-radio" type="radio" <?php echo (!getIDPrice() || getIDPrice() == "all") ? 'checked' : NULL ?>> <?php echo echoOutput($translation['tr_135']); ?></label>
                    </li>
                <?php foreach (range(0, 75, 15) as $range): ?>
                    <li>
                    <?php if($range < 75): ?>
                        <label data-value="<?php echo $range.",".$range+15; ?>">
                        <input class="uk-radio" type="radio" <?php echo (getIDPrice() == $range.",".$range+15) ? 'checked' : NULL ?>/>
                        <span><?php echo getPrice($range)." - ".getPrice($range+15); ?></span>
                        </label>

                    <?php endif; ?>
                    <?php if($range >= 75): ?>
                        <label data-value="<?php echo $range; ?>">
                        <input class="uk-radio" type="radio" <?php echo (getIDPrice() == $range) ? 'checked' : NULL ?>/>
                        <span><?php echo getPrice($range)."+"; ?></span>
                        </label>
                    <?php endif; ?>
                    </li>
                <?php endforeach ?>
                </ul>
            </div>

            <?php if(getFilterParam() == "all-deals") : ?> 
            <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_198']); ?></h4>
                <ul class="uk-nav-default otherFilters2" uk-nav>
                    <li>
                    <label class="uk-text-secondary" data-value="exclusive">
                        <input class="uk-checkbox" type="checkbox" <?php echo (getTypeParam() == 'exclusive') ? 'checked' : NULL ?>><?php echo echoOutput($translation['tr_199']); ?>
                    </label>
                    </li>
                </ul>
            </div>
            <?php else : ?>
                <div class="widget">
                <h4 class="widget_heading"><?php echo echoOutput($translation['tr_198']); ?></h4>
                <ul class="uk-nav-default otherFilters" uk-nav>
                    <li>
                    <label class="uk-text-secondary" data-value="exclusive">
                        <input class="uk-checkbox" type="checkbox" <?php echo (getFilterParam() == 'exclusive') ? 'checked' : NULL ?>><?php echo echoOutput($translation['tr_199']); ?>
                    </label>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
            <?php require './sections/locations-modal.php'; ?>
            <?php require './sections/stores-modal.php'; ?>

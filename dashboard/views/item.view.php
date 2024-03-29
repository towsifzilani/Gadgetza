<?php require 'menu.php'; ?>

<div class="content-padder">

            <div class="uk-section-small uk-background-muted">
                <div class="uk-container uk-container-large">

                    <div uk-grid>
                        <div class="uk-width-1-1">
                                
                            <div class="uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-1-1@s uk-width-expand@l">
                            <span id="itemId" data-id="<?php echo echoOutput($itemDetails['deal_id']); ?>"></span>
                            <h4 class="uk-text-bold uk-margin-remove-top"><?php echo echoOutput($itemDetails['deal_title']); ?> <?php if($itemDetails['deal_status'] == 1): ?><a target="_blank" href="<?php echo $urlPath->deal($itemDetails['deal_id'], $itemDetails['deal_slug']); ?>" class="uk-icon-link" uk-icon="link"></a><?php endif; ?></h4>
                            <ul class="uk-subnav uk-subnav-divider uk-text-small" uk-margin>
                                <li><?php echo echoOutput($translation['tr_268']); ?> <?php echo formatDate($itemDetails['deal_created']); ?></li>
                                <li><?php echo echoOutput($translation['tr_269']); ?> <?php echo formatDate($itemDetails['deal_updated']); ?></li>
                                <li><?php echo echoOutput($translation['tr_270']); ?>&nbsp;
                                <?php if ($itemDetails['deal_status'] == 1) {
                                    echo '<span class="uk-text-success uk-text-bold uk-text-capitalize">'.$translation['tr_250'].'</span>';
                                }else if ($itemDetails['deal_status'] == 2) {
                                    echo '<span class="uk-text-warning uk-text-bold uk-text-capitalize">'.$translation['tr_251'].'</span>';
                                }else if ($itemDetails['deal_status'] == 3) {
                                    echo '<span class="uk-text-warning uk-text-bold uk-text-capitalize">'.$translation['tr_252'].'</span>';
                                }else if ($itemDetails['deal_status'] == 4) {
                                    echo '<span class="uk-text-danger uk-text-bold uk-text-capitalize">'.$translation['tr_266'].'</span>';
                                }else if ($itemDetails['deal_status'] == 5) {
                                    echo '<span class="uk-text-warning uk-text-capitalize">'.$translation['tr_447'].'</span>';
                                } ?>
                                </li>
                            </ul>
                            </div>

                            </div>

                        </div>
                    </div>

                    <div uk-grid class="uk-grid-match uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-2@m uk-child-width-1-4@xl">
                    <div>
                            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">
                                <span class="statistics-text"><?php echo echoOutput($translation['tr_233']); ?></span><br />
                                <span class="statistics-number">
                                    <?php echo echoOutput($totalClickToday); ?>
                                </span>
                            </div>
                        </div>
                        <div>
                            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">
                                <span class="statistics-text"><?php echo echoOutput($translation['tr_234']); ?></span><br />
                                <span class="statistics-number">
                                    <?php echo echoOutput($totalClicksLast30); ?>
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">
                                <span class="statistics-text"><?php echo echoOutput($translation['tr_235']); ?></span><br />
                                <span class="statistics-number">
                                    <?php echo echoOutput($totalClicks); ?>
                                </span>
                            </div>
                        </div>

                        <div>
                            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">
                                <span class="statistics-text"><?php echo echoOutput($translation['tr_236']); ?></span><br />
                                <span class="statistics-number">
                                    <?php echo echoOutput($totalUniqueClicks); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid-match" uk-grid>
                        <div class="uk-width-1-1@s uk-width-expand@l">
                            <div class="uk-card uk-card-default uk-border-rounded uk-card-bordered">
                                <div class="uk-card-header">
                                <div class="uk-flex uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand"><?php echo echoOutput($translation['tr_237']); ?></div>
                                    <div class="uk-width-auto">
                                    <ul class="uk-subnav uk-subnav-pill intervals" uk-margin>
                                        <li class="<?php echo (!getIntervalParam() || getIntervalParam() == "last7days" ? "uk-active" : null); ?>"><a class="filterInterval uk-text-capitalize uk-text-small" data-interval="last7days"><?php echo echoOutput($translation['tr_254']); ?></a></li>
                                        <li class="<?php echo (getIntervalParam() == "last30days" ? "uk-active" : null); ?>"><a class="filterInterval uk-text-capitalize uk-text-small" data-interval="last30days"><?php echo echoOutput($translation['tr_255']); ?></a></li>
                                        <li class="<?php echo (getIntervalParam() == "last6months" ? "uk-active" : null); ?>"><a class="filterInterval uk-text-capitalize uk-text-small" data-interval="last6months"><?php echo echoOutput($translation['tr_256']); ?></a></li>
                                        <li class="<?php echo (getIntervalParam() == "lastyear" ? "uk-active" : null); ?>"><a class="filterInterval uk-text-capitalize uk-text-small" data-interval="lastyear"><?php echo echoOutput($translation['tr_257']); ?></a></li>
                                    </ul>
                                    </div>
                                </div>
                                </div>
                                <div class="uk-card-body">
                                <div id="chart-container">
                                        <canvas id="graphCanvas"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-1-1@s uk-width-1-4@l">
                            <div class="uk-card uk-card-default uk-border-rounded uk-margin-medium-bottom uk-card-bordered">
                                <div class="uk-card-header">
                                <?php echo echoOutput($translation['tr_263']); ?>
                                </div>

                                <div class="uk-card-body uk-padding-small">
                                <?php if(empty($deviceTypes)): ?>
                                    <p class="uk-text-center uk-text-muted"><?php echo echoOutput($translation['tr_434']); ?></p>
                                <?php endif; ?>
                                <table class="uk-table">
                                    <tbody>
                                        <?php foreach ($deviceTypes as $item): ?>
                                        <tr>
                                            <td class="uk-text-capitalize"><span uk-icon="<?php echo ($item['track_device'] == "mobile" ? "phone" : $item['track_device']); ?>" class="uk-margin-small-right"></span> <?php echo echoOutput($item['track_device']); ?></td>
                                            <td><?php echo echoOutput($item['total']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                </div>

                            </div>

                            <div class="uk-card uk-card-default uk-border-rounded uk-card-bordered">
                                <div class="uk-card-header">
                                <?php echo echoOutput($translation['tr_264']); ?>
                                </div>

                                <div class="uk-card-body uk-padding-small">
                                <?php if(empty($topCountries)): ?>
                                    <p class="uk-text-center uk-text-muted"><?php echo echoOutput($translation['tr_434']); ?></p>
                                <?php endif; ?>
                                <table class="uk-table">
                                    <tbody>
                                    <?php foreach ($topCountries as $item): ?>
                                        <tr>
                                        <td class="uk-flex uk-flex-middle"><span class="fi fi-<?php echo echoOutput(($item['track_country_code'] ? $item['track_country_code'] : "xx")); ?> uk-margin-small-right"></span> <?php echo echoOutput(($item['track_country_name'] ? $item['track_country_name'] : "Unknown")); ?></td>
                                        <td><?php echo echoOutput($item['total']); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                </div>

                            </div>

                        </div>
                        
                    </div>

                    <div uk-grid>
                        <div class="uk-width-1-1">
                            <div class="uk-card uk-card-default uk-border-rounded uk-card-bordered">
                                <div class="uk-card-body uk-padding-small">
                                <div class="uk-card-header">
                                <div class="uk-flex uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand"><?php echo echoOutput($translation['tr_265']); ?></div>
                                    <div class="uk-width-auto">
                                        <a class="uk-button uk-button-default uk-button-small uk-border-rounded uk-flex uk-flex-middle uk-text-capitalize" href="edit_item.php?id=<?php echo echoOutput($itemDetails['deal_id']); ?>">Edit <span class="uk-margin-small-left" uk-icon="icon: chevron-right; ratio: 0.8"></span></a></div>
                                </div>
                                </div>

                                    <table class="uk-table uk-table-divider uk-table-middle uk-table-responsive">
    <tbody>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_274']); ?></td>
            <td><?php echo echoOutput($itemDetails['deal_title']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_275']); ?></td>
            <td><?php echo echoOutput($itemDetails['deal_tagline']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_276']); ?></td>
            <td><?php echo textTruncate(echoNoHtml($itemDetails['deal_description']), 250); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_446']); ?></td>
            <td><?php echo echoOutput($itemDetails['deal_expire']); ?> <?php echo (isExpired($itemDetails['deal_expire']) ? "<span class='uk-label uk-label-danger uk-margin-small-left'>Expired</span>" : null ) ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_277']); ?></td>
            <td><?php echo echoOutput($itemDetails['category_title']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_278']); ?></td>
            <td><?php echo echoOutput($itemDetails['subcategory_title']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_279']); ?></td>
            <td><?php echo echoOutput($itemDetails['store_title']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_280']); ?></td>
            <td><?php echo echoOutput($itemDetails['location_title']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_281']); ?></td>
            <td><?php echo getPrice($itemDetails['deal_price']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_282']); ?></td>
            <td><?php echo getPrice($itemDetails['deal_oldprice']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_283']); ?></td>
            <td>
                <?php if ($itemDetails['deal_status'] == 1) {
                    echo '<span class="uk-label uk-label-success">'.$translation['tr_250'].'</span>';
                }else if ($itemDetails['deal_status'] == 2) {
                    echo '<span class="uk-label uk-label-warning">'.$translation['tr_251'].'</span>';
                }else if ($itemDetails['deal_status'] == 3) {
                    echo '<span class="uk-label uk-label-warning">'.$translation['tr_252'].'</span>';
                }else if ($itemDetails['deal_status'] == 4) {
                    echo '<span class="uk-label uk-label-danger">'.$translation['tr_266'].'</span>';
                } ?>
                </td>
        </tr>
        <!--<tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_284']); ?></td>
            <td><?php echo formatDate($itemDetails['deal_start']); ?></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_285']); ?></td>
            <td><?php echo (!empty($itemDetails['deal_expire'] ? formatDate($itemDetails['deal_expire']) : null)); ?></td>
        </tr>-->
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_286']); ?></td>
            <td><div uk-lightbox><a class="uk-link-muted" href="<?php echo $urlPath->image($itemDetails['deal_image']); ?>" target="_blank">Preview</a></div></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_287']); ?></td>
            <td><div uk-lightbox><a class="uk-link-muted" href="<?php echo echoOutput($itemDetails['deal_link']); ?>"><?php echo echoOutput($itemDetails['deal_link']); ?></a></div></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_288']); ?></td>
            <td><a class="uk-link-muted" href="<?php echo echoOutput($itemDetails['deal_video']); ?>"><?php echo echoOutput($itemDetails['deal_video']); ?></a></td>
        </tr>
        <tr>
            <td class="uk-text-bold"><?php echo echoOutput($translation['tr_289']); ?></td>
            <td><div class="uk-text-truncate" uk-lightbox><a class="uk-link-muted" href="<?php echo echoOutput($itemDetails['deal_gif']); ?>"><?php echo echoOutput($itemDetails['deal_gif']); ?></a></div></td>
        </tr>
    </tbody>
</table>


                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

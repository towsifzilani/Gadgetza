<?php require 'menu.php'; ?>

<div class="content-padder">

<div class="uk-section-small uk-background-muted">

            <div class="uk-container uk-container-large uk-margin-bottom">
            <h3 class="uk-heading-line"><span><?php echo echoOutput($translation['tr_232']); ?> <b><?php echo echoOutput($userDetails['user_name']); ?></b>!</span> </h3>
            </div>

            <!-- ALERTS -->

            <div class="uk-container uk-container-large">

                    <?php if(expirationReminderAlert()): ?>
                    <div class="uk-border-rounded uk-flex uk-flex-middle tas-notify tas-notify-warning">
                    <p class="uk-margin-remove"><?php echo echoOutput($translation['tr_246']); ?> <u><?php echo formatDate($userDetails['user_plan_expiration_date']); ?></u></p>
                    <a class="uk-margin-small-left uk-button uk-button-default uk-text-bold uk-border-rounded uk-button-small uk-text-warning" href="<?php echo $urlPath->pricing(); ?>"><?php echo echoOutput($translation['tr_248']); ?></a>
                    </div>
                    <?php endif; ?>

                    <?php if(isExpiredSubscription()): ?>
                    <div class="uk-border-rounded uk-flex uk-flex-middle tas-notify tas-notify-danger uk-margin-top">
                    <p class="uk-margin-remove"><?php echo echoOutput($translation['tr_247']); ?></p>
                    <a class="uk-margin-small-left uk-button uk-button-default uk-text-bold uk-border-rounded uk-button-small uk-text-danger" href="<?php echo $urlPath->pricing(); ?>"><?php echo echoOutput($translation['tr_249']); ?></a>
                    </div>
                    <?php endif; ?>

            </div>
                            
            <div class="uk-section-small">
                <div class="uk-container uk-container-large">
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
                        <div class="uk-width-1-1@s uk-width-1-3@l">
                            <div class="uk-card uk-card-default uk-border-rounded uk-card-bordered">
                                <div class="uk-card-header uk-margin-small-bottom">
                                <div uk-grid>
                                    <div class="uk-width-expand"><?php echo echoOutput($translation['tr_238']); ?></div>
                                </div>
                                </div>

                                <div class="uk-margin-medium-left">
                                <?php if(empty($topCountries)): ?>
                                    <p class="uk-text-center uk-text-muted uk-margin-top"><?php echo echoOutput($translation['tr_434']); ?></p>
                                <?php endif; ?>
                                <table class="countries-table uk-table uk-table-divider uk-table-small uk-margin-remove-top">
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
                                <div class="uk-card-header">
                                <div uk-grid>
                                    <div class="uk-width-expand"><?php echo echoOutput($translation['tr_239']); ?></div>
                                    <div class="uk-width-auto uk-visible@s"><a class="uk-button uk-button-default uk-button-small uk-border-rounded uk-flex uk-flex-middle uk-text-capitalize" href="submissions.php"><?php echo echoOutput($translation['tr_253']); ?> <span class="uk-margin-small-left" uk-icon="icon: chevron-right; ratio: 0.8"></span></a></div>
                                </div>
                                </div>
                                <div class="uk-card-body uk-padding-small">
                                
                                <div class="uk-overflow-auto">
                                <table id="table_id" class="uk-table uk-table-middle uk-table-divider" style="width: 100%;">

                                <thead>
                                <tr>
                                    <th><?php echo echoOutput($translation['tr_258']); ?></th>
                                    <th><?php echo echoOutput($translation['tr_259']); ?></th>
                                    <th><?php echo echoOutput($translation['tr_260']); ?></th>
                                    <th><?php echo echoOutput($translation['tr_261']); ?></th>
                                    <th><?php echo echoOutput($translation['tr_262']); ?></th>
                                    <th><?php echo echoOutput($translation['tr_108']); ?></th>
                                </tr>
                                </thead>
                                </table>
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>

        <script>
            'use strict';
            $(document).ready(function(){
            
                $('#table_id').DataTable({
                "bProcessing": true,
                "sAjaxSource": SITEURL+"/dashboard/data.php?type=last10submissions",
                "responsive": true,
                "scrollX": true,
                "bPaginate":false,
                "bInfo" : false,
                "bFilter": false,
                "sPaginationType":"simple_numbers",
                "iDisplayLength": 10,
                "lengthChange": false,
                "fnCreatedRow": function( nRow, data, iDataIndex ) {
                $(nRow).addClass("id-"+data.deal_id);
                },
                "aoColumns": [
                { "mData": null , "width": "10%", "className": "uk-text-center", 'orderable': false,
                'searchable': false,
                "mRender" : function (data) {
                return '<a href="item.php?id='+data.deal_id+'"><img src="'+IMAGES_FOLDER+data.deal_image+'" class="uk-border-rounded"/></a>';}
                },
                { "mData": null,
                "mRender" : function (data) {
                return '<a href="item.php?id='+data.deal_id+'" class="uk-link-reset">'+data.deal_title+'</a>';}
                },
                { "mData": null,
                "mRender" : function (data) {
                return '<span>'+formatCount(data.deal_clicks)+'</span>';}
                },
                { "mData": null , "width": "5%", "className":"uk-text-center",
                "mRender" : function (data) {
                    return '<span>'+formatPrice(data.deal_price, "<?php echo $settings['st_currency']; ?>", "<?php echo $settings['st_currencyposition']; ?>", "<?php echo $settings['st_decimalnumber']; ?>", "<?php echo $settings['st_decimalseparator']; ?>")+'</span>';
                }
                },
                { "mData": null , "width": "5%", "className":"status uk-text-center",
                "mRender" : function (data) {
                if (data.deal_status == 1) {
                    return '<span class="uk-label uk-label-success"><?php echo echoOutput($translation['tr_250']); ?></span>';
                }else if (data.deal_status == 2) {
                    return '<span class="uk-label uk-label-warning"><?php echo echoOutput($translation['tr_251']); ?></span>';
                }else if (data.deal_status == 3) {
                    return '<span class="uk-label uk-label-warning"><?php echo echoOutput($translation['tr_252']); ?></span>';
                }else if (data.deal_status == 4) {
                    return '<span class="uk-label uk-label-danger"><?php echo echoOutput($translation['tr_266']); ?></span>';
                }else if (data.deal_status == 5) {
                    return '<span class="uk-label uk-label-warning"><?php echo echoOutput($translation['tr_447']); ?></span>';
                }
                }
                },
                { "mData": null ,
                "width": "14%",
                "className":"uk-text-center",
                'orderable': false,
                'searchable': false,
                "mRender" : function (data) {
                    if (data.deal_status == 4) {
                    return null;
                }else if (data.deal_status == 2) {
                    return '<div class="uk-flex uk-flex-center" uk-margin><a class="enableItem uk-text-success" uk-tooltip="Enable" uk-icon="check" data-url="enable_item.php?id='+data.deal_id+'"></a></div>';
                }else{
                    return '<div class="uk-flex uk-flex-center" uk-margin><a class="uk-link-muted" uk-tooltip="View" uk-icon="file-text" href="item.php?id='+data.deal_id+'"></a> <a class="uk-text-primary" uk-tooltip="Edit" uk-icon="file-edit" href="edit_item.php?id='+data.deal_id+'"></a> <a class="disableItem uk-text-warning" uk-tooltip="Disable" uk-icon="ban" data-url="disable_item.php?id='+data.deal_id+'"></a></div>';
                }
                    }
                }
                ]
            });

            });
        </script>
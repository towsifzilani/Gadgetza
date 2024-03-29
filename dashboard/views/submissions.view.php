<?php require 'menu.php'; ?>

<div class="content-padder">

    <div class="uk-section-small">
        <div class="uk-container uk-container-large">  

                <div class="uk-margin-bottom uk-flex uk-flex-middle" uk-grid>

                        <?php if(!empty($userPlanSettings)): ?>
                        <div class="uk-width-auto uk-text-left">
                        <p class="uk-margin-remove"><?= $userTotalOUploaded; ?> <?php echo echoOutput($translation['tr_365']); ?> <?= $userPlanSettings['plan_total']; ?> <?php echo echoOutput($translation['tr_366']); ?></p>
                        <progress style="height: 8px;" class="uk-progress" value="<?= $userTotalOUploaded; ?>" max="<?= $userPlanSettings['plan_total']; ?>"></progress>
                        </div>
                        <?php endif; ?>

                        <div class="uk-width-expand uk-text-right">
                        <a class="uk-button uk-button-secondary uk-text-capitalize uk-border-rounded" href="new_item.php">
                        <i uk-icon="icon: plus"></i>
                        <span class="uk-visible@s"><?php echo echoOutput($translation['tr_245']); ?></span>
                        </a>
                        </div>
                </div>

            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

            <h3 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_240']); ?></span></h3>

                                
                                <table id="table_id" class="uk-table uk-table-middle uk-table-divider" style="width: 100%">

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

            </div></div></div></div>

        <script>
            'use strict';
            $(document).ready(function(){
            
                $('#table_id').DataTable({
                "bProcessing": true,
                "sAjaxSource": SITEURL+"/dashboard/data.php?type=submissions",
                "responsive": true,
                "scrollX": true,
                "bPaginate":true,
                "sPaginationType":"simple_numbers",
                "iDisplayLength": 10,
                "lengthChange": false,
                /*"language": { search: "" },*/
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
<?php require 'menu.php'; ?>

<div class="content-padder uk-background-muted">

    <div class="uk-section-small">
        <div class="uk-container uk-container-large">  

            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered">

            <h3 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_242']); ?></span></h3>

            <?php if(!empty($userPlan)): ?>

            <div class="uk-grid-small" uk-grid>

            <div class="uk-width-1-expand uk-width-1-4@s">

                    <h4 class="uk-margin-remove"><?php echo echoOutput($translation['tr_408']); ?></h4>
                    <h3 class="uk-margin-remove"><?php echo echoOutput($userPlan['plan_title']); ?></h3>

                    <div class="uk-margin-top" uk-margin>
                    <?php if(!empty($userPlan['user_payment_subscription_id']) && !isset($userPlan['user_plan_canceled_date'])): ?>
                    <a class="uk-flex uk-flex-middle uk-link-text" href="<?php echo $urlPath->pricing(); ?>"><span class="uk-margin-small-right" uk-icon="icon: refresh; ratio: 0.8"></span> <?php echo echoOutput($translation['tr_423']); ?></a>
                    <a class="uk-flex uk-flex-middle uk-text-danger cancelSubscription" data-url="cancel_subscription.php" data-url="canceled.php"><span class="uk-margin-small-right" uk-icon="icon: ban; ratio: 0.8"></span> <?php echo echoOutput($translation['tr_424']); ?></a>
                    <?php else: ?>
                    <a class="uk-flex uk-flex-middle uk-text-success" target="_blank" href="<?php echo $urlPath->pricing(); ?>"><span class="uk-margin-small-right" uk-icon="icon: play-circle; ratio: 1"></span> <?php echo echoOutput($translation['tr_449']); ?></a>
                    <?php endif; ?>
                    </div>

            </div>

            <div class="uk-width-expand">

            <table class="uk-table uk-table-divider">
                <tbody>
                    <tr>
                        <td><?php echo echoOutput($translation['tr_409']); ?></td>
                        <td>
                            <?php if(!isExpiredSubscription() && !empty($userPlan['user_payment_subscription_id'])): ?>
                                <span class="uk-text-success uk-text-bold"><?php echo echoOutput($translation['tr_410']); ?></span>
                            <?php endif; ?>
                            <?php if(isExpiredSubscription() && !empty($userPlan['user_payment_subscription_id'])): ?>
                                <span class="uk-text-warning uk-text-bold"><?php echo echoOutput($translation['tr_411']); ?></span>
                            <?php endif; ?>

                            <?php if(empty($userPlan['user_payment_subscription_id'])): ?>
                            <span class="uk-text-danger uk-text-bold"><?php echo echoOutput($translation['tr_448']); ?></span>
                            <?php endif; ?>

                            </td>
                    </tr>
                    <tr>
                        <td><?php echo echoOutput($translation['tr_413']); ?></td>
                        <td><?php echo formatDate($userPlan['user_plan_expiration_date']); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo echoOutput($translation['tr_414']); ?></td>
                        <td><?php echo echoOutput($userPlan['payment_total_amount']); ?> <?php echo echoOutput($userPlan['payment_currency']); ?> / <span class="uk-text-capitalize"><?php echo getFrequencyText($userPlan['payment_frequency']); ?></span></td>
                    </tr>
                </tbody>
            </table>

            </div>

            </div>

            <?php endif; ?>

            <?php if(empty($userPlan)): ?>

                <p><?php echo echoOutput($translation['tr_415']); ?></p>

            <?php endif; ?>

            </div>

            <div class="uk-card uk-card-default uk-card-body uk-border-rounded uk-card-bordered uk-margin-top">

            <h3 class="uk-heading-line uk-text-bold"><span><?php echo echoOutput($translation['tr_416']); ?></span></h3>

                <table id="table_id" class="uk-table uk-table-middle uk-table-divider" style="width: 100%">
                <thead>
                <tr>
                    <th><?php echo echoOutput($translation['tr_417']); ?></th>
                    <th><?php echo echoOutput($translation['tr_418']); ?></th>
                    <th><?php echo echoOutput($translation['tr_419']); ?></th>
                    <th><?php echo echoOutput($translation['tr_420']); ?></th>
                    <th><?php echo echoOutput($translation['tr_421']); ?></th>
                    <th><?php echo echoOutput($translation['tr_422']); ?></th>
                </tr>
                </thead>
                </table>

            </div>



        </div>
    </div>
</div>

<script>
            'use strict';
            $(document).ready(function(){
            
                $('#table_id').DataTable({
                "bProcessing": true,
                "sAjaxSource": SITEURL+"/dashboard/data.php?type=payments",
                "responsive": true,
                "bPaginate":true,
                "scrollX": true,
                "sPaginationType":"simple_numbers",
                "iDisplayLength": 10,
                "lengthChange": false,
                /*"language": { search: "" },*/
                "fnCreatedRow": function( nRow, data, iDataIndex ) {
                $(nRow).addClass("id-"+data.payment_id);
                },
                "aoColumns": [
                    { "mData": null , "className":"uk-text-left",
                    "mRender" : function (data) {
                    return '<span>'+data.plan_title+'</span>';
                    }
                    },
                    { "mData": null , "className":"uk-text-left",
                    "mRender" : function (data) {
                    return '<span class="uk-text-capitalize">'+data.date_payment+'</span>';
                    }
                    },
                    { "mData": null , "width": "8%", "className":"uk-text-center",
                    "mRender" : function (data) {
                    return '<span>'+data.payment_total_amount+'</span>';
                    }
                    },
                    { "mData": null , "width": "8%", "className":"uk-text-center",
                    "mRender" : function (data) {
                    return '<span>'+data.payment_currency+'</span>';
                    }
                    },
                    { "mData": null , "width": "5%", "className":"status uk-text-center",
                    "mRender" : function (data) {
                    if (data.payment_status == 1) {
                    return '<span class="uk-text-success uk-text-bold">'+ST_PAYCOMPLETED+'</span>';
                    }else{
                    return '<span class="uk-text-warning uk-text-bold">'+ST_PAYUNKNOWN+'</span>';
                    }
                    }
                    },
                    { "mData": null , "className":"uk-text-center",
                    "mRender" : function (data) {
                    if (data.payment_status == 1) {
                    return '<a class="uk-button uk-button-default uk-border-rounded uk-button-small uk-text-capitalize" href="./invoice.php?id='+data.payment_id+'"><span uk-icon="icon: print; ratio: 0.8"></span></a>';
                    }
                    }
                    },
                ]
            });

            });
        </script>
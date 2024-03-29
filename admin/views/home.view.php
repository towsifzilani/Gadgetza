<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>

<!--Page Container-->
<section class="page-container">
    <div class="page-content-wrapper">

       <!--Main Content-->
       <div class="content sm-gutter">
        <div class="container-fluid padding-25 sm-padding-10">
            <div class="row">

                <div class="col-12">
                    <div class="section-title">
                        <h4><?php echo _SUMMARY; ?></h4>
                    </div>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <a href="../controller/deals.php">
                <div class="block counter-block mb-4">
                <i class="dripicons-tags i-icon"></i>
                <p class="label"><?php echo _DEALS; ?></p>
                <div class="value"><?php echo $deals_total; ?></div>
                </div>
                </a>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <a href="../controller/users.php">
                <div class="block counter-block mb-4">
                <i class="dripicons-user-group i-icon"></i>
                <p class="label"><?php echo _USERS; ?></p>
                <div class="value"><?php echo $users_total; ?></div>
                </div>
                </a>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <a href="../controller/sellers.php">
                <div class="block counter-block mb-4">
                <i class="dripicons-store i-icon"></i>
                <p class="label"><?php echo _SELLERS; ?></p>
                <div class="value"><?php echo $sellers_total; ?></div>
                </div>
                </a>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                <a href="../controller/payments.php">
                <div class="block counter-block mb-4">
                <i class="dripicons-wallet i-icon"></i>
                <p class="label"><?php echo _PAYMENTS; ?></p>
                <div class="value"><?php echo $payments_total; ?></div>
                </div>
                </a>
                </div>

                <div class="col-12 col-md-12 col-lg-6 mb-4">
                    <div class="block table-block mb-4 h-100">
                        <div class="block-heading d-flex align-items-center">
                            <h5 class="text-truncate">Latest Deals</h5>
                            <div class="graph-pills graph-home">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active active-2" href="../controller/deals.php"><?php echo _VIEWALL; ?> <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <?php if(!empty($latestdeals)): ?>
                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                        <?php foreach($latestdeals as $item): ?>
                                            <tr>
                                                <td class="product" width="50px">
                                                <img class="product-img" src="<?php echo $target_dir; ?><?php echo $item['deal_image']; ?>">
                                                </td>
                                                <td class="name"><span class="span-title"><a class="btn-link" href="../controller/edit_deal.php?id=<?php echo echoOutput($item['deal_id']) ?>"><?php echo echoOutput($item['deal_title']); ?></a></span></td>
                                                <?php if($item['deal_status'] == 1): ?>
                                                <td class="status success">
                                                <span><?php echo _ENABLED; ?></span>
                                                <?php elseif($item['deal_status'] == 2): ?>
                                                <td class="status danger">
                                                <span><?php echo _DISABLED; ?></span>
                                                <?php elseif($item['deal_status'] == 3): ?>
                                                <td class="status warning">
                                                <span><?php echo _PENDING; ?></span>
                                                <?php elseif($item['deal_status'] == 4): ?>
                                                <td class="status danger">
                                                <span><?php echo _REJECTED; ?></span>
                                                <?php endif; ?>
                                                </td>
                                                <td align="right" class="text-muted"><?php echo FormatDate($item['deal_created']); ?></td> 
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>

                            <?php if(empty($latestdeals)): ?>
                                <p class="text-muted text-center mt-4"><?php echo _NODATAFOUND; ?></p>
                            <?php endif; ?>


                    </div>
                </div> 

                <div class="col-12 col-md-12 col-lg-6 mb-4">
                    <div class="block table-block mb-4 h-100">
                        <div class="block-heading d-flex align-items-center">
                            <h5 class="text-truncate"><?php echo _MOSTVISIT; ?></h5>
                            <div class="graph-pills graph-home">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active active-2" href="../controller/deals.php"><?php echo _VIEWALL; ?> <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <?php if(!empty($topvisitdeals)): ?>
                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                    <?php foreach($topvisitdeals as $item): ?>
                                            <tr>
                                                <td class="product" width="50px">
                                                <img class="product-img" src="<?php echo $target_dir; ?><?php echo $item['deal_image']; ?>">
                                                </td>
                                                <td class="name"><span class="span-title"><a class="btn-link" href="../controller/edit_deal.php?id=<?php echo echoOutput($item['deal_id']) ?>"><?php echo echoOutput($item['deal_title']); ?></a></span></td>
                                                <td align="right" class="text-muted"><?php echo echoOutput($item['deal_clicks']); ?> <small><?php echo _TABLEFIELDCLICKS; ?></small></td> 
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>

                            <?php if(empty($topvisitdeals)): ?>
                                <p class="text-muted text-center mt-4"><?php echo _NODATAFOUND; ?></p>
                            <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-6 mb-4">
                    <div class="block table-block mb-4 h-100">
                        <div class="block-heading d-flex align-items-center">
                            <h5 class="text-truncate"><?php echo _LATESTPAYMENTS; ?></h5>
                            <div class="graph-pills graph-home">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active active-2" href="../controller/payments.php"><?php echo _VIEWALL; ?> <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <?php if(!empty($latestpayments)): ?>
                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                        <?php foreach($latestpayments as $item): ?>
                                            <tr>
                                                <td class="name"><span class="span-title"><a class="btn-link" href="../controller/payment_details.php?id=<?php echo echoOutput($item['payment_id']) ?>"><?php echo echoOutput($item['plan_title']); ?> (<span class="text-capitalize"><?php echo echoOutput($item['payment_frequency']); ?></span>)</a></span></td>
                                                <td class="name"><span class="span-title"><a class="btn-link" href="../controller/payment_details.php?id=<?php echo echoOutput($item['payment_id']) ?>"><?php echo echoOutput($item['payment_total_amount']); ?> <?php echo echoOutput($item['payment_currency']); ?></a></span></td>
                                                <td align="left" class="status <?php echo ($item['payment_status'] == 1 ? "success" : "pending"); ?>">
                                                <?php if($item['payment_status'] == 1): ?>
                                                    <span><?php echo _PAID; ?></span>
                                                <?php else: ?>
                                                    <span><?php echo _UNKNOWN; ?></span>
                                                <?php endif; ?>
                                                </td> 
                                                <td align="left" class="text-capitalize"><?php echo echoOutput($item['payment_processor']); ?></td> 
                                                <td align="right" class="text-muted"><?php echo FormatDate($item['payment_date']); ?></td> 
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>

                            <?php if(empty($latestpayments)): ?>
                                <p class="text-muted text-center mt-4"><?php echo _NODATAFOUND; ?></p>
                            <?php endif; ?>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-6 mb-4">
                    <div class="block table-block mb-4 h-100">
                        <div class="block-heading d-flex align-items-center">
                            <h5 class="text-truncate"><?php echo _LATESTUSERS; ?></h5>
                            <div class="graph-pills graph-home">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active active-2" href="../controller/users.php"><?php echo _VIEWALL; ?> <i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <?php if(!empty($latestusers)): ?>
                            <div class="table-responsive text-no-wrap">
                                <table class="table">
                                    <tbody class="text-middle">
                                        <?php foreach($latestusers as $item): ?>
                                            <tr>
                                                <td class="product" width="50px">
                                                <img class="product-img" src="<?php echo $target_dir; ?><?php echo $item['user_avatar']; ?>">
                                                </td>
                                                <td class="name"><span class="span-title"><a class="btn-link" href="../controller/edit_user.php?id=<?php echo echoOutput($item['user_id']) ?>"><?php echo echoOutput($item['user_name']); ?></a></span></td>
                                                <td class="name"><span class="span-title"><a class="btn-link" href="../controller/edit_user.php?id=<?php echo echoOutput($item['user_id']) ?>"><?php echo echoOutput($item['user_email']); ?></a></span></td>
                                                <td align="right" class="text-muted"><?php echo FormatDate($item['user_created']); ?></td> 
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>

                            <?php if(empty($latestusers)): ?>
                                <p class="text-muted text-center mt-4"><?php echo _NODATAFOUND; ?></p>
                            <?php endif; ?>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</section>
<?php require 'footer.php'; ?>

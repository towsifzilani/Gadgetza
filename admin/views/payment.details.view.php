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
              <h5><?php echo _PAYMENTDETAILS; ?></h5>
            </div>
          </div>

          <div class="col-12">
          <div class="form-row">

                <div class="form-group col-12 col-lg-3 sidebar mb-4">

                  <div class="block">
                  
                  <ul class="list-group">

                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo _TABLEFIELDBASEAMOUNT; ?>
                <span class="text-muted"><?php echo getPricePayment($payment['payment_base_amount'], $payment['payment_currency']); ?></span>
                </li>

                <?php if(!empty($payment['payment_discount_amount'])): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo _TABLEFIELDDISCOUNTEDAMOUNT; ?>
                <span class="text-muted"><?php echo getPricePayment($payment['payment_discount_amount'], $payment['payment_currency']); ?></span>
                </li>
                <?php endif; ?>

                <?php if(!empty($payment['payment_code'])): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo _TABLEFIELDCOUPONCODE; ?>
                <span class="text-muted"><?php echo $payment['payment_code']; ?></span>
                </li>
                <?php endif; ?>

                <?php if(!empty($payment['payment_taxes'])): ?>
                <li class="list-group-item">
                <?php echo _APPLIEDTAXES; ?>
                </li>
                <?php $taxes = get_taxes_by_ids($payment['payment_taxes']); ?>
                <?php foreach($taxes as $tax): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo $tax['tax_title']; ?>
                <span class="text-muted"><?php echo ($tax['tax_type'] == 'exclusive' ? '+' : null); ?><?php echo calc_taxes_by_price($payment['payment_base_amount'], $tax['tax_percentage']); ?> <?php echo $payment['payment_currency']; ?> (<?php echo $tax['tax_percentage']; ?>%)</span>
                </li>
                <?php endforeach; ?>
                </li>
                <?php endif; ?>

                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo _TABLEFIELDTOTALAMOUNT; ?>
                <span class="text-muted"><?php echo getPricePayment($payment['payment_total_amount'], $payment['payment_currency']); ?></span>
                </li>
                </ul>
                <br>
                <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                <?php echo _TABLEFIELDESTIMATEDEARNINGS; ?>
                <b class="text-success"><?php echo getPricePayment($payment['payment_total_amount'], $payment['payment_currency']); ?>*</b>
                </li>
                </ul>

                <small><?php echo _TABLEFIELDOTHERFEES; ?></small>

<a class="d-block mt-4 btn btn-primary" target="_blank" href="../controller/invoice.php?id=<?php echo $payment['payment_id']; ?>">
<?php echo _TABLEFIELDINVOICE; ?>
</a>

                  </div>

                </div>
                <div class="form-group col-12 col-lg-9 mb-4">
                
                <div class="block">
                
                <ul class="list-group">
                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDPLAN; ?></p>
                              <small class="text-muted"><?php echo _TABLEFIELDID; ?> <?php echo $payment['payment_plan_id']; ?></small>
                            </div>
                              <a target="_blank" class="text-muted" href="../controller/edit_plan.php?id=<?php echo $payment['payment_plan_id']; ?>">
                            <p class="mb-1"><?php echo $payment['plan_title']; ?></p>
                              </a>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDSELLER; ?></p>
                              <small class="text-muted"><?php echo _TABLEFIELDID; ?> <?php echo $payment['user_id']; ?></small>
                            </div>
                              <a target="_blank" class="text-muted" href="../controller/edit_user.php?id=<?php echo $payment['user_id']; ?>">
                            <p class="mb-1"><?php echo $payment['user_email']; ?></p>
                              </a>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDPAYER; ?></p>
                            </div>
                            <p class="mb-1"><?php if($payment['payment_name'] ? $payment['payment_name'] . " | " : null); ?><?php echo $payment['payment_email']; ?></p>
                          </li>
                        </ul>
                        
                        <br>
                        <ul class="list-group">
                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDTOTALAMOUNT; ?></p>
                            </div>
                            <p class="mb-1"><?php echo getPricePayment($payment['payment_total_amount'], $payment['payment_currency']); ?></p>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDBASEAMOUNT; ?></p>
                            </div>
                            <p class="mb-1"><?php echo getPricePayment($payment['payment_base_amount'], $payment['payment_currency']); ?></p>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDDISCOUNTEDAMOUNT; ?></p>
                            </div>
                            <p class="mb-1"><?php echo getPricePayment($payment['payment_discount_amount'], $payment['payment_currency']); ?></p>
                          </li>
                        </ul>

                        <br>
                        <ul class="list-group">
                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDFREQUENCY; ?></p>
                            </div>
                            <p class="mb-1"><?php echo $payment['payment_frequency']; ?></p>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDCURRENCY; ?></p>
                            </div>
                            <p class="mb-1"><?php echo $payment['payment_currency']; ?></p>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDCOUPONCODE; ?></p>
                            </div>
                            <p class="mb-1"><?php echo $payment['payment_code']; ?></p>
                          </li>
                        </ul>

                        <br>
                        <ul class="list-group">
                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDMETHOD; ?></p>
                            </div>
                            <p class="mb-1"><?php echo $payment['payment_processor']; ?></p>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1 text-muted"><?php echo _TABLEFIELDPAYMENTID; ?></p>
                            </div>
                            <p class="mb-1"><?php echo $payment['payment_external']; ?></p>
                          </li>

                          <li class="list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-between">
                              <p class="mb-1"><?php echo _TABLEFIELDDATE; ?></p>
                            </div>
                            <p class="mb-1 text-muted"><?php echo $payment['payment_date']; ?></p>
                          </li>
                        </ul>

                </div>

                </div>

          </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</section>

<?php require 'footer.php'; ?>

<!-- HEADER -->
<?php require './sections/header.php'; ?>

<script>
    'use strict';
    codeDiscount = null;
    plantaxes = <?php echo json_encode($data['payment_taxes'] ? $data['payment_taxes'] : null) ?>;

</script>

<!-- PAGE CONTENT -->

<div class="uk-container uk-margin-medium-top uk-margin-medium-bottom">
<h4><?php echo echoOutput($translation['tr_206']); ?> <b><?php echo echoOutput($planDetails['plan_title']); ?></b></h4>
</div>

<div class="uk-container uk-margin-top">

<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($urlPath->pay($planDetails['plan_id'])); ?>" method="post">

<div uk-grid>
    <div class="uk-width-1-1 uk-width-expand@s">
        <div class="uk-card uk-padding-remove uk-card-body uk-border-rounded plans">

    <?php if(!empty($errors)): ?>
<div class="uk-width-1-1 uk-text-left">
<div class="uk-margin">
<div class="tas-notify tas-notify-danger uk-text-small uk-border-rounded uk-margin-remove">
<ul class="uk-margin-remove">
<?php foreach($errors as $key => $value):?>
<li><?php echo echoOutput($value); ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>
<?php endif; ?>
        
<fieldset class="uk-border-rounded">
    <legend><?php echo echoOutput($translation['tr_207']); ?></legend>

    <input type="hidden" name="plan" value="<?php echo echoOutput($planDetails['plan_id']); ?>">

    <?php $i=0; foreach($pricesArray as $item): ?>

      <?php if($item['price'] != 0): ?>

      <label class="plan" for="<?php echo echoOutput($item['frequency']); ?>">
      <div class="plan_box">
      <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>

      <div class="uk-width-auto uk-flex uk-flex-center">

      <div class="pretty p-default p-round p-thick">
      <?php if($i == 0): ?>
      <input type="radio" name="frequency" data-frequency="<?php echo echoOutput($item['frequency']); ?>" data-freq="<?php echo echoOutput($item['label']); ?>" data-price="<?php echo echoOutput($item['price']); ?>" value="<?php echo echoOutput($item['frequency']); ?>" id="<?php echo echoOutput($item['frequency']); ?>" data-id="<?php echo echoOutput($item['frequency']); ?>" <?php echo (getFreqParam() == echoOutput($item['frequency']) || getFreqParam() == NULL ) ? 'checked' : NULL ?> required=""/>
      <?php endif; ?>
      <?php $i++; if($i > 1): ?>
      <input type="radio" name="frequency" data-frequency="<?php echo echoOutput($item['frequency']); ?>" data-freq="<?php echo echoOutput($item['label']); ?>" data-price="<?php echo echoOutput($item['price']); ?>" value="<?php echo echoOutput($item['frequency']); ?>" id="<?php echo echoOutput($item['frequency']); ?>" data-id="<?php echo echoOutput($item['frequency']); ?>" <?php echo (getFreqParam() == echoOutput($item['frequency']) ) ? 'checked' : NULL ?> required="" />
      <?php endif; ?>
        <div class="state p-primary-o">
          <label></label>
        </div>
      </div>

      </div>

      <div class="uk-width-expand">

      <h5 class="uk-margin-remove uk-text-bold"><?php echo echoOutput($item['label']); ?></h5>
      <p class="uk-margin-remove uk-text-muted uk-text-small uk-text-truncate"><?php echo echoOutput($item['description']); ?></p>

      </div>

      <div class="uk-width-1-3 uk-flex uk-flex-right">

      <h5 class="uk-margin-remove-top uk-text-bold"><?php echo echoOutput($item['price']); ?> <span class="uk-text-lighter"><?php echo echoOutput($settings['st_currencycode']); ?></span></h5>

      </div>

      </div>
      </div>
      </label>

    <?php endif; ?>
    <?php endforeach; ?>

</fieldset>

  <fieldset class="uk-border-rounded">
  <legend><?php echo echoOutput($translation['tr_208']); ?></legend>

  <?php if($settings['st_stripe_status'] == 1): ?>
  <label for="stripe">
  <div class="plan_box">
  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
  <div class="uk-width-auto uk-flex uk-flex-center">
  <div class="pretty p-default p-round p-thick">
  <input type="radio" name="payment" value="stripe" id="stripe" checked />
  <div class="state p-primary-o">
  <label></label>
  </div>
  </div>
  </div>

  <div class="uk-width-expand">
  <h5 class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_209']); ?></h5>
  </div>

  <div class="uk-width-1-3 uk-flex uk-flex-right">
  <img class="method uk-visible@s" src="<?php echo $urlPath->assets_img('stripe.png'); ?>"/>
  </div>

  </div>
  </div>
  </label>
  <?php endif; ?>

  <?php if($settings['st_paypal_status'] == 1): ?>
  <label for="paypal">
  <div class="plan_box">
  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
  <div class="uk-width-auto uk-flex uk-flex-center">
  <div class="pretty p-default p-round p-thick">
  <input type="radio" name="payment" value="paypal" id="paypal" />
  <div class="state p-primary-o">
  <label></label>
  </div>
  </div>
  </div>

  <div class="uk-width-expand">
  <h5 class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_210']); ?></h5>
  </div>

  <div class="uk-width-1-3 uk-flex uk-flex-right">
  <img class="method uk-visible@s" src="<?php echo $urlPath->assets_img('paypal.png'); ?>"/>
  </div>

  </div>
  </div>
  </label>
  <?php endif; ?>

  <?php if($settings['st_razorpay_status'] == 1): ?>
  <label for="razorpay">
  <div class="plan_box">
  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
  <div class="uk-width-auto uk-flex uk-flex-center">
  <div class="pretty p-default p-round p-thick">
  <input type="radio" name="payment" value="razorpay" id="razorpay" />
  <div class="state p-primary-o">
  <label></label>
  </div>
  </div>
  </div>

  <div class="uk-width-expand">
  <h5 class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_211']); ?></h5>
  </div>

  <div class="uk-width-1-3 uk-flex uk-flex-right">
  <img class="method uk-visible@s" src="<?php echo $urlPath->assets_img('razorpay.png'); ?>"/>
  </div>

  </div>
  </div>
  </label>
  <?php endif; ?>

  <?php if($settings['st_paystack_status'] == 1): ?>
  <label for="paystack">
  <div class="plan_box">
  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
  <div class="uk-width-auto uk-flex uk-flex-center">
  <div class="pretty p-default p-round p-thick">
  <input type="radio" name="payment" value="paystack" id="paystack" />
  <div class="state p-primary-o">
  <label></label>
  </div>
  </div>
  </div>

  <div class="uk-width-expand">
  <h5 class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_212']); ?></h5>
  </div>

  <div class="uk-width-1-3 uk-flex uk-flex-right">
  <img class="method uk-visible@s" src="<?php echo $urlPath->assets_img('paystack.png'); ?>"/>
  </div>

  </div>
  </div>
  </label>
  <?php endif; ?>

  <?php if($settings['st_mollie_status'] == 1): ?>
  <label for="mollie">
  <div class="plan_box">
  <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
  <div class="uk-width-auto uk-flex uk-flex-center">
  <div class="pretty p-default p-round p-thick">
  <input type="radio" name="payment" value="mollie" id="mollie" />
  <div class="state p-primary-o">
  <label></label>
  </div>
  </div>
  </div>

  <div class="uk-width-expand">
  <h5 class="uk-margin-remove uk-text-bold"><?php echo echoOutput($translation['tr_213']); ?></h5>
  </div>

  <div class="uk-width-1-3 uk-flex uk-flex-right">
  <img class="method uk-visible@s" src="<?php echo $urlPath->assets_img('mollie.png'); ?>"/>
  </div>

  </div>
  </div>
  </label>
  <?php endif; ?>

  </fieldset>

    <?php if(empty($userDetails['user_billing']) || $userDetails['user_billing'] == "[]"): ?>

  <fieldset class="uk-border-rounded">
  <legend><?php echo echoOutput($translation['tr_325']); ?></legend>

    <div class="uk-grid-small billing" uk-grid>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_356']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="text" name="billing_name">
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_357']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="text" name="billing_address" required="">
    </div>
    <div class="uk-width-1-2@s">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_358']); ?> <small class="uk-text-danger">*</small></label>
        <select class="nice-select wide uk-select uk-form-large" name="billing_country" required="">
        <?php foreach($countriesArray as $item => $value): ?>
        <option value="<?php echo $item; ?>"><?php echo $value; ?></option>
        <?php endforeach; ?>
        </select>
        </select>
    </div>
    <div class="uk-width-1-4@s">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_359']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="text" name="billing_city" required="">
    </div>
    <div class="uk-width-1-4@s">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_360']); ?> <small class="uk-text-danger">*</small></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="text" name="billing_zip" required="">
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_361']); ?></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="tel" name="billing_phone">
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_362']); ?></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="text" name="billing_company">
        <p class="uk-text-muted uk-text-small"><?php echo echoOutput($translation['tr_363']); ?></p>
    </div>
    <div class="uk-width-1-1">
        <label class="uk-form-label"><?php echo echoOutput($translation['tr_364']); ?></label>
        <input class="uk-input uk-form-large uk-border-rounded" type="text" name="billing_tax_id">
    </div>
    </div>

    <br>

  </fieldset>

    <?php endif; ?>


        </div>

    </div>


    <div class="uk-width-1-1 uk-width-1-3@s">
        <div class="uk-card uk-border-rounded">

        <div class="uk-card uk-card-default uk-card-body uk-border-rounded">

        <h5 class="uk-text-bold"><?php echo echoOutput($translation['tr_216']); ?></h5>

<hr>

        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-expand"><?php echo echoOutput($translation['tr_217']); ?></div>
          <div class="uk-width-auto"><?php echo echoOutput($planDetails['plan_title']); ?></div>
        </div>

        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-expand"><?php echo echoOutput($translation['tr_218']); ?></div>
          <div class="uk-width-auto"><span id="summary_plan_frequency"></span></div>
        </div>

        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-expand"><?php echo echoOutput($translation['tr_219']); ?></div>
          <div class="uk-width-auto"><span id="summary_plan_price"></span> <?php echo echoOutput($settings['st_currencycode']); ?></div>
        </div>

        <div id="summary_discount" class="uk-grid-small uk-hidden" uk-grid>
          <div class="uk-width-expand"><?php echo echoOutput($translation['tr_322']); ?></div>
          <div class="uk-width-auto uk-text-success"> <span id="discount_price"></span> <?php echo echoOutput($settings['st_currencycode']); ?> (<span id="discount_percentage"></span>%)</div>
        </div>

        <?php if(!empty($data['payment_taxes'])): ?>
          <hr>
        <?php foreach($data['payment_taxes'] as $item): ?>
        <div class="uk-grid-small uk-flex uk-flex-middle" uk-grid>
          <div class="uk-width-expand">
            <?php echo echoOutput($item['tax_title']); ?>
            <br><span class="uk-text-small uk-text-capitalize"><?php echo echoOutput($item['tax_type'] == 'exclusive' ? $translation['tr_323'] : $translation['tr_324']); ?></span>
          </div>
          <div class="uk-width-auto">
            <span id="summary_tax_id_<?php echo $item['tax_id']; ?>">
            <span class="tax-value"></span>
            </span>
            <?php echo echoOutput($settings['st_currencycode']); ?> (<?php echo echoOutput($item['tax_percentage']); ?>%)</div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

      <hr>

        <div class="uk-grid-small coupon" uk-grid>
          <div class="uk-width-expand">
            <input id="planid" value="<?php echo echoOutput($planDetails['plan_id']); ?>" type="hidden">
            <input class="uk-input uk-border-rounded" id="couponcode" name="coupon" type="text" placeholder="<?php echo echoOutput($translation['tr_220']); ?>">
          </div>
          <div class="uk-width-auto">
            <button class="applyCode uk-button uk-button-default uk-border-rounded" style="min-height: 40px;" value="<?php echo echoOutput($translation['tr_221']); ?>" type="submit" id="submit-coupon"><?php echo echoOutput($translation['tr_221']); ?></button>
          </div>
        </div>

        <div id="coderesults"></div>

      <hr>

        <div class="uk-grid-small uk-text-bold" uk-grid>
          <div class="uk-width-expand"><?php echo echoOutput($translation['tr_222']); ?></div>
          <div class="uk-width-auto"><span id="summary_total"></span> <?php echo echoOutput($settings['st_currencycode']); ?></div>
        </div>

      <hr>

        <button class="uk-button uk-button-primary uk-button-large uk-width-1-1 uk-border-rounded" type="submit" name="submit"><?php echo echoOutput($translation['tr_223']); ?> <span id="pay_total"></span> <?php echo echoOutput($settings['st_currencycode']); ?></a>

</div>

        <div class="uk-padding-small uk-margin-top">
          <h4><?php echo echoOutput($translation['tr_228']); ?></h4>

        <ul class="features uk-list uk-list-divider uk-margin-remove-bottom">
      <?php $planfeatures = json_decode($planDetails['plan_features'], true); ?>
      <?php if(!empty($planfeatures)): ?>
      <?php foreach ($planfeatures as $key => $value): ?>
        <?php if($value['status'] == 1): ?>
          <li><i class="ti ti-check uk-text-success success"></i> <?php echo echoOutput($value['title']); ?></li>
        <?php if(!empty($value['summary'])): ?>
          <div uk-drop="delay-hide: 100; duration: 100">
              <div class="tas_drop"><?php echo echoOutput($value['summary']); ?></div>
          </div>
        <?php endif; ?>
        <?php endif; ?>
        <?php if($value['status'] == 0): ?>
        <li><i class="ti ti-x uk-text-danger danger"></i> <?php echo echoOutput($value['title']); ?></li>
        <?php if(!empty($value['summary'])): ?>
        <div uk-drop="delay-hide: 100; duration: 100">
              <div class="tas_drop"><?php echo echoOutput($value['summary']); ?></div>
          </div>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach ?>
        <?php endif; ?>
      </ul>

      </div>

        </div>

    </div>
</div>

</form>

</div>

<!-- END PAGE CONTENT -->

<!-- FOOTER -->

<?php require './sections/footer.php'; ?>

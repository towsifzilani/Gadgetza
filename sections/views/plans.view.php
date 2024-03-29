<div class="uk-container">

<div class="uk-width-1-1 uk-margin-top" id="plans">

<div class="tas_heading uk-grid-collapse uk-flex uk-flex-middle uk-margin-medium-bottom" uk-grid>
        <div class="uk-width-expand">
            <h3 class="uk-heading-line uk-text-center"><span><?php echo echoOutput($translation['tr_345']); ?></span></h3>
        </div>
</div>

<div class="uk-flex uk-flex-center">
  <div class="uk-width-1-1 uk-width-1-2@s">
  <p class="uk-text-center"><?php echo echoOutput($translation['tr_355']); ?></p>
  </div>
</div>

<?php if(!empty($monthlyPlan) || !empty($annualPlan) || !empty($halfYearPlan)): ?>

<div uk-filter="target: .js-filter; animation: slide">

<?php if(!empty($monthlyPlan) && !empty($annualPlan) || !empty($halfYearPlan)): ?>

    <div class="uk-flex uk-flex-center">
    <ul class="tas_pricing_filter uk-subnav uk-subnav-pill">

<?php $i=0; foreach ($pricingFilter as $item): ?>

<?php if($item['interval'] != "" && !empty($item['interval'])): ?>

<?php if($i == 0): ?>
<li class="uk-active" data-plan="<?php echo echoOutput($item['key']); ?>" uk-filter-control="[data-plan='<?php echo echoOutput($item['key']); ?>']"><a href="#"><?php echo echoOutput($item['label']); ?></a></li>
<?php endif; ?>
<?php $i++; if($i > 1): ?>
<li data-plan="<?php echo echoOutput($item['key']); ?>" uk-filter-control="[data-plan='<?php echo echoOutput($item['key']); ?>']"><a href="#"><?php echo echoOutput($item['label']); ?></a></li>
<?php endif; ?>

<?php endif; ?>
<?php endforeach; ?>
    </ul>
    </div>
    <?php endif; ?>


<div class="uk-padding-small">
      <ul class="tas_pricing uk-flex uk-flex-middle uk-grid-medium uk-expand uk-child-width-1-1 uk-child-width-1-3@m  uk-child-width-1-2@s" uk-grid>
        <?php foreach ($getPlans as $item): ?>
        <div>
  <div class="card uk-card uk-card-default uk-card-body uk-box-shadow-small uk-box-shadow-hover-medium <?php echo $item['plan_recommended'] == 1 ? "card-recommended" : null ?>">

    <?php if($item['plan_recommended'] == 1): ?>
    <div class="recommended">
    <i class="ion-star"></i>
    </div>
    <?php endif; ?>

    <div class="tag">
      <p><?php echo echoOutput($item['plan_title']); ?></p>
    </div>
    
    <div class="price js-filter">
          <?php if($monthlyPlan): ?>
          <p class="number" data-plan="monthly" data-price="<?php echo echoOutput($item['plan_monthly']); ?>"><?php echo echoOutput($item['plan_monthly']); ?><span class="code"><?php echo echoOutput($settings['st_currencycode']); ?></span></p>
          <?php endif; ?>
          <?php if($halfYearPlan): ?>
          <p class="number" data-plan="halfyear" data-price="<?php echo echoOutput($item['plan_halfyear']); ?>"><?php echo echoOutput($item['plan_halfyear']); ?><span class="code"><?php echo echoOutput($settings['st_currencycode']); ?></span></p>
          <?php endif; ?>
          <?php if($annualPlan): ?>
          <p class="number" data-plan="annual" data-price="<?php echo echoOutput($item['plan_annual']); ?>"><?php echo echoOutput($item['plan_annual']); ?><span class="code"><?php echo echoOutput($settings['st_currencycode']); ?></span></p>
          <?php endif; ?>
    </div>

    <p class="description"><?php echo echoOutput($item['plan_description']); ?></p>
    
    <div class="uk-padding-small">
      <ul class="features uk-list uk-list-divider uk-margin-remove-bottom">
      <?php $planfeatures = json_decode($item['plan_features'], true); ?>
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

    <?php if(isLogged()): ?>

      <?php if(isset($userInfo['user_plan']) && !empty($userInfo['user_plan'])): ?>
      <?php if($userInfo['user_plan'] == $item['plan_id']): ?>
      <a data-plan="<?php echo echoOutput($item['plan_id']); ?>" class="uk-button uk-width-1-1 uk-border-rounded uk-button-secondary uk-margin-top uk-text-center choosePlan"><?php echo echoOutput($translation['tr_394']); ?></a>
      <?php else: ?>
        <a data-plan="<?php echo echoOutput($item['plan_id']); ?>" class="uk-button uk-width-1-1 uk-border-rounded uk-button-primary uk-margin-top uk-text-center choosePlan"><?php echo echoOutput($translation['tr_395']); ?></a>
      <?php endif; ?>

      <?php else: ?>
        <a data-plan="<?php echo echoOutput($item['plan_id']); ?>" class="uk-button uk-width-1-1 uk-border-rounded uk-button-primary uk-margin-top uk-text-center choosePlan"><?php echo echoOutput($translation['tr_205']); ?></a>
      <?php endif; ?>


    <?php endif; ?>

    <?php if(!isLogged()): ?>
    <a href="<?php echo $urlPath->signin(); ?>" class="uk-button uk-width-1-1 uk-border-rounded uk-button-primary uk-margin-top uk-text-center"><?php echo echoOutput($translation['tr_205']); ?></a>
    <?php endif; ?>

    </div>
    </div>

        <?php endforeach ?>
      </ul>

    </div>
    </div>

    <?php endif; ?>

</div>

</div>

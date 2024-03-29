<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){

    var interval = $(".filters a[class*='active']").data('interval');
    var selected = $(".filters a[class*='active']").data('label');

    if(interval){$('.selectedInterval').html(selected);}

  });
</script>

<!--Page Container-->
<section class="page-container">
<div class="page-content-wrapper">

<!--Main Content-->

<div class="content sm-gutter">
<div class="container-fluid padding-25 sm-padding-10">

<div class="row">

<div class="col-6 d-flex align-items-center">

<div class="section-title">
<h5 class="text-truncate"><?php echo _STATISTICS; ?></h5>
</div>

</div>

<div class="col-6 d-flex align-items-center justify-content-end">

<div class="inline-block">

<div class="dropdown dropleft">
<button class="btn btn-primary dropdown-toggle text-capitalize" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
<i class="fa fa-filter add-new-i"></i> <?php echo (!getInterval() ? _FILTERS : '<span class="selectedInterval"></span>'); ?>
</button>
<div class="dropdown-menu dropdown-menu-right filters " aria-label="dropdownMenuButton">
<a href="./statistics.php?interval=today" class="dropdown-item pointer <?php echo (getInterval() == "today" ? "active" : null); ?>" data-interval="today" data-label="<?php echo _INTERVALTODAY; ?>"><?php echo _INTERVALTODAY; ?></a>
<a href="./statistics.php?interval=yesterday" class="dropdown-item pointer <?php echo (getInterval() == "yesterday" ? "active" : null); ?>" data-interval="yesterday" data-label="<?php echo _INTERVALYESTERDAY; ?>"><?php echo _INTERVALYESTERDAY; ?></a>
<a href="./statistics.php?interval=last7days" class="dropdown-item pointer <?php echo (getInterval() == "last7days" ? "active" : null); ?>" data-interval="last7days" data-label="<?php echo _INTERVALLAST7DAYS; ?>"><?php echo _INTERVALLAST7DAYS; ?></a>
<a href="./statistics.php?interval=last30days" class="dropdown-item pointer <?php echo (getInterval() == "last30days" ? "active" : null); ?>" data-interval="last30days" data-label="<?php echo _INTERVALLAST30DAYS; ?>"><?php echo _INTERVALLAST30DAYS; ?></a>
<a href="./statistics.php?interval=last6months" class="dropdown-item pointer <?php echo (getInterval() == "last6months" ? "active" : null); ?>" data-interval="last6months" data-label="<?php echo _INTERVALLAST6MONTHS; ?>"><?php echo _INTERVALLAST6MONTHS; ?></a>
<a href="./statistics.php?interval=lastyear" class="dropdown-item pointer <?php echo (getInterval() == "lastyear" ? "active" : null); ?>" data-interval="lastyear" data-label="<?php echo _INTERVALLASTYEAR; ?>"><?php echo _INTERVALLASTYEAR; ?></a>
<a href="./statistics.php?interval=alltime" class="dropdown-item pointer <?php echo (getInterval() == "alltime" ? "active" : null); ?>" data-interval="alltime" data-label="<?php echo _INTERVALALLTIME; ?>"><?php echo _INTERVALALLTIME; ?></a>
</div>
</div>

</div>

</div>

</div>

<div class="row mt-4">

<div class="col-12">
<div class="block table-block mb-3">

  <div class="graph-block">
      <div class="block-heading m-0 p-0">
          <h6 class="font-weight-bold"><?php echo _SECTIONCLICKS; ?></h6>
          <hr>
      </div>
  <?php if(empty(get_total_clicks_by_interval())): ?>
    <p class="text-muted mt-0"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
      <div class="chart">
          <canvas id="filledLineChart" class="chart"></canvas>
      </div>
  <?php endif; ?>

  </div>

</div>
</div>

</div>

<div class="row mb-4">

  <div class="col-12 col-sm-6 col-md-6 col-lg-2 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0 pb-0">
  <h6 class="font-weight-bold"><?php echo _DEALS; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>

<div class="chart-legends">
    <div class="legend-value-w">
        <div class="legend-pin bg-light"></div>
        <div class="legend-value"><b><?php echo get_deals_count_by_status(3); ?></b> <?php echo _PENDING; ?></div>
    </div>
    <div class="legend-value-w">
        <div class="legend-pin bg-success"></div>
        <div class="legend-value"><b><?php echo get_deals_count_by_status(1); ?></b> <?php echo _ENABLED; ?></div>
    </div>
    <div class="legend-value-w">
        <div class="legend-pin bg-warning"></div>
        <div class="legend-value"><b><?php echo get_deals_count_by_status(2); ?></b> <?php echo _DISABLED; ?></div>
    </div>
    <div class="legend-value-w">
        <div class="legend-pin bg-danger"></div>
        <div class="legend-value"><b><?php echo get_deals_count_by_status(4); ?></b> <?php echo _REJECTED; ?></div>
    </div>
</div>

<hr>

<p><?php echo _EXLUSIVEITEMS; ?> <b><?php echo get_deals_count_by_status(null, 1); ?></b></p>
<p><?php echo _FEATUREDITEMS; ?> <b><?php echo get_deals_count_by_status(null, null, 1); ?></b></p>

  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0 pb-0">
  <h6 class="font-weight-bold"><?php echo _MOSTVISIT; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>

  <?php if(empty($topdeals)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>

  <ul class="list-group list-group-flush">
  <?php foreach ($topdeals as $item): ?>
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
    <p class="text-truncate"><a class="text-dark text-truncate" href="../controller/stats.php?id=<?php echo echoOutput($item['deal_id']); ?>"><?php echo echoOutput($item['deal_title']); ?></a></p>
    <span class="badge badge-light bdg-s badge-pill"><?php echo echoOutput($item['num']); ?></span>
  </li>
  <?php endforeach; ?>
  </ul>

  <?php endif; ?>
  
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-2 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0 pb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONCLICKS; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>

  <div class="row">
  <div class="col-6 col-md-12">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo get_total_clicks(); ?></div>
  <p class="label"><?php echo _TABLEFIELDTOTALCLICKS; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-12">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo get_total_clicks(1); ?></div>
  <p class="label"><?php echo _TABLEFIELDUNIQUECLICKS; ?></p>
  </div>
  </div>
  </div>

  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-2 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _USERS; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>

  <ul class="list-group list-group-flush">
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
      <p class="text-truncate"><?php echo _REGISTEREDUSERS; ?></p>
      <span class="badge badge-light bdg-s badge-pill"><?php echo get_total_users(); ?></span>
  </li>
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
      <p class="text-truncate"><?php echo _VERIFIEDUSERS; ?></p>
      <span class="badge badge-light bdg-s badge-pill"><?php echo get_total_users(1); ?></span>
  </li>
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
      <p class="text-truncate"><?php echo _NEWSELLERS; ?></p>
      <span class="badge badge-light bdg-s badge-pill"><?php echo get_total_sellers(); ?></span>
  </li>
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
      <p class="text-truncate"><?php echo _NEWSUBSCRIBERS; ?></p>
      <span class="badge badge-light bdg-s badge-pill"><?php echo totalSubscribers(); ?></span>
  </li>
  </ul>

  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-2 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _EARNINGS; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>

  <div class="row">
  <div class="col-6 col-md-12">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo getPrice($earnings['total_earnings']); ?></div>
  <p class="label"><?php echo _EARNINGS; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-12">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo echoOutput($earnings['total_payments']); ?></div>
  <p class="label"><?php echo _PAYMENTS; ?></p>
  </div>
  </div>
  </div>

  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-3 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0 pb-0">
  <h6 class="font-weight-bold"><?php echo _LATESTPAYMENTS; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>
    
  <?php if(!empty($latestpayments)): ?>
  <ul class="list-group list-group-flush">
    <?php foreach ($latestpayments as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><a class="text-dark" href="../controller/payment_details.php?id=<?php echo echoOutput($item['payment_id']) ?>"><?php echo echoOutput($item['plan_title']); ?> (<span class="text-capitalize"><?php echo echoOutput($item['payment_frequency']); ?></span>)</a></p>
        <span><?php echo echoOutput($item['payment_total_amount']); ?> <?php echo echoOutput($item['payment_currency']); ?></a></span>
    </li>
    <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <?php if(empty($latestpayments)): ?>
        <p class="text-muted text-center mt-4"><?php echo _NODATAFOUND; ?></p>
    <?php endif; ?>

  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SITECOUNT; ?></h6>
  <hr>
    
<div class="row">

  <div class="col-6 col-md-4">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo categories_total(); ?></div>
  <p class="label"><?php echo _CATEGORIES; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-4">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo subcategories_total(); ?></div>
  <p class="label"><?php echo _SUBCATEGORIES; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-4">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo stores_total(); ?></div>
  <p class="label"><?php echo _STORES; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-4">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo locations_total(); ?></div>
  <p class="label"><?php echo _LOCATIONS; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-4">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo sliders_total(); ?></div>
  <p class="label"><?php echo _SLIDERS; ?></p>
  </div>
  </div>

  <div class="col-6 col-md-4">
  <div class="counter-block mt-3 mb-0">
  <div class="value"><?php echo comments_total(); ?></div>
  <p class="label"><?php echo _COMMENTS; ?></p>
  </div>
  </div>

</div>

  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-3 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0 pb-0">
  <h6 class="font-weight-bold"><?php echo _TOPCOUNTRIES; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>

  <?php if(empty($topcountries)): ?>
  <p class="text-muted text-center mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>

  <ul class="list-group list-group-flush">
  <?php foreach ($topcountries as $item): ?>
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
    <p class="text-truncate"><i class="fi fi-<?php echo echoOutput($item['track_country_code'] ? $item['track_country_code'] : 'xx'); ?> mr-1 rounded"></i> <?php echo echoOutput($item['track_country_name'] ? $item['track_country_name'] : 'Unknown'); ?></p>
    <span class="badge badge-light bdg-s badge-pill"><?php echo echoOutput($item['total']); ?></span>
  </li>
  <?php endforeach; ?>
  </ul>

  <?php endif; ?>
  
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-2 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0 pb-0">
  <h6 class="font-weight-bold"><?php echo _TOPCITIES; ?> <small>(<span class="selectedInterval text-capitalize"></span>)</small></h6>
  <hr>

  <?php if(empty($topcities)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>

    <ul class="list-group list-group-flush">
  <?php foreach ($topcities as $item): ?>
  <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
    <p class="text-truncate"><?php echo echoOutput($item['track_city'] ? $item['track_city'] : 'Unknown'); ?></p>
    <span class="badge badge-light bdg-s badge-pill"><?php echo echoOutput($item['total']); ?></span>
  </li>
  <?php endforeach; ?>
  </ul>

  <?php endif; ?>
  
  </div>
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

<script type="text/javascript">

    'use strict';
  $(document).ready(function () {
    barChart();
  });

  function barChart() {{

  var lightColor ='#f1f1f1';
  var secondaryColor = '#a5b5c5';

  if ($("#filledLineChart").length) {
  var filledLineChart = document.getElementById("filledLineChart").getContext('2d');

  let gradient = filledLineChart.createLinearGradient(0, 0, 0, 250);
  gradient.addColorStop(0, 'rgba(24, 188, 201, 0.6)');
  gradient.addColorStop(1, 'rgba(24, 188, 201, 0.05)');

  let gradient_white = filledLineChart.createLinearGradient(0, 0, 0, 250);
  gradient_white.addColorStop(0, 'rgba(246, 95, 110,0.6)');
  gradient_white.addColorStop(1, 'rgba(246, 95, 110, 0.05)');

  var data = <?php echo (get_total_clicks_by_interval() ? get_total_clicks_by_interval() : "[]"); ?>;
  var name = [];
  var totalclicks = [];
  var uniqueclicks = [];
  for (var i in data) {
  name.push(data[i].label);
  totalclicks.push(data[i].clicks);
  uniqueclicks.push(data[i].uniqueclicks);
  }

  // line chart data
  var filledLineData = {
  labels: name,
  datasets: [{
  label: '<?= _TABLEFIELDALLCLICKS; ?>',
  data: totalclicks,
  fill: true,
  backgroundColor: gradient,
  borderColor: "#18BCC9",
  },
  {
  label: '<?= _TABLEFIELDUNIQUECLICKS; ?>',
  data: uniqueclicks,
  fill: true,
  backgroundColor: gradient_white,
  borderColor: "#f65f6e",
  }]
  };

  // line chart init
  var filledLineChart = new Chart(filledLineChart, {
  type: 'line',
  data: filledLineData,
  options: {
  responsive: true,
  maintainAspectRatio: false,
  aspectRatio: 1, 
  hover: {mode: null},
  animation: {
  duration: 0
  },
  hover: {
  animationDuration: 0
  },
  responsiveAnimationDuration: 0,
  elements: {
  line: {
  tension: 0
  }
  },
  tooltips: {
  mode: 'index',
  intersect: false,
  xPadding: 12,
  yPadding: 12,
  titleFontColor: '#2a3f5a',
  titleSpacing: 30,
  titleFontSize: 16,
  titleFontStyle: 'bold',
  titleMarginBottom: 10,
  bodyFontColor: '#2a3f5a',
  bodyFontSize: 14,
  bodySpacing: 10,
  backgroundColor: 'white',
  footerMarginTop: 10,
  footerFontStyle: 'normal',
  footerFontSize: 12,
  cornerRadius: 4,
  caretSize: 6,
  },
  title: {
  text: '',
  display: true
  },
  scales: {
  xAxes: [{
  ticks: {
  fontSize: '13',
  fontColor: secondaryColor
  },
  gridLines: {
  color: lightColor,
  zeroLineColor: lightColor
  }
  }],
  yAxes: [{
  /*display: true,*/
  ticks: {
  beginAtZero: true,
  fontSize: '13',
  fontColor: secondaryColor
  },
  gridLines: {
  color: 'transparent',
  zeroLineColor: 'transparent'
  }
  }]
  }
  }
  });
  }
  }
  }

</script>

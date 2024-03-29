<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
  $(document).ready(function(){

    var interval = $(".filters a[class*='active']").data('interval');
    var stats = $(".nav-item a[class*='active']").data('stats');
    var selected = $(".filters a[class*='active']").data('label');

    if(interval){$('.selectedInterval').html(selected);}
    if(stats){$('.selectedStats').html(stats);}

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
<h5 class="text-truncate"><?php echo _ITEMSTATS; ?></h5>
</div>

</div>

<div class="col-6 d-flex align-items-center justify-content-end">

<div class="inline-block">

<div class="dropdown dropleft">
<button class="btn btn-primary dropdown-toggle text-capitalize" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
<i class="fa fa-filter add-new-i"></i> <?php echo (!getInterval() ? _FILTERS : '<span class="selectedInterval"></span>'); ?>
</button>
<div class="dropdown-menu dropdown-menu-right filters " aria-label="dropdownMenuButton">
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=today<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "today" ? "active" : null); ?>" data-interval="today" data-label="<?php echo _INTERVALTODAY; ?>"><?php echo _INTERVALTODAY; ?></a>
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=yesterday<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "yesterday" ? "active" : null); ?>" data-interval="yesterday" data-label="<?php echo _INTERVALYESTERDAY; ?>"><?php echo _INTERVALYESTERDAY; ?></a>
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=last7days<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "last7days" ? "active" : null); ?>" data-interval="last7days" data-label="<?php echo _INTERVALLAST7DAYS; ?>"><?php echo _INTERVALLAST7DAYS; ?></a>
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=last30days<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "last30days" ? "active" : null); ?>" data-interval="last30days" data-label="<?php echo _INTERVALLAST30DAYS; ?>"><?php echo _INTERVALLAST30DAYS; ?></a>
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=last6months<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "last6months" ? "active" : null); ?>" data-interval="last6months" data-label="<?php echo _INTERVALLAST6MONTHS; ?>"><?php echo _INTERVALLAST6MONTHS; ?></a>
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=lastyear<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "lastyear" ? "active" : null); ?>" data-interval="lastyear" data-label="<?php echo _INTERVALLASTYEAR; ?>"><?php echo _INTERVALLASTYEAR; ?></a>
<a href="./stats.php?id=<?php echo $deal['deal_id']; ?>&interval=alltime<?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>" class="dropdown-item pointer <?php echo (getInterval() == "alltime" ? "active" : null); ?>" data-interval="alltime" data-label="<?php echo _INTERVALALLTIME; ?>"><?php echo _INTERVALALLTIME; ?></a>
</div>
</div>

</div>

</div>

</div>

<div class="pb-4">
<h5 class="text-truncate"><?php echo $deal['deal_title']; ?></h5>
</div>

<div class="row">

<div class="col d-flex align-items-center justify-content-start">

<nav class="navbar navbar-expand-xl w-100 px-1 bg-base-0 block">
  <div class="d-flex align-items-center d-xl-none px-3 font-weight-medium">
  <?php echo _SECTIONES; ?>
  </div>
  <button class="navbar-toggler border-0 py-2 ml-auto collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <i class="fa fa-bars"></i>
  </button>

  <div class="navbar-collapse border-top border-top-xl-0 collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto stats">
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (!getStatsFor() ? "active" : null) ?>" data-stats="<?php echo _SECTIONOVERVIEW; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>">
    <i class="dripicons-graph-bar fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONOVERVIEW; ?></span>
  </a>
</li>

<li class="nav-item">
      <a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "referrers" ? "active" : null) ?>" data-stats="<?php echo _SECTIONREFERRERS; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=referrers">
    <i class="dripicons-link fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONREFERRERS; ?></span>
</a>
</li>

<li class="nav-item">
<a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "countries" ? "active" : null) ?>" data-stats="<?php echo _SECTIONCOUNTRIES; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=countries">
    <i class="dripicons-flag fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONCOUNTRIES; ?></span>
</a>
</li>

<li class="nav-item">
<a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "cities" ? "active" : null) ?>" data-stats="<?php echo _SECTIONCITIES; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=cities">
    <i class="dripicons-location fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONCITIES; ?></span>
</a>
</li>

<li class="nav-item">
<a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "languages" ? "active" : null) ?>" data-stats="<?php echo _SECTIONLANGUAGES; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=languages">
    <i class="dripicons-web fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONLANGUAGES; ?></span>
</a>
</li>

<li class="nav-item">
<a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "os" ? "active" : null) ?>" data-stats="<?php echo _SECTIONOPERATING; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=os">
    <i class="dripicons-device-desktop fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONOPERATING; ?></span>
</a>
</li>

<li class="nav-item">
<a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "browsers" ? "active" : null) ?>" data-stats="<?php echo _SECTIONBROWSERS; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=browsers">
    <i class="dripicons-browser fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONBROWSERS; ?></span>
</a>
</li>

<li class="nav-item">
<a class="nav-link d-flex align-items-center font-weight-medium py-3 px-3 <?php echo (getStatsFor() == "devices" ? "active" : null) ?>" data-stats="<?php echo _SECTIONDEVICES; ?>" href="./stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?>&for=devices">
    <i class="dripicons-device-mobile fill-current mr-2" aria-hidden="true"></i>
    <span><?php echo _SECTIONDEVICES; ?></span>
</a>
</li>
    </ul>
  </div>
</nav>

</div>

</div>

<?php if(!getStatsFor()): ?>

<div class="row mt-4">

<div class="col-12">
<div class="block table-block mb-3">

  <div class="graph-block">
      <div class="block-heading m-0 p-0">
          <h6 class="font-weight-bold"><?php echo _SECTIONCLICKS; ?></h6>
          <hr>
      </div>
  <?php if(empty($dealClicks)): ?>
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

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONREFERRERS; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealReferrers)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
    
    <ul class="list-group list-group-flush">
    <?php foreach ($dealReferrers as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><?php echo echoOutput($item['track_host'] ? $item['track_host'] : 'Direct'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-3 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONBROWSERS; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealBrowsers)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
    
    <ul class="list-group list-group-flush">
    <?php foreach ($dealBrowsers as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><?php echo echoOutput($item['track_browser'] ? $item['track_browser'] : 'Unknown'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-3 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONCOUNTRIES; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealCountries)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>

    <ul class="list-group list-group-flush">
    <?php foreach ($dealCountries as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><i class="fi fi-<?php echo echoOutput($item['track_country_code'] ? $item['track_country_code'] : 'xx'); ?> mr-1 rounded"></i> <?php echo echoOutput($item['track_country_name'] ? $item['track_country_name'] : 'Unknown'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-2 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONCITIES; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealCities)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
    
    <ul class="list-group list-group-flush">
    <?php foreach ($dealCities as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><?php echo echoOutput($item['track_city'] ? $item['track_city'] : 'Unknown'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONDEVICES; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealDevices)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
    
    <ul class="list-group list-group-flush">
    <?php foreach ($dealDevices as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-capitalize"><i class="align-middle dripicons-device-<?php echo echoOutput($item['track_device']); ?> mr-1"></i> <?php echo echoOutput($item['track_device'] ? $item['track_device'] : 'Unknown'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONOPERATING; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealOS)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
    
    <ul class="list-group list-group-flush">
    <?php foreach ($dealOS as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><?php echo echoOutput($item['track_os'] ? $item['track_os'] : 'Unknown'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 my-3">
  <div class="block table-block mb-2 h-100">
  <div class="block-heading mb-0">
  <h6 class="font-weight-bold"><?php echo _SECTIONLANGUAGES; ?> <small class="float-right text-capitalize"><?php echo _TABLEFIELDTOTALCLICKS; ?></small></h6>
  <hr>
  <?php if(empty($dealLanguages)): ?>
  <p class="text-muted mt-4"><?php echo _NODATAFOUND; ?></p>
  <?php else: ?>
    
    <ul class="list-group list-group-flush">
    <?php foreach ($dealLanguages as $item): ?>
    <li class="list-group-item first-child-border d-flex justify-content-between align-items-center px-0">
        <p class="text-truncate"><?php echo echoOutput($item['track_browser_language'] ? get_language_from_locale($languagesArray, $item['track_browser_language'])  : 'Unknown'); ?></p>
        <span class="badge badge-light bdg-s badge-pill"><?php echo countFormat($item['total']); ?></span>
    </li>
    <?php endforeach; ?>
    </ul>

  <?php endif; ?>
  </div>
  </div>
  </div>

</div>

<?php endif; ?>

<?php if(getStatsFor() == "referrers"
        || getStatsFor() == "countries"
        || getStatsFor() == "cities"
        || getStatsFor() == "languages"
        || getStatsFor() == "os"
        || getStatsFor() == "browsers"
        || getStatsFor() == "devices"): ?>

    <div class="row mt-4">

<div class="col-12">
<div class="block table-block mb-3">

  <p class="font-weight-bold selectedStats"></p>
  <hr>

  <div class="row">
  <div class="table-responsive">
  <table id="table_id" class="table" cellspacing="0" width="100%" style="border-radius: 5px;">
  <thead>
  <tr>
  <th><?php echo _TABLEFIELDTITLE; ?></th>
  <th><?php echo _TABLEFIELDTOTALCLICKS; ?></th>
  <th><?php echo _TABLEFIELDUNIQUECLICKS; ?></th>
  </tr>
  </thead>
  </table>

  </div>
  </div>

</div>
</div>

</div>

<?php endif; ?>

</div>
</div>
</div>
</div>
</div>
</section>

<?php require 'footer.php'; ?>

<script type="text/javascript">

  $(document).ready(function(){

    $('#table_id').dataTable({
     "bProcessing": true,
     "sAjaxSource": "../controller/get_stats.php?id=<?php echo $deal['deal_id']; ?><?php echo (getInterval() ? "&interval=".getInterval() : null) ?><?php echo (getStatsFor() ? "&for=".getStatsFor() : null) ?>",
     "responsive": true,
     "bPaginate":true,
     "aaSorting": [[2,'desc']],
     "sPaginationType":"full_numbers",
     "iDisplayLength": 10,
     "aoColumns": [
        { "mData": null , "width": "7%", "className":"text-left",
     "mRender" : function (data) {
        return '<span>'+(data.title ? data.title : 'Unknown')+'</span>';
      }
    },
    { mData: 'total', "width": "5%", "className": "text-center" },
    { mData: 'totalunique', "width": "5%", "className": "text-center" }
]
});
  });
</script>

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

  var data = <?php echo ($dealClicks ? $dealClicks : "[]"); ?>;
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
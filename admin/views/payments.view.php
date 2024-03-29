<?php require 'header.php'; ?>
<?php require 'sidebar.php'; ?>  

<script type="text/javascript">
$(document).ready(function(){

var interval = $(".filters a[class*='active']").data('interval');
var selected = $(".filters a[class*='active']").data('label');

if(interval){
$('.selectedInterval').html(selected);
}

$('#table_id').dataTable({
"bProcessing": true,
"sAjaxSource": "../controller/get_payments.php?interval="+interval,
"responsive": true,
"bPaginate":true,
"aaSorting": [[1,'desc']],
"sPaginationType":"full_numbers",
"iDisplayLength": 10,
"aoColumns": [
{ mData: 'payment_external', "width": "5%", "className": "text-left" },
{ "mData": null , "className":"text-left",
"mRender" : function (data) {
return '<a class="text-muted" href="./edit_user.php?id='+data.payment_user_id+'">'+data.user_email+'</a>';
}
},
{ "mData": null , "className":"text-left",
"mRender" : function (data) {
return '<span class="text-capitalize">'+data.payment_processor+'</span>';
}
},
{ "mData": null , "className":"text-center",
"mRender" : function (data) {
return '<a class="text-muted" href="./edit_plan.php?id='+data.plan_id+'">'+data.plan_title+'</a>';
}
},
{ "mData": null , "width": "8%", "className":"text-center",
"mRender" : function (data) {
return '<span>'+data.payment_total_amount+'</span>';
}
},
{ "mData": null , "width": "8%", "className":"text-center",
"mRender" : function (data) {
return '<span>'+data.payment_currency+'</span>';
}
},
{ "mData": null , "width": "5%", "className":"status text-center",
"mRender" : function (data) {
if (data.payment_status == 1) {
return '<span class="label badge-pill bg-success"><?php echo _PAID; ?></span>';
}else{
return '<span class="label badge-pill bg-danger"><?php echo _UNKNOWN; ?></span>';
}
}
},
{ mData: 'payment_date', "className": "text-center" },
{ "mData": null ,
"width": "14%",
"className": "text-center",
'orderable': false,
'searchable': false,
"mRender" : function (data) {
return "<a class='btn btn-small btn-info' href='../controller/payment_details.php?id="+data.payment_id+"'>"+VIEWITEM+"</a> <a class='btn btn-small btn-primary' target='_blank' href='../controller/invoice.php?id="+data.payment_id+"'>"+INVOICE+"</a>";}
}
]
});
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
<h5 class="text-truncate"><?php echo _PAYMENTS; ?></h5>
</div>

</div>

<div class="col-6 d-flex align-items-center justify-content-end">

<div class="inline-block">

<div class="dropdown dropleft">
<button class="btn btn-primary dropdown-toggle text-capitalize" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
<i class="fa fa-filter add-new-i"></i> <?php echo (!getInterval() ? _FILTERS : '<span class="selectedInterval"></span>'); ?>
</button>
<div class="dropdown-menu dropdown-menu-right filters " aria-label="dropdownMenuButton">
<a href="./payments.php?interval=today" class="dropdown-item pointer <?php echo (getInterval() == "today" ? "active" : null); ?>" data-interval="today" data-label="<?php echo _INTERVALTODAY; ?>"><?php echo _INTERVALTODAY; ?></a>
<a href="./payments.php?interval=yesterday" class="dropdown-item pointer <?php echo (getInterval() == "yesterday" ? "active" : null); ?>" data-interval="yesterday" data-label="<?php echo _INTERVALYESTERDAY; ?>"><?php echo _INTERVALYESTERDAY; ?></a>
<a href="./payments.php?interval=last7days" class="dropdown-item pointer <?php echo (getInterval() == "last7days" ? "active" : null); ?>" data-interval="last7days" data-label="<?php echo _INTERVALLAST7DAYS; ?>"><?php echo _INTERVALLAST7DAYS; ?></a>
<a href="./payments.php?interval=last30days" class="dropdown-item pointer <?php echo (getInterval() == "last30days" ? "active" : null); ?>" data-interval="last30days" data-label="<?php echo _INTERVALLAST30DAYS; ?>"><?php echo _INTERVALLAST30DAYS; ?></a>
<a href="./payments.php?interval=last6months" class="dropdown-item pointer <?php echo (getInterval() == "last6months" ? "active" : null); ?>" data-interval="last6months" data-label="<?php echo _INTERVALLAST6MONTHS; ?>"><?php echo _INTERVALLAST6MONTHS; ?></a>
<a href="./payments.php?interval=lastyear" class="dropdown-item pointer <?php echo (getInterval() == "lastyear" ? "active" : null); ?>" data-interval="lastyear" data-label="<?php echo _INTERVALLASTYEAR; ?>"><?php echo _INTERVALLASTYEAR; ?></a>
<a href="./payments.php?interval=alltime" class="dropdown-item pointer <?php echo (getInterval() == "alltime" ? "active" : null); ?>" data-interval="alltime" data-label="<?php echo _INTERVALALLTIME; ?>"><?php echo _INTERVALALLTIME; ?></a>
</div>
</div>

</div>

</div>

</div>

<div class="row">

<div class="col-6 col-sm-6 col-md-4 col-lg-4">
<div class="block counter-block mb-4">
<i class="dripicons-wallet i-icon"></i>
<p class="label"><?php echo _EARNINGS; ?></p>
<div class="value"><?php echo getPrice($earnings['total_earnings']); ?> </div>
</div>
</div>

<div class="col-6 col-sm-6 col-md-4 col-lg-4">
<div class="block counter-block mb-4">
<i class="dripicons-card i-icon"></i>
<p class="label"><?php echo _PAYMENTS; ?></p>
<div class="value"><?php echo countFormat($earnings['total_payments']); ?> </div>
</div>
</div>

<div class="col-6 col-sm-6 col-md-4 col-lg-4">
<div class="block counter-block mb-4">
<i class="dripicons-card i-icon"></i>
<p class="label"><?php echo _TABLEFIELDACTIVESUBSCRIPTIONS; ?></p>
<div class="value"><?php echo countFormat($active_users['total']); ?></div>
</div>
</div>

</div>

<div class="block table-block mb-4 c-4">

<div class="row">
<div class="table-responsive">

<table id="table_id" class="table table-striped table-bordered" cellspacing="0" width="100%" style="border-radius: 5px;">
  <thead>
  <tr>
  <th><?php echo _TABLEFIELDID; ?></th>
  <th><?php echo _TABLEFIELDUSEREMAIL; ?></th>
  <th><?php echo _TABLEFIELDMETHOD; ?></th>
  <th><?php echo _TABLEFIELDPLAN; ?></th>
  <th><?php echo _TABLEFIELDAMOUNT; ?></th>
  <th><?php echo _TABLEFIELDCURRENCY; ?></th>
  <th><?php echo _TABLEFIELDSTATUS; ?></th>
  <th><?php echo _TABLEFIELDDATE; ?></th>
  <th><?php echo _TABLEFIELDACTIONS; ?></th>
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
</section>
<?php require 'footer.php'; ?>